<?php

namespace App\Http\Requests;

use App\Enums\InternshipStatus;
use App\Models\Internship;
use App\Models\InternshipApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreInternshipApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            // exists:internships,id alone isn't enough -- withValidator() below also
            // rejects a technically-existing internship that isn't published, so an
            // applicant can never submit against an unpublished/closed one.
            'internship_id' => ['required', 'integer', 'exists:internships,id'],

            'full_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[\pL\s.\'-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // country_code was dropped from the public form -- the column stays in
            // the database (nullable, always null going forward) so no migration is
            // needed and any pre-existing rows are unaffected.
            // Required + exactly 10 digits, same rule as the public contact form.
            'phone' => ['required', 'digits:10'],
            'preferred_domain_id' => ['nullable', 'integer', 'exists:internship_domains,id'],
            // college_name is a <select> of common local colleges plus an "Other"
            // option; when "Other" is chosen, college_name_other holds the actual
            // free-text name the applicant typed (see InternshipController@store,
            // which swaps it in before saving -- the "Other" literal itself is
            // never persisted).
            'college_name' => ['required', 'string', 'max:255'],
            'college_name_other' => ['required_if:college_name,Other', 'nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'min:10', 'max:2000'],
            'skills' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Please enter your full name.',
            'full_name.min' => 'Please enter your full name.',
            'full_name.regex' => 'Name can only contain letters, spaces, apostrophes, periods and hyphens.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your contact number.',
            'phone.digits' => 'Please enter a valid 10-digit contact number.',
            'college_name.required' => 'Please select your college.',
            'college_name_other.required_if' => 'Please enter your college name.',
            'address.required' => 'Please enter your address.',
            'address.min' => 'Please enter your full address.',
            'internship_id.required' => 'Please select an internship to apply for.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $internshipId = $this->input('internship_id');
            $internship = Internship::find($internshipId);

            if ($internship && $internship->status !== InternshipStatus::Published) {
                $validator->errors()->add('internship_id', 'This internship is no longer accepting applications.');
            }

            $email = $this->input('email');

            // One applicant applying to several different internships with the same
            // email is fine -- this only blocks a second application for the *same*
            // internship with the same email address.
            if ($email && $internshipId) {
                $alreadyApplied = InternshipApplication::query()
                    ->where('internship_id', $internshipId)
                    ->whereRaw('LOWER(email) = ?', [mb_strtolower($email)])
                    ->exists();

                if ($alreadyApplied) {
                    $validator->errors()->add('email', 'An application for this internship has already been submitted with this email address.');
                }
            }
        });
    }
}
