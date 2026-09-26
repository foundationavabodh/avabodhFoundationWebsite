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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            // One of App\Enums\PartnerCategory's values -- which public filter tab
            // ("Educational Partners" / "NGO Collaborators" / "CSR & Corporates") this
            // partner appears under on the public /ngo page.
            $table->string('category', 20)->index();
            // Free-text badge shown on the card (e.g. "Educational Institution",
            // "CSR & Medical Sponsor", "Corporate CSR Partner") -- kept separate from
            // `category` since the live reference site uses different badge wording for
            // cards within the same filter category.
            $table->string('badge_label');
            $table->string('name');
            // Short colored subtitle describing the specific collaboration
            // (e.g. "Internship & Tech Sourcing").
            $table->string('tag_line');
            $table->text('description');
            $table->string('location');
            $table->boolean('is_active_network')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->index(['is_active_network', 'display_order']);
        });

        // Seed with the real partner network already listed on the live
        // avabodhfoundation.org/ngo page, so the new page isn't empty the moment this
        // migration runs -- same "seed real/default content directly in the migration"
        // approach already used by 2026_09_20_120000_create_sliders_table.php.
        $now = now();

        DB::table('partners')->insert([
            [
                'category' => 'educational',
                'badge_label' => 'Educational Institution',
                'name' => 'Ramdeobaba University (RBU Nagpur)',
                'tag_line' => 'Internship & Tech Sourcing',
                'description' => 'Facilitates structured student internship programs, engaging engineering and technical students in building real-world automation and web resources for social campaigns.',
                'location' => 'Nagpur, Maharashtra',
                'is_active_network' => true,
                'display_order' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'ngo',
                'badge_label' => 'NGO Collaborator',
                'name' => 'Youth for Sewa (YFS)',
                'tag_line' => 'Slum Classroom Fieldwork',
                'description' => 'Collaborates on local slum education drives, coordinating student mobilization and deployment of primary school teaching kits directly to underprivileged clusters.',
                'location' => 'Nagpur, Maharashtra',
                'is_active_network' => true,
                'display_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'csr',
                'badge_label' => 'CSR & Medical Sponsor',
                'name' => 'Lokkalyan Diagnostic Centre',
                'tag_line' => 'Clinical Automation Support',
                'description' => "A healthcare center partnering with Avabodh's student developers to implement diagnostic tools and hospital management software for community clinics.",
                'location' => 'New Delhi, India',
                'is_active_network' => true,
                'display_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'ngo',
                'badge_label' => 'NGO Collaborator',
                'name' => 'Snehaanchal Palliative Care',
                'tag_line' => 'Hospice Volunteer Mobilization',
                'description' => 'Partner in coordinating volunteer drives, blood donations, and local asset distribution campaigns to assist cancer patients at local hospice centers.',
                'location' => 'Nagpur, Maharashtra',
                'is_active_network' => true,
                'display_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'educational',
                'badge_label' => 'Educational Institution',
                'name' => 'Abhyudaya Global Village School',
                'tag_line' => 'Rural Learning Centers',
                'description' => 'Collaborates on bringing world-class educational curriculum, digital literacy labs, and volunteer student teachers directly to rural village students.',
                'location' => 'Nagpur District, MH',
                'is_active_network' => true,
                'display_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'ngo',
                'badge_label' => 'NGO Collaborator',
                'name' => 'Vishwamamtva Foundation',
                'tag_line' => 'Social Inclusion Drives',
                'description' => 'Works in coordination to drive transgender empowerment programs, public vocational skill training, and inclusive primary educational curriculum.',
                'location' => 'Maharashtra, India',
                'is_active_network' => true,
                'display_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'ngo',
                'badge_label' => 'NGO Collaborator',
                'name' => 'Mahatma Gandhi Gramin Sewa Sangh (MGGSS)',
                'tag_line' => 'Adivasi Community Support',
                'description' => 'Collaborator focusing on rural community classrooms, supply-chain logistics for remote hubs, and bringing tech-kits to tribal students in West Bengal.',
                'location' => 'West Bengal, India',
                'is_active_network' => true,
                'display_order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'csr',
                'badge_label' => 'Corporate CSR Partner',
                'name' => 'ACES India Private Limited',
                'tag_line' => 'CSR Funding & Skill Support',
                'description' => 'Corporate sponsor supporting digital literacy bootcamps, community workshops, and sponsoring classroom supplies for active education nodes.',
                'location' => 'Nagpur, Maharashtra',
                'is_active_network' => true,
                'display_order' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'csr',
                'badge_label' => 'Corporate CSR Partner',
                'name' => 'Mukim Chemicals Private Limited',
                'tag_line' => 'Environmental Canopy Sponsor',
                'description' => 'Contributes CSR funding for tree plantation campaigns, environmental green canopies, and community sanitation drives in the Nagpur region.',
                'location' => 'Nagpur, Maharashtra',
                'is_active_network' => true,
                'display_order' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'csr',
                'badge_label' => 'Corporate CSR Partner',
                'name' => 'SEACO Associates (OPC) Pvt Ltd',
                'tag_line' => 'Student Mentorship & Evaluation',
                'description' => 'Assists in student project validation, corporate skill mentoring, and software verification support for technology-based student work.',
                'location' => 'Nagpur, Maharashtra',
                'is_active_network' => true,
                'display_order' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
