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
        Schema::create('contact_leads', function (Blueprint $table) {
            $table->id();

            // Basic contact information
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('business_name');
            $table->text('message');

            // Contact preferences
            $table->enum('preferred_contact', ['email', 'phone', 'whatsapp'])->default('email');

            // Lead management
            $table->enum('status', [
                'new',
                'contacted',
                'interested',
                'demo_scheduled',
                'demo_completed',
                'proposal_sent',
                'closed_won',
                'closed_lost'
            ])->default('new');

            $table->enum('source', [
                'landing_page',
                'referral',
                'social_media',
                'direct'
            ])->default('landing_page');

            // Internal management
            $table->text('notes')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');

            // Tracking
            $table->string('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('referer')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['status', 'created_at']);
            $table->index(['assigned_to', 'status']);
            $table->index('email');
            $table->index('business_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_leads');
    }
};