<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Optional partner logo, uploaded via the "NGO Network Partners" admin
            // resource (storage/app/public/partners, same disk/pattern as
            // Slider::$image and WebsiteSetting::$logo). Nullable: the public /ngo
            // page falls back to a placeholder icon when a partner has none set.
            $table->string('logo')->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};
