<?php

namespace App\Http\Controllers;

use App\Enums\PartnerApprovalStatus;
use App\Enums\PartnerCategory;
use App\Filament\Admin\Resources\Partners\PartnerResource;
use App\Http\Requests\StorePartnerRegistrationRequest;
use App\Models\Partner;
use App\Models\WebsiteSetting;
use App\Notifications\PartnerRegistrationSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;

class PartnerRegistrationController extends Controller
{
    /**
     * Public "Register your NGO" form (the NGO Information Collection Form).
     */
    public function create()
    {
        return view('pages.ngo-register');
    }

    /**
     * Saves the submission as a *pending* partner. It stays hidden from the public
     * NGO network until an admin approves it in the admin panel.
     */
    public function store(StorePartnerRegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $gallery = [];
        foreach ((array) $request->file('gallery', []) as $i => $file) {
            if ($file instanceof UploadedFile) {
                $gallery[] = [
                    'image' => $file->store('partners/gallery', 'public'),
                    'caption' => trim((string) ($data['gallery_captions'][$i] ?? '')),
                ];
            }
        }

        $social = array_filter((array) ($data['social_links'] ?? []));
        $focus = collect(preg_split('/[,\n]+/', $data['focus_sectors']))
            ->map(fn ($s) => trim($s))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $partner = Partner::create([
            // Registered NGOs start as plain "NGO Collaborators"; an admin can change
            // the category / badge when approving.
            'category' => PartnerCategory::Ngo,
            'badge_label' => 'NGO Collaborator',
            'name' => filled($data['display_name'] ?? null) ? $data['display_name'] : $data['legal_name'],
            'legal_name' => $data['legal_name'],
            'tag_line' => $data['tag_line'],
            'description' => $data['description'],
            'details' => $this->paragraphs($data['details']),
            'mission' => $data['mission'],
            'vision' => $data['vision'] ?? null,
            'ongoing_projects' => $this->paragraphs($data['ongoing_projects'] ?? null),
            'achievements' => $this->paragraphs($data['achievements'] ?? null),
            'focus_areas' => $focus,
            'location' => $data['location'],
            'established_year' => $data['established_year'],
            'registration_details' => $data['registration_details'],
            'tax_certifications' => $data['tax_certifications'] ?? null,
            'founder_name' => $data['founder_name'],
            'contact_person' => $data['contact_person'],
            'contact_phone' => $data['contact_phone'],
            'contact_email' => $data['contact_email'],
            'website_url' => $data['website_url'] ?? null,
            'social_links' => $social ?: null,
            'address' => $data['address'],
            'operating_address' => $data['operating_address'] ?? null,
            'logo' => $request->hasFile('logo') ? $request->file('logo')->store('partners', 'public') : null,
            'cover_image' => $request->hasFile('cover_image') ? $request->file('cover_image')->store('partners/covers', 'public') : null,
            'gallery' => $gallery ?: null,
            'video_url' => $data['video_url'] ?? null,
            'brochure_url' => $data['brochure_url'] ?? null,
            'bank_account_holder' => $data['bank_account_holder'] ?? null,
            'bank_name' => $data['bank_name'] ?? null,
            'bank_branch' => $data['bank_branch'] ?? null,
            'bank_account_number' => $data['bank_account_number'] ?? null,
            'bank_ifsc' => isset($data['bank_ifsc']) ? strtoupper($data['bank_ifsc']) : null,
            'upi_id' => $data['upi_id'] ?? null,
            'upi_qr_image' => $request->hasFile('upi_qr_image') ? $request->file('upi_qr_image')->store('partners/qr', 'public') : null,
            'donor_tax_benefit' => $data['donor_tax_benefit'] ?? null,
            // Hidden from the public site until approved (see Partner::booted()).
            'is_active_network' => false,
            'approval_status' => PartnerApprovalStatus::Pending,
            'display_order' => ((int) Partner::max('display_order')) + 1,
        ]);

        // Tell the foundation there's something to review. A mail problem must not
        // lose the registration (it's already saved), so it's only reported.
        try {
            $reviewUrl = null;
            try {
                $reviewUrl = PartnerResource::getUrl('edit', ['record' => $partner]);
            } catch (\Throwable) {
                // Admin URL is only a convenience link in the email.
            }

            Notification::route('mail', WebsiteSetting::current()->header_email ?: 'info@donat.com')
                ->notify(new PartnerRegistrationSubmitted($partner, $reviewUrl));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()
            ->route('ngo.register')
            ->with('ngoRegistered', $partner->name);
    }

    /**
     * Plain text from the form -> simple HTML paragraphs for the rich-text columns
     * (escaped first, so visitors can't inject markup).
     */
    private function paragraphs(?string $text): ?string
    {
        if (blank($text)) {
            return null;
        }

        return collect(preg_split('/\R{2,}/', trim($text)))
            ->map(fn ($p) => '<p>'.nl2br(e(trim($p))).'</p>')
            ->implode('');
    }
}
