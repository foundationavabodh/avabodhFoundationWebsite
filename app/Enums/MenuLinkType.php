<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MenuLinkType: string implements HasLabel
{
    // A named Laravel route (e.g. "projects.index") -- resolved via route() at render
    // time, so the link automatically tracks that route's URL if it ever changes.
    case Route = 'route';

    // A raw internal path or page (e.g. "/about" or "about.html") -- used as-is.
    case Path = 'path';

    // A full external URL (e.g. "https://example.com") -- used as-is.
    case External = 'external';

    public function getLabel(): string
    {
        return match ($this) {
            self::Route => 'Internal route',
            self::Path => 'Internal page / path',
            self::External => 'External URL',
        };
    }
}
