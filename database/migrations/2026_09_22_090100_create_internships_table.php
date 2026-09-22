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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();

            // restrict (not cascade/null) so a domain in active use can't be deleted
            // out from under its internships -- the admin has to reassign them first.
            $table->foreignId('domain_id')
                ->constrained('internship_domains')
                ->restrictOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();

            // Free text (durations/commitments are phrased too many different ways --
            // "3 months", "6-8 weeks", "Ongoing" -- to usefully constrain to an enum).
            $table->string('duration')->nullable();
            $table->string('commitment')->nullable();

            // Comma-separated free text, same reasoning as duration/commitment; kept
            // simple rather than a full skills taxonomy table, which this task doesn't
            // call for and would add complexity with no real benefit at this scale.
            $table->text('skills_required')->nullable();

            $table->string('image')->nullable();

            // 'draft' | 'published' | 'closed' -- see App\Enums\InternshipStatus.
            // Only 'published' is ever shown on the public site.
            $table->string('status', 20)->default('draft');

            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->index(['status', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
