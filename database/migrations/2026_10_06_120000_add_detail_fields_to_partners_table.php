<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Public URL of the partner's own detail page (/ngo/{slug}).
            $table->string('slug')->nullable()->unique()->after('name');
            // Long-form "About" content shown on the detail page (rich text).
            // Optional: the page falls back to the short card description.
            $table->longText('details')->nullable()->after('description');
            // Bullet-style focus areas / activities, stored as a JSON array of strings.
            $table->json('focus_areas')->nullable()->after('details');
            $table->string('website_url')->nullable()->after('location');
            $table->string('contact_email')->nullable()->after('website_url');
            $table->string('contact_phone', 50)->nullable()->after('contact_email');
            $table->text('address')->nullable()->after('contact_phone');
            $table->unsignedSmallInteger('established_year')->nullable()->after('address');
        });

        // Give every existing partner a slug so its detail page works immediately.
        $used = [];
        foreach (DB::table('partners')->orderBy('id')->get(['id', 'name']) as $partner) {
            $base = Str::slug($partner->name) ?: 'partner';
            $slug = $base;
            $i = 2;
            while (in_array($slug, $used, true)) {
                $slug = $base.'-'.$i++;
            }
            $used[] = $slug;
            DB::table('partners')->where('id', $partner->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'slug',
                'details',
                'focus_areas',
                'website_url',
                'contact_email',
                'contact_phone',
                'address',
                'established_year',
            ]);
        });
    }
};
