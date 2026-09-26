<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * The three filter tabs on the public "Our Collaborative Ecosystem" / NGO network
 * page (resources/views/pages/ngo.blade.php) -- mirrors the live
 * avabodhfoundation.org/ngo page's "Educational Partners" / "NGO Collaborators" /
 * "CSR & Corporates" tabs. A partner's badge text (Partner::$badge_label) is a
 * separate free-text field, since the real site shows different badge wording
 * for cards within the same category (e.g. "CSR & Medical Sponsor" vs "Corporate
 * CSR Partner" are both Csr) -- this enum only drives which tab a card appears
 * under and its accent color.
 */
enum PartnerCategory: string implements HasLabel
{
    case Educational = 'educational';
    case Ngo = 'ngo';
    case Csr = 'csr';

    public function getLabel(): string
    {
        return match ($this) {
            self::Educational => 'Educational Partner',
            self::Ngo => 'NGO Collaborator',
            self::Csr => 'CSR & Corporate',
        };
    }

    /**
     * Label shown on the public filter tab (plural, matches the live site's wording).
     */
    public function tabLabel(): string
    {
        return match ($this) {
            self::Educational => 'Educational Partners',
            self::Ngo => 'NGO Collaborators',
            self::Csr => 'CSR & Corporates',
        };
    }

    /**
     * Accent color (one of the site's existing CSS custom properties from
     * public/assets/css/main.css) used for this category's badge and tag-line text
     * on the public page.
     */
    public function cssVar(): string
    {
        return match ($this) {
            self::Educational => '--secondary',
            self::Ngo => '--theme',
            self::Csr => '--earth-brown',
        };
    }
}
