<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

#[Fillable([
    'email',
    'code_hash',
    'attempts',
    'expires_at',
    'verified_at',
])]
class InternshipEmailVerification extends Model
{
    /**
     * How long a code stays valid after being issued.
     */
    public const CODE_LIFETIME_MINUTES = 15;

    /**
     * How long a successful verification stays usable to submit the application
     * form -- long enough to fill in the rest of the form without feeling rushed,
     * short enough that a verification can't be reused much later for an unrelated
     * submission.
     */
    public const VERIFIED_WINDOW_MINUTES = 60;

    /**
     * Failed attempts allowed against one issued code before it's locked out and a
     * fresh one must be requested -- a simple brute-force guard on a 6-digit code.
     */
    public const MAX_ATTEMPTS = 5;

    protected function casts(): array
    {
        return [
            'attempts' => 'integer',
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Issue a fresh 6-digit code for this email, replacing any previous one.
     * Returns [model, plainCode] -- the plain code exists only transiently, for the
     * notification to send; only its hash is ever stored.
     *
     * @return array{0: self, 1: string}
     */
    public static function issueFor(string $email): array
    {
        $plainCode = (string) random_int(100000, 999999);

        $record = self::updateOrCreate(
            ['email' => $email],
            [
                'code_hash' => Hash::make($plainCode),
                'attempts' => 0,
                'expires_at' => now()->addMinutes(self::CODE_LIFETIME_MINUTES),
                'verified_at' => null,
            ]
        );

        return [$record, $plainCode];
    }

    /**
     * Attempt to verify the given email + code. Returns true and marks the record
     * verified on success; false on a wrong code, an expired code, no pending code
     * for that email, or too many failed attempts.
     */
    public static function attempt(string $email, string $code): bool
    {
        $record = self::query()->where('email', $email)->first();

        if (! $record || $record->expires_at->isPast() || $record->attempts >= self::MAX_ATTEMPTS) {
            return false;
        }

        if (! Hash::check($code, $record->code_hash)) {
            $record->increment('attempts');

            return false;
        }

        $record->forceFill(['verified_at' => now()])->save();

        return true;
    }

    /**
     * The verification record for this email if it was verified recently enough to
     * still be usable for submitting an application, or null otherwise. Used by the
     * application submission endpoint as the final server-side gate -- the form
     * having shown "verified" client-side is never trusted on its own.
     */
    public static function recentlyVerified(string $email): ?self
    {
        return self::query()
            ->where('email', $email)
            ->whereNotNull('verified_at')
            ->where('verified_at', '>=', now()->subMinutes(self::VERIFIED_WINDOW_MINUTES))
            ->first();
    }
}
