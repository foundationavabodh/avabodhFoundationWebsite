<?php

namespace App\Models;

use App\Enums\PartnerCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'category',
    'logo',
    'badge_label',
    'name',
    'tag_line',
    'description',
    'location',
    'is_active_network',
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
            'is_active_network' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    /**
     * Partners currently shown on the public NGO network page, in display order.
     * Mirrors the same is_active/display_order convention already used by Slider.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active_network', true)->orderBy('display_order');
    }
}
