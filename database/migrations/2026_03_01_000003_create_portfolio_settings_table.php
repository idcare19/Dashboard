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
        Schema::create('portfolio_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->default('Portfolio');
            $table->string('person_name')->default('Abhishek');
            $table->text('hero_title');
            $table->text('hero_subtitle');
            $table->string('availability')->nullable();
            $table->string('location')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('popup_message')->nullable();
            $table->json('badges')->nullable();
            $table->json('stats')->nullable();
            $table->json('about_cards')->nullable();
            $table->json('projects')->nullable();
            $table->json('skills')->nullable();
            $table->json('experiences')->nullable();
            $table->json('socials')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_settings');
    }
};
