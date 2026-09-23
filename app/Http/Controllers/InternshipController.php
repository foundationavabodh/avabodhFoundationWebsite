<?php

namespace App\Http\Controllers;

use App\Enums\InternshipStatus;
use App\Http\Requests\StoreInternshipApplicationRequest;
use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\InternshipDomain;
use App\Models\InternshipEmailVerification;
use App\Notifications\InternshipEmailVerificationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class InternshipController extends Controller
{
    /**
     * Public /internships page: hero, open positions (published internships only),
     * and the apply form. All three sections live on this one page/view, matching
     * the task's specified page structure.
     */
    public function index()
    {
        $internships = Internship::query()
            ->where('status', InternshipStatus::Published)
            ->with('domain')
            ->orderBy('display_order')
            ->orderByDesc('created_at')
            ->get();

        $domains = InternshipDomain::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('pages.internships.index', [
            'internships' => $internships,
            'domains' => $domains,
        ]);
    }

    /**
     * Step 1 of email verification (Part 3): issue and mail a 6-digit code for the
     * given email. Always responds success for a syntactically valid email address,
     * whether or not that address has applied before, so this can't be used to
     * enumerate past applicants.
     */
    public function sendVerificationCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Please enter a valid email address.'], 422);
        }

        $email = $request->string('email')->toString();

        [, $code] = InternshipEmailVerification::issueFor($email);

        try {
            Notification::route('mail', $email)->notify(new InternshipEmailVerificationCode($code));
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'We couldn\'t send a verification email right now. Please try again shortly.',
            ], 500);
        }

        return response()->json([
            'message' => 'A verification code has been sent to your email.',
        ]);
    }

    /**
     * Step 2 of email verification: check the code the applicant entered. On
     * success, InternshipEmailVerification::attempt() marks it verified; the
     * actual application submission re-checks this server-side (see
     * StoreInternshipApplicationRequest), so this endpoint is a UX convenience,
     * not the security boundary itself.
     */
    public function confirmVerificationCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'code' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['verified' => false, 'message' => 'Please enter the code sent to your email.'], 422);
        }

        $verified = InternshipEmailVerification::attempt(
            $request->string('email')->toString(),
            $request->string('code')->toString(),
        );

        if (! $verified) {
            return response()->json([
                'verified' => false,
                'message' => 'That code is incorrect or has expired. Please request a new one.',
            ], 422);
        }

        return response()->json([
            'verified' => true,
            'message' => 'Email verified.',
        ]);
    }

    /**
     * Final application submission. Only reachable once StoreInternshipApplicationRequest's
     * validation (including the "email was recently verified" and "internship is
     * published" checks) passes.
     */
    public function store(StoreInternshipApplicationRequest $request): RedirectResponse
    {
        $verification = InternshipEmailVerification::recentlyVerified($request->validated('email'));

        $application = InternshipApplication::create([
            ...$request->safe()->only([
                'internship_id',
                'full_name',
                'email',
                'phone',
                'preferred_domain_id',
                'college_name',
                'address',
                'skills',
            ]),
            'email_verified_at' => $verification?->verified_at ?? now(),
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('internships.index')
            ->with('applicationSubmitted', [
                'application_id' => $application->application_id,
                'internship_title' => $application->internship->title,
            ]);
    }
}
