<?php

namespace App\Models;

use App\Enums\InternshipStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

#[Fillable([
    'domain_id',
    'title',
    'slug',
    'short_description',
    'description',
    'duration',
    'commitment',
    'skills_required',
    'image',
    'status',
    'display_order',
])]
class Internship extends Model
{
    /**
     * Matches the `status` column's database-level default -- see
     * InternshipApplication's identical property for why this matters.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'draft',
    ];

    protected function casts(): array
    {
        return [
            'status' => InternshipStatus::class,
            'display_order' => 'integer',
        ];
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(InternshipDomain::class, 'domain_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class);
    }

    /**
     * `skills_required` is stored as free-text, comma-separated (see the migration's
     * reasoning for not using a full skills taxonomy table). This splits it back into
     * a clean list for display on the public opportunity cards/detail page.
     */
    public function getSkillsListAttribute(): Collection
    {
        return collect(explode(',', (string) $this->skills_required))
            ->map(fn (string $skill) => trim($skill))
            ->filter()
            ->values();
    }
}
