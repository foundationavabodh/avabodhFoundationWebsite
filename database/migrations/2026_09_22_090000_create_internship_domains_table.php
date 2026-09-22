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
        // A managed lookup table, not a hard-coded enum: the task is explicit that
        // "Volunteer", "Website Development", etc. are examples only, and an admin
        // must be able to add future domains from the backend without a code change.
        // This also gives the public application form's "Preferred Domain" select and
        // each internship's own domain a single shared, admin-controlled vocabulary,
        // rather than letting them drift out of sync as free text.
        Schema::create('internship_domains', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();

            // Lets an admin retire a domain (hide it from new selections) without
            // deleting it and breaking existing internships/applications that
            // reference it.
            $table->boolean('is_active')->default(true);

            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'display_order']);
        });

        // Seed the example domains listed in the task so the CMS isn't empty on day
        // one -- all editable/removable/extendable from /admin/internships afterwards.
        $now = now();
        $domains = [
            'Volunteer',
            'Awareness Campaign',
            'Website Development',
            'App Development',
            'Content Writing',
            'Designing',
            'Photography',
            'Video',
            'Digital Marketing',
            'Research',
            'Fund Raising',
        ];

        foreach ($domains as $index => $name) {
            DB::table('internship_domains')->insert([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'is_active' => true,
                'display_order' => $index,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_domains');
    }
};
