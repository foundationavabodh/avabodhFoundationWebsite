<?php

namespace App\Models;

use App\Enums\MenuLinkType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Validation\ValidationException;

#[Fillable([
    'parent_id',
    'label',
    'link_type',
    'route_name',
    'url',
    'sort_order',
    'is_active',
    'open_in_new_tab',
])]
class MenuItem extends Model
{
    /**
     * Cache key the built, ordered, active navigation tree is stored under.
     */
    public const CACHE_KEY = 'menu_items_tree';

    /**
     * In-memory memoization of tree() for the lifetime of this request/process, on top
     * of the persistent cache below -- mirrors WebsiteSetting::current()'s pattern so
     * the navbar (rendered on every page) touches the cache store at most once per
     * request even if the component is included more than once.
     */
    protected static ?\Illuminate\Support\Collection $memoizedTree = null;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'link_type' => MenuLinkType::class,
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'open_in_new_tab' => 'boolean',
        ];
    }

    /**
     * The top-level menu item this item is a submenu entry of, or null for a
     * top-level item itself. Only one level of nesting is supported -- a child's
     * own parent_id is always null in the current UI/design (enforced below in
     * booted()), so this never chains more than one level deep.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * This item's submenu items, in display order.
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * The href this item should point to, resolved according to its link_type.
     * Falls back to "#" for a route-type item whose named route doesn't exist
     * (e.g. it was renamed/removed in code after the menu item was created), so a
     * stale entry never throws a public-facing error -- it just becomes inert.
     */
    public function getResolvedUrlAttribute(): string
    {
        return match ($this->link_type) {
            MenuLinkType::Route => ($this->route_name && RouteFacade::has($this->route_name))
                ? route($this->route_name)
                : '#',
            MenuLinkType::Path, MenuLinkType::External => $this->url ?: '#',
            default => '#',
        };
    }

    /**
     * The full, ordered, active navigation tree: top-level active items (in
     * sort_order) with their active children (in sort_order) eager loaded. This is
     * what the public navbar renders. Cached indefinitely and invalidated
     * automatically on any menu item save/delete (see booted() below), the same
     * pattern WebsiteSetting::current() uses for the same reason -- the navbar is
     * included on every page, so it shouldn't re-query on every request.
     */
    public static function tree(): \Illuminate\Support\Collection
    {
        if (static::$memoizedTree !== null) {
            return static::$memoizedTree;
        }

        // As with WebsiteSetting::current(), cache the plain attribute arrays, not the
        // Eloquent model/collection instances themselves: the `database` cache driver
        // serializes cached values, and a serialized/unserialized Eloquent model (let
        // alone one with a loaded relation) does not reliably survive that round-trip.
        // newFromBuilder() + setRelation() below rebuild normal, fully-hydrated model
        // instances (casts, the resolved_url accessor, etc. all work) from the cached
        // arrays, the same way Eloquent hydrates models from a fresh query.
        $nodes = Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->with(['children' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                }])
                ->get()
                ->map(fn (self $item) => [
                    'attributes' => $item->getAttributes(),
                    'children' => $item->children->map(fn (self $child) => $child->getAttributes())->all(),
                ])
                ->all();
        });

        return static::$memoizedTree = collect($nodes)->map(function (array $node) {
            $item = (new static)->newFromBuilder($node['attributes']);
            $item->setRelation(
                'children',
                collect($node['children'])->map(fn (array $attributes) => (new static)->newFromBuilder($attributes))
            );

            return $item;
        });
    }

    /**
     * Forget the cached navigation tree. Called automatically whenever a menu item
     * is saved or deleted (see booted() below) so the public navbar never serves a
     * stale menu after an admin change.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        static::$memoizedTree = null;
    }

    protected static function booted(): void
    {
        static::saving(function (self $item) {
            // A menu item can never be its own parent.
            if ($item->parent_id && $item->parent_id === $item->id) {
                throw ValidationException::withMessages([
                    'parent_id' => 'A menu item cannot be its own parent.',
                ]);
            }

            // Only one level of submenu nesting is supported: a chosen parent must
            // itself be a top-level item (no parent of its own). This is also
            // enforced in the Filament form (the Parent select only offers
            // top-level items), so this is a defensive, model-level backstop
            // against circular/deep hierarchies however the record is saved.
            if ($item->parent_id) {
                $parent = self::query()->find($item->parent_id);

                if (! $parent || $parent->parent_id !== null) {
                    throw ValidationException::withMessages([
                        'parent_id' => 'A submenu item cannot itself be used as a parent (only one level of submenu is supported).',
                    ]);
                }
            }
        });

        static::saved(fn () => self::clearCache());
        static::deleted(fn () => self::clearCache());
    }
}
