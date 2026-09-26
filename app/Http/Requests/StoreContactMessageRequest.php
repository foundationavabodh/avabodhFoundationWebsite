<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates a public "Send Us A Message" submission on the /contact page.
 * Mirrors the same FormRequest + inline @error/old() pattern already used by
 * StoreInternshipApplicationRequest, just without the email-verification step
 * (this form has no such step).
 */
class StoreContactMessageRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // Field is named "number" (not "phone") to match the existing
            // form markup in resources/views/pages/contact.blade.php.
            'number' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'number.regex' => 'Please enter a valid phone number.',
            'message.required' => 'Please enter a message.',
            'message.min' => 'Your message is too short -- please add a few more details.',
            'message.max' => 'Your message is too long (max 5000 characters).',
        ];
    }
}
