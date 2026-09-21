<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            // Self-referencing parent for one level of submenu nesting (see
            // App\Models\MenuItem::children()/parent()). Cascade delete so removing a
            // parent menu also removes its submenu items rather than orphaning them.
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('menu_items')
                ->cascadeOnDelete();

            $table->string('label');

            // One of App\Enums\MenuLinkType: 'route' (a named Laravel route), 'path'
            // (an internal path/page, e.g. /about or about.html), or 'external' (a
            // full external URL). Which of route_name/url is used depends on this.
            $table->string('link_type', 20)->default('path');

            // Used when link_type is 'route' -- a named route (e.g. "projects.index").
            $table->string('route_name')->nullable();

            // Used when link_type is 'path' or 'external' -- a raw path or full URL.
            $table->string('url')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('open_in_new_tab')->default(false);

            $table->timestamps();

            $table->index(['parent_id', 'sort_order']);
            $table->index(['is_active', 'sort_order']);
        });

        // Migrate the current hard-coded main navigation (resources/views/components/
        // navbar.blade.php) into the database so the public navbar keeps rendering the
        // exact same links immediately after this migration runs -- no admin action
        // required before the site looks the same as before. Destinations that don't
        // have a real route yet (About Us, Contact Us, and the template's placeholder
        // "Pages"/"Blog" demo links) are preserved as their original raw href so
        // nothing that currently exists is silently dropped; a "Projects" item is
        // added since /projects is a real, working route that wasn't linked from the
        // main nav yet. The template's third level of nesting under "Pages" (e.g.
        // Cause > Our Cause / Cause Details) is flattened to one level -- see the
        // implementation report for why.
        $now = now();

        $topLevel = [
            ['label' => 'Home', 'link_type' => 'route', 'route_name' => 'home', 'url' => null, 'sort_order' => 0],
            ['label' => 'About Us', 'link_type' => 'path', 'route_name' => null, 'url' => 'about.html', 'sort_order' => 1],
            ['label' => 'Projects', 'link_type' => 'route', 'route_name' => 'projects.index', 'url' => null, 'sort_order' => 2],
            ['label' => 'Pages', 'link_type' => 'path', 'route_name' => null, 'url' => 'news-details.html', 'sort_order' => 3],
            ['label' => 'Blog', 'link_type' => 'path', 'route_name' => null, 'url' => 'news-details.html', 'sort_order' => 4],
            ['label' => 'Contact Us', 'link_type' => 'path', 'route_name' => null, 'url' => 'contact.html', 'sort_order' => 5],
        ];

        $topLevelIds = [];
        foreach ($topLevel as $item) {
            $topLevelIds[$item['label']] = DB::table('menu_items')->insertGetId(array_merge($item, [
                'parent_id' => null,
                'is_active' => true,
                'open_in_new_tab' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        $children = [
            'Pages' => [
                ['label' => 'Cause', 'url' => 'project-details.html'],
                ['label' => 'Volunteer', 'url' => 'volounteer-details.html'],
                ['label' => 'Event', 'url' => 'event-details.html'],
                ['label' => 'Donation', 'url' => 'donation-details.html'],
                ['label' => 'Our Pricing', 'url' => 'pricing.html'],
                ['label' => 'Our Faq', 'url' => 'faq.html'],
                ['label' => '404 Page', 'url' => '404.html'],
            ],
            'Blog' => [
                ['label' => 'Blog Grid', 'url' => 'news-grid.html'],
                ['label' => 'Blog Standard', 'url' => 'news.html'],
                ['label' => 'Blog Details', 'url' => 'news-details.html'],
            ],
        ];

        foreach ($children as $parentLabel => $items) {
            foreach ($items as $index => $item) {
                DB::table('menu_items')->insert([
                    'parent_id' => $topLevelIds[$parentLabel],
                    'label' => $item['label'],
                    'link_type' => 'path',
                    'route_name' => null,
                    'url' => $item['url'],
                    'sort_order' => $index,
                    'is_active' => true,
                    'open_in_new_tab' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
