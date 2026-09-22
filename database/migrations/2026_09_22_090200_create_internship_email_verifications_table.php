<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Holds short-lived email verification codes for the public internship
     * application form (Part 3): an applicant requests a code for their email,
     * we mail it (see App\Notifications\InternshipEmailVerificationCode), they
     * enter it back, and only then can the application actually be submitted.
     * Deliberately separate from `internship_applications` -- verification
     * happens before an application exists, against just an email address.
     */
    public function up(): void
    {
        Schema::create('internship_email_verifications', function (Blueprint $table) {
            $table->id();

            // One active code per email: requesting a new code replaces the row
            // (see InternshipEmailVerification::issueFor()) rather than accumulating
            // old ones.
            $table->string('email')->unique();

            // Hashed, like Laravel's own password_reset_tokens -- so a snapshot of
            // the database doesn't hand out valid codes.
            $table->string('code_hash');

            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_email_verifications');
    }
};
