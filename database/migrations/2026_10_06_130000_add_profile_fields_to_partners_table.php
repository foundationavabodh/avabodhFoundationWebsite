<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds the remaining fields from the "NGO Information Collection Form" so an
     * NGO's single-page public profile (/ngo/{slug}) can show everything the form
     * collects. Every column is nullable: the profile only renders what is filled in.
     */
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Section 1: basic & legal identity
            $table->string('legal_name')->nullable()->after('name');
            $table->string('registration_details')->nullable()->after('established_year');
            $table->string('tax_certifications')->nullable()->after('registration_details');

            // Section 2: contact & key personnel
            $table->string('founder_name')->nullable()->after('tax_certifications');
            $table->string('contact_person')->nullable()->after('founder_name');
            $table->json('social_links')->nullable()->after('contact_phone');
            $table->text('operating_address')->nullable()->after('address');

            // Section 3: about the organisation (long-form content)
            $table->text('mission')->nullable()->after('details');
            $table->text('vision')->nullable()->after('mission');
            $table->longText('ongoing_projects')->nullable()->after('vision');
            $table->longText('achievements')->nullable()->after('ongoing_projects');

            // Section 4: media & visual assets
            $table->string('cover_image')->nullable()->after('logo');
            $table->json('gallery')->nullable()->after('cover_image');
            $table->string('video_url')->nullable()->after('gallery');
            $table->string('brochure_url')->nullable()->after('video_url');

            // Section 5: donation & bank details (shown publicly, by the NGO's own choice)
            $table->string('bank_account_holder')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->string('bank_ifsc', 50)->nullable();
            $table->string('upi_id')->nullable();
            $table->string('upi_qr_image')->nullable();
            $table->text('donor_tax_benefit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'legal_name', 'registration_details', 'tax_certifications',
                'founder_name', 'contact_person', 'social_links', 'operating_address',
                'mission', 'vision', 'ongoing_projects', 'achievements',
                'cover_image', 'gallery', 'video_url', 'brochure_url',
                'bank_account_holder', 'bank_name', 'bank_branch', 'bank_account_number',
                'bank_ifsc', 'upi_id', 'upi_qr_image', 'donor_tax_benefit',
            ]);
        });
    }
};
