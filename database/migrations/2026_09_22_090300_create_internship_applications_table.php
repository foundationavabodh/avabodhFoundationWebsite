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
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();

            // Public-facing identifier, e.g. "AVB-INT-7F3K" (see
            // InternshipApplication::generateApplicationId()) -- what applicants use
            // with the public status tracker instead of the internal numeric id.
            $table->string('application_id', 20)->unique();

            // restrict, not cascade: an internship with existing applications can't
            // be deleted (the task explicitly asks to prevent orphaned applications),
            // so the admin must first handle/reassign those applications. This is the
            // safest default for what is effectively applicant records; it can be
            // revisited if the client would rather allow cascade deletes.
            $table->foreignId('internship_id')
                ->constrained('internships')
                ->restrictOnDelete();

            $table->string('full_name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('phone', 30)->nullable();

            // The applicant's general domain of interest, which may differ from the
            // specific internship they're applying to. nullOnDelete: losing this
            // categorization on an old application if the domain is later removed is
            // low-stakes, unlike losing the internship_id itself.
            $table->foreignId('preferred_domain_id')
                ->nullable()
                ->constrained('internship_domains')
                ->nullOnDelete();

            $table->string('college_name')->nullable();
            $table->text('address')->nullable();
            $table->text('skills')->nullable();

            // 'pending' | 'under_review' | 'shortlisted' | 'selected' | 'rejected' |
            // 'completed' -- see App\Enums\InternshipApplicationStatus.
            $table->string('status', 20)->default('pending');

            // Internal admin-only notes -- never exposed on the public status tracker.
            $table->text('notes')->nullable();

            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
