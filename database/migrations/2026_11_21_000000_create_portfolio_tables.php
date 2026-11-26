<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('primary_title', 100);
            $table->string('hero_kicker', 200)->nullable();
            $table->string('hero_headline', 120);
            $table->string('hero_subtitle', 100)->nullable();
            $table->text('hero_description')->nullable();
            $table->json('rotating_roles')->nullable();
            $table->string('location', 150)->nullable();
            $table->string('email', 160)->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->json('about_paragraphs')->nullable();
            $table->string('portrait_image')->nullable();
            $table->timestamps();
        });

        Schema::create('highlights', function (Blueprint $table) {
            $table->id();
            $table->string('label', 120);
            $table->string('detail', 200)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('category', 50);
            $table->string('name', 120);
            $table->string('detail', 255)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('category', 120)->nullable();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->json('technologies')->nullable();
            $table->string('image')->nullable();
            $table->string('repo_url')->nullable();
            $table->string('live_url')->nullable();
            $table->string('status_note')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('timeline_entries', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20); // experience | education
            $table->string('title', 150);
            $table->string('subtitle', 150)->nullable();
            $table->string('period_label', 150)->nullable();
            $table->json('details')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description');
            $table->string('icon', 50);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('process_steps', function (Blueprint $table) {
            $table->id();
            $table->string('step', 10);
            $table->string('title', 100);
            $table->text('summary');
            $table->string('deliverable')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('email', 160);
            $table->string('subject', 160);
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('process_steps');
        Schema::dropIfExists('services');
        Schema::dropIfExists('timeline_entries');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('highlights');
        Schema::dropIfExists('profiles');
    }
};
