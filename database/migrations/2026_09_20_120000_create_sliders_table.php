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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            // One of a small, curated set of animate.css entrance effects (see
            // App\Enums\SliderTextAnimation) applied to this slide's text when the
            // hero slider transitions to it -- the homepage's hero-slider swiper
            // already reads a `data-animation` attribute per text element for exactly
            // this purpose (see public/assets/js/main.js's animated_swiper()), so no
            // new front-end plumbing is needed, only a value to feed it.
            $table->string('text_animation', 20)->default('fadeInUp');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'display_order']);
        });

        // Seed one default slide matching the hero content the homepage already shows,
        // so the hero-slider immediately has something to render (and looks identical
        // to before) the moment this migration runs -- no admin action required before
        // the homepage works. `image` is left null; the homepage falls back to the
        // existing self-hosted assets/img/home-2/hero/bg.jpg when a slide has none set,
        // the same "null image falls back to a bundled default" pattern already used
        // for Event::image elsewhere in this app.
        DB::table('sliders')->insert([
            'subtitle' => 'Non - Profit Charity',
            'title' => 'Make Someone’s Life By Giving Of Yours\'s.',
            'button_text' => 'Join With Us',
            'button_url' => '#',
            'text_animation' => 'fadeInUp',
            'is_active' => true,
            'display_order' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
