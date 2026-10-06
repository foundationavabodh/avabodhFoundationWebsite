<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * NGOs can now register themselves from the public site (/ngo/register). Those
     * submissions are saved as "pending" and only appear on the public NGO network
     * once an admin approves them. Every partner that already exists was added by an
     * admin, so the column defaults to "approved" to keep them listed.
     */
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('approval_status', 20)->default('approved')->index()->after('is_active_network');
            $table->timestamp('reviewed_at')->nullable()->after('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropIndex(['approval_status']);
            $table->dropColumn(['approval_status', 'reviewed_at']);
        });
    }
};
