<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * `website_settings` is a single-row settings table (see App\Models\WebsiteSetting::current()),
     * not a per-record CRUD resource -- there is deliberately no way to create more than one row
     * through the application, so no additional uniqueness constraint is needed here.
     */
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();

            // Logo
            $table->string('logo')->nullable();

            // Branding / <title>
            $table->string('site_name')->nullable();

            // Header
            $table->boolean('show_header_top_bar')->default(true);
            $table->string('header_phone')->nullable();
            $table->string('header_email')->nullable();
            $table->string('header_address')->nullable();

            // Footer
            $table->text('footer_description')->nullable();
            $table->string('copyright_text')->nullable();
            $table->string('social_twitter_url')->nullable();
            $table->string('social_whatsapp_url')->nullable();
            $table->string('social_instagram_url')->nullable();
            $table->string('social_youtube_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
