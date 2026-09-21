<?php

namespace App\Models;

use App\Enums\SliderTextAnimation;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'image',
    'subtitle',
    'title',
    'description',
    'button_text',
    'button_url',
    'text_animation',
    'is_active',
    'display_order',
])]
class Slider extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'text_animation' => SliderTextAnimation::class,
            'is_active' => 'boolean',
            'display_order' => 'integer',
        ];
    }
}
