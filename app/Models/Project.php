<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'slug',
    'short_description',
    'description',
    'image',
    'status',
    'is_featured',
    'start_date',
    'end_date',
    'goal_amount',
    'display_order',
])]
class Project extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ProjectStatus::class,
            'is_featured' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
            'goal_amount' => 'decimal:2',
            'display_order' => 'integer',
        ];
    }
}
