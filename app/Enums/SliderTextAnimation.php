<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * A curated subset of the animate.css entrance effects already bundled with the
 * site (public/assets/css/animate.css) and already wired up for the homepage's
 * hero-slider via main.js's animated_swiper() -- which reads a `data-animation`
 * attribute off each text element and re-triggers the matching animate.css class
 * whenever the slide becomes active. Kept to a short, designer-friendly list
 * rather than exposing all ~80 animate.css classes.
 */
enum SliderTextAnimation: string implements HasLabel
{
    case FadeInUp = 'fadeInUp';
    case FadeInDown = 'fadeInDown';
    case FadeInLeft = 'fadeInLeft';
    case FadeInRight = 'fadeInRight';
    case ZoomIn = 'zoomIn';
    case BounceIn = 'bounceIn';
    case SlideInUp = 'slideInUp';
    case FlipInX = 'flipInX';

    public function getLabel(): string
    {
        return match ($this) {
            self::FadeInUp => 'Fade In Up',
            self::FadeInDown => 'Fade In Down',
            self::FadeInLeft => 'Fade In Left',
            self::FadeInRight => 'Fade In Right',
            self::ZoomIn => 'Zoom In',
            self::BounceIn => 'Bounce In',
            self::SlideInUp => 'Slide In Up',
            self::FlipInX => 'Flip In X',
        };
    }
}
