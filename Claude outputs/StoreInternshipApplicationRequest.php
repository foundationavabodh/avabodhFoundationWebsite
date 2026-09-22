<?php

namespace App\Http\Requests;

use App\Enums\InternshipStatus;
use App\Models\Internship;
use App\Models\InternshipEmailVerification;
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

            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'country_code' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:30'],
            'preferred_domain_id' => ['nullable', 'integer', 'exists:internship_domains,id'],
            'college_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'skills' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $internship = Internship::find($this->input('internship_id'));

            if ($internship && $internship->status !== InternshipStatus::Published) {
                $validator->errors()->add('internship_id', 'This internship is no longer accepting applications.');
            }

            $email = $this->input('email');

            if ($email && ! InternshipEmailVerification::recentlyVerified($email)) {
                $validator->errors()->add('email', 'Please verify this email address before submitting your application.');
            }
        });
    }
}
