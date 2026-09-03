<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'slug',
    'short_description',
    'description',
    'image',
    'event_date',
    'start_time',
    'end_time',
    'location',
    'status',
    'is_featured',
    'display_order',
])]
class Event extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * Note: `start_time` and `end_time` are intentionally left uncast.
     * They are plain TIME columns with no date component; Laravel's
     * built-in `datetime` cast would silently anchor them to "today"
     * when read back as Carbon instances, which would misrepresent
     * the data. They're read/written as plain "HH:MM:SS" strings, and
     * can be formatted with Carbon at the point of use if needed.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => EventStatus::class,
            'is_featured' => 'boolean',
            'event_date' => 'date',
            'display_order' => 'integer',
        ];
    }
}
