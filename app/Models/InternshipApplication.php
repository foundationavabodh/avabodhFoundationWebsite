<?php

namespace App\Models;

use App\Enums\InternshipApplicationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'application_id',
    'internship_id',
    'full_name',
    'email',
    'email_verified_at',
    'country_code',
    'phone',
    'preferred_domain_id',
    'college_name',
    'address',
    'skills',
    'status',
    'notes',
    'submitted_at',
])]
class InternshipApplication extends Model
{
    /**
     * Characters used for the random part of application_id. Uppercase letters and
     * digits, with visually ambiguous ones removed (0/O, 1/I/L) so an applicant can
     * read a code back over the phone or retype it without confusion.
     */
    private const ID_ALPHABET = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';

    /**
     * Matches the `status` column's database-level default. Without this, a freshly
     * created model only reflects that default after an explicit refresh/fresh()
     * call -- Eloquent doesn't re-fetch after INSERT -- so ->status would read as
     * null in the same request the application was just submitted in (the same
     * pitfall WebsiteSetting::current()'s own code comments call out).
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    protected function casts(): array
    {
        return [
            'status' => InternshipApplicationStatus::class,
            'email_verified_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    /**
     * The applicant's stated general domain of interest -- may differ from the
     * specific internship() they applied to.
     */
    public function preferredDomain(): BelongsTo
    {
        return $this->belongsTo(InternshipDomain::class, 'preferred_domain_id');
    }

    /**
     * Generate a unique, applicant-facing application id in the form "AVB-INT-XXXX".
     * Retries on the astronomically unlikely event of a collision.
     */
    public static function generateApplicationId(): string
    {
        do {
            $candidate = 'AVB-INT-'.self::randomCode(4);
        } while (self::query()->where('application_id', $candidate)->exists());

        return $candidate;
    }

    /**
     * A random string of the given length drawn from ID_ALPHABET. Str::random()
     * isn't used here since it draws from base64's alphabet (mixed case, no
     * exclusions), not the restricted, unambiguous set we want for a code
     * applicants may need to read or retype.
     */
    private static function randomCode(int $length): string
    {
        $alphabetLength = strlen(self::ID_ALPHABET);
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= self::ID_ALPHABET[random_int(0, $alphabetLength - 1)];
        }

        return $code;
    }

    protected static function booted(): void
    {
        static::creating(function (self $application) {
            if (blank($application->application_id)) {
                $application->application_id = self::generateApplicationId();
            }
        });
    }
}
