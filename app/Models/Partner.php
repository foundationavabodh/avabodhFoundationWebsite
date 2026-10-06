<?php

namespace App\Models;

use App\Enums\PartnerApprovalStatus;
use App\Enums\PartnerCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable([
    'category',
    'logo',
    'badge_label',
    'name',
    'slug',
    'tag_line',
    'description',
    'details',
    'focus_areas',
    'location',
    'website_url',
    'contact_email',
    'contact_phone',
    'address',
    'established_year',
    'legal_name',
    'registration_details',
    'tax_certifications',
    'founder_name',
    'contact_person',
    'social_links',
    'operating_address',
    'mission',
    'vision',
    'ongoing_projects',
    'achievements',
    'cover_image',
    'gallery',
    'video_url',
    'brochure_url',
    'bank_account_holder',
    'bank_name',
    'bank_branch',
    'bank_account_number',
    'bank_ifsc',
    'upi_id',
    'upi_qr_image',
    'donor_tax_benefit',
    'is_active_network',
    'approval_status',
    'reviewed_at',
    'display_order',
])]
class Partner extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => PartnerCategory::class,
            'focus_areas' => 'array',
            'social_links' => 'array',
            'gallery' => 'array',
            'established_year' => 'integer',
            'is_active_network' => 'boolean',
            'approval_status' => PartnerApprovalStatus::class,
            'reviewed_at' => 'datetime',
            'display_order' => 'integer',
        ];
    }

    /**
     * Make sure every partner has a unique slug for its public detail page
     * (/ngo/{slug}), generated from the name when the admin leaves it empty.
     */
    protected static function booted(): void
    {
        static::saving(function (Partner $partner) {
            if (blank($partner->slug)) {
                $base = Str::slug($partner->name) ?: 'partner';
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->whereKeyNot($partner->getKey() ?? 0)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $partner->slug = $slug;
            }

            // Keep "listed on the website" in step with the review decision: approving
            // lists the NGO, anything else (pending / rejected) hides it.
            if ($partner->isDirty('approval_status')) {
                if ($partner->exists) {
                    $partner->is_active_network = $partner->approval_status === PartnerApprovalStatus::Approved;
                    $partner->reviewed_at = now();
                } elseif ($partner->approval_status !== PartnerApprovalStatus::Approved) {
                    // A brand-new pending/rejected record is never listed.
                    $partner->is_active_network = false;
                }
            }
        });
    }

    /**
     * NGOs waiting for an admin to review them.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('approval_status', PartnerApprovalStatus::Pending->value);
    }

    /**
     * Partners currently shown on the public NGO network page, in display order.
     * Mirrors the same is_active/display_order convention already used by Slider.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active_network', true)
            ->where('approval_status', PartnerApprovalStatus::Approved->value)
            ->orderBy('display_order');
    }
}
