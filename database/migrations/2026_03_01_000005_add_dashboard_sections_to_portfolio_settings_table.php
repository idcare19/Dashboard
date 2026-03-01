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
        Schema::table('portfolio_settings', function (Blueprint $table) {
            $table->json('graph_points')->nullable()->after('socials');
            $table->json('upcoming_projects')->nullable()->after('graph_points');
            $table->json('updates_feed')->nullable()->after('upcoming_projects');
            $table->text('admin_notes')->nullable()->after('updates_feed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolio_settings', function (Blueprint $table) {
            $table->dropColumn(['graph_points', 'upcoming_projects', 'updates_feed', 'admin_notes']);
        });
    }
};
