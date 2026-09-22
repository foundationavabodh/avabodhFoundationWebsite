<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'is_active',
    'display_order',
])]
class InternshipDomain extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class, 'domain_id');
    }

    /**
     * Applications whose applicant named this as their preferred domain (distinct
     * from the specific internship they applied to -- see InternshipApplication).
     */
    public function preferredByApplications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class, 'preferred_domain_id');
    }
}
