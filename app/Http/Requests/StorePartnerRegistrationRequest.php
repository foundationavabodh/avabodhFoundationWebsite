<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates a public NGO registration (the "NGO Information Collection Form" on
 * /ngo/register). The submission is saved as a pending partner for admin review,
 * so only the details needed to review and list an NGO are required; media and
 * donation details are optional.
 */
class StorePartnerRegistrationRequest extends FormRequest
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
        $images = ['image', 'mimes:jpg,jpeg,png,webp'];

        return [
            // Honeypot: real visitors never see or fill this; bots usually do.
            'company_website' => ['nullable', 'max:0'],

            // Section 1: basic & legal identity
            'legal_name' => ['required', 'string', 'min:3', 'max:255'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'established_year' => ['required', 'integer', 'min:1800', 'max:'.date('Y')],
            'registration_details' => ['required', 'string', 'max:255'],
            'tax_certifications' => ['nullable', 'string', 'max:255'],
            'focus_sectors' => ['required', 'string', 'max:500'],
            'tag_line' => ['required', 'string', 'max:255'],

            // Section 2: contact & key personnel
            'founder_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'regex:/^[0-9+\-\s()]{10,20}$/'],
            'contact_email' => [
                'required', 'email', 'max:255',
                // One pending/approved registration per email address.
                Rule::unique('partners', 'contact_email')->where(fn ($q) => $q->whereIn('approval_status', ['pending', 'approved'])),
            ],
            'website_url' => ['nullable', 'url', 'max:255'],
            'social_links' => ['nullable', 'array'],
            'social_links.facebook' => ['nullable', 'url', 'max:255'],
            'social_links.instagram' => ['nullable', 'url', 'max:255'],
            'social_links.linkedin' => ['nullable', 'url', 'max:255'],
            'social_links.youtube' => ['nullable', 'url', 'max:255'],
            'social_links.x' => ['nullable', 'url', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'location' => ['required', 'string', 'max:255'],
            'operating_address' => ['nullable', 'string', 'max:1000'],

            // Section 3: about the organisation
            'description' => ['required', 'string', 'min:20', 'max:500'],
            'mission' => ['required', 'string', 'min:10', 'max:2000'],
            'vision' => ['nullable', 'string', 'max:2000'],
            'details' => ['required', 'string', 'min:30', 'max:10000'],
            'ongoing_projects' => ['nullable', 'string', 'max:10000'],
            'achievements' => ['nullable', 'string', 'max:10000'],

            // Section 4: media & visual assets
            'logo' => array_merge(['nullable', 'max:2048'], $images),
            'cover_image' => array_merge(['nullable', 'max:4096'], $images),
            'gallery' => ['nullable', 'array', 'max:5'],
            'gallery.*' => array_merge(['nullable', 'max:4096'], $images),
            'gallery_captions' => ['nullable', 'array', 'max:5'],
            'gallery_captions.*' => ['nullable', 'string', 'max:255'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'brochure_url' => ['nullable', 'url', 'max:255'],

            // Section 5: donation & bank details (all optional)
            'bank_account_holder' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_branch' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'regex:/^[0-9]{6,20}$/'],
            'bank_ifsc' => ['nullable', 'regex:/^([A-Za-z]{4}0[A-Za-z0-9]{6}|[A-Za-z0-9]{8,11})$/'],
            'upi_id' => ['nullable', 'regex:/^[\w.\-]{2,}@[A-Za-z]{2,}$/'],
            'upi_qr_image' => array_merge(['nullable', 'max:2048'], $images),
            'donor_tax_benefit' => ['nullable', 'string', 'max:1000'],

            'consent' => ['accepted'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'company_website.max' => 'Something went wrong. Please try again.',
            'legal_name.required' => 'Please enter your NGO\'s full legal name.',
            'established_year.required' => 'Please enter the year your NGO was established.',
            'established_year.min' => 'Please enter a valid year of establishment.',
            'established_year.max' => 'The year of establishment cannot be in the future.',
            'registration_details.required' => 'Please enter your registration number and type.',
            'focus_sectors.required' => 'Please list at least one focus sector (e.g. Education, Healthcare).',
            'tag_line.required' => 'Please enter a short tagline.',
            'founder_name.required' => 'Please enter the founder / president / director\'s name and designation.',
            'contact_person.required' => 'Please enter a primary contact person.',
            'contact_phone.required' => 'Please enter an official contact number.',
            'contact_phone.regex' => 'Please enter a valid contact number.',
            'contact_email.required' => 'Please enter the official email address.',
            'contact_email.email' => 'Please enter a valid email address.',
            'contact_email.unique' => 'An NGO has already been registered with this email address.',
            'address.required' => 'Please enter the registered address.',
            'location.required' => 'Please enter the city and state.',
            'description.required' => 'Please enter a short summary for the listing card.',
            'description.min' => 'The short summary is too short -- please write at least a full sentence.',
            'mission.required' => 'Please enter your mission statement.',
            'details.required' => 'Please tell us about your organisation.',
            'details.min' => 'Please add a little more detail about your organisation.',
            'logo.image' => 'The logo must be an image (JPG, PNG or WebP).',
            'logo.max' => 'The logo must be 2 MB or smaller.',
            'cover_image.max' => 'The cover image must be 4 MB or smaller.',
            'gallery.max' => 'You can upload up to 5 photos.',
            'gallery.*.image' => 'Each photo must be an image (JPG, PNG or WebP).',
            'gallery.*.max' => 'Each photo must be 4 MB or smaller.',
            'upi_qr_image.max' => 'The QR code image must be 2 MB or smaller.',
            'bank_account_number.regex' => 'Please enter a valid account number (digits only).',
            'bank_ifsc.regex' => 'Please enter a valid IFSC / SWIFT code.',
            'upi_id.regex' => 'Please enter a valid UPI ID (e.g. name@bank).',
            'consent.accepted' => 'Please confirm that the information is correct and may be published.',
        ];
    }
}
