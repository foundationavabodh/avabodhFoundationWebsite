<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable([
    'logo',
    'site_name',
    'show_header_top_bar',
    'header_phone',
    'header_email',
    'header_address',
    'footer_description',
    'copyright_text',
    'social_twitter_url',
    'social_whatsapp_url',
    'social_instagram_url',
    'social_youtube_url',
])]
class WebsiteSetting extends Model
{
    /**
     * Cache key the singleton settings row is stored under.
     */
    public const CACHE_KEY = 'website_settings';

    /**
     * In-memory memoization of current() for the lifetime of this request/process, on top
     * of the persistent cache below -- so the header, navbar and footer (which each call
     * current() independently while rendering the same page) touch the cache store at most
     * once per request rather than once per component.
     */
    protected static ?self $memoized = null;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'show_header_top_bar' => 'boolean',
        ];
    }

    /**
     * Get the single, application-wide settings record, creating it (with all-default,
     * all-null values) the first time it's needed. Cached for the lifetime of the request
     * cycle (and beyond, until invalidated) so the public layout/header/footer -- which all
     * read settings on every page load -- don't each issue their own query.
     */
    public static function current(): self
    {
        if (static::$memoized !== null) {
            return static::$memoized;
        }

        // Cache the plain attributes array, not the Eloquent model instance itself. The
        // `database` cache driver serializes cached values, and a serialized/unserialized
        // Eloquent model does not reliably survive that round-trip (it can come back as an
        // incomplete/broken object on a cache hit). newFromBuilder() rebuilds a fully normal,
        // "exists in the database" model instance from the cached array -- the same method
        // Eloquent itself uses internally to hydrate models from query results -- so casts,
        // ->update(), etc. all work exactly as if it had just been queried.
        $attributes = Cache::rememberForever(self::CACHE_KEY, function () {
            // create([])->fresh() rather than create([]) alone: Eloquent doesn't re-fetch
            // a model after INSERT, so column defaults applied at the database level (like
            // show_header_top_bar's default true) would otherwise show as null/false in
            // memory on this very first request, even though the stored row is correct.
            $record = static::query()->first() ?: static::create([])->fresh();

            return $record->getAttributes();
        });

        return static::$memoized = (new static)->newFromBuilder($attributes);
    }

    /**
     * Forget the cached settings row. Called automatically whenever the settings are saved
     * (see booted() below) so the public site never serves stale branding after an admin
     * update, without callers having to remember to invalidate it themselves.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        static::$memoized = null;
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::clearCache());
        static::deleted(fn () => self::clearCache());
    }
}
