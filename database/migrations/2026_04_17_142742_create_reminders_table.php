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
        // Reminders Table
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('opportunity_id')->nullable();
            $table->unsignedBigInteger('quotation_id')->nullable();
            $table->unsignedBigInteger('follow_up_id')->nullable(); // Link to customer_follow_ups
            
            // Reminder tracking
            $table->enum('reminder_type', ['lead_followup', 'opportunity_followup', 'quotation_followup'])->default('lead_followup');
            $table->text('reminder_message');
            $table->dateTime('reminder_date');
            $table->enum('status', ['pending', 'sent', 'viewed', 'snoozed', 'completed'])->default('pending');
            
            // Communication channels
            $table->boolean('send_email')->default(true);
            $table->boolean('send_whatsapp')->default(false);
            $table->boolean('send_sms')->default(false);
            $table->boolean('send_in_app')->default(true);
            
            // Tracking
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('viewed_at')->nullable();
            $table->dateTime('snoozed_until')->nullable();
            $table->integer('retry_count')->default(0);
            $table->text('failure_reason')->nullable();
            
            // Snooze & Escalation
            $table->unsignedBigInteger('snoozed_by')->nullable(); // User who snoozed
            $table->unsignedBigInteger('assigned_to')->nullable(); // Assigned team member
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes for quick queries
            $table->index(['customer_id', 'reminder_date']);
            $table->index(['status', 'reminder_date']);
            $table->index(['assigned_to', 'status']);
            $table->index(['reminder_type', 'status']);
            
            // Foreign keys
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('snoozed_by')->references('id')->on('users')->onDelete('set null');
        });

        // Reminder Log Table - for audit trail
        Schema::create('reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reminder_id');
            $table->enum('action', ['created', 'sent', 'viewed', 'failed', 'snoozed', 'completed', 'rescheduled'])->default('created');
            $table->text('details')->nullable(); // JSON for additional data
            $table->string('sent_via')->nullable(); // email, whatsapp, sms, in_app
            $table->string('recipient')->nullable(); // email or phone
            $table->integer('retry_attempt')->default(1);
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->foreign('reminder_id')->references('id')->on('reminders')->onDelete('cascade');
            $table->index(['reminder_id', 'created_at']);
        });

        // Reminder Templates - reusable templates for different scenarios
        Schema::create('reminder_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Lead Follow-up 1", "Quotation Follow-up 2", etc.
            $table->enum('type', ['lead_followup', 'opportunity_followup', 'quotation_followup'])->default('lead_followup');
            $table->text('message_template'); // Can use {customer_name}, {company}, {product}, etc.
            $table->text('whatsapp_template')->nullable();
            $table->text('email_template')->nullable();
            $table->integer('days_after_event')->default(1); // Days after lead/opportunity/quotation created
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->index(['type', 'status']);
        });

        // Reminder Queue - for bulk processing
        Schema::create('reminder_queue', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reminder_id');
            $table->string('channel'); // email, whatsapp, sms, in_app
            $table->enum('status', ['queued', 'processing', 'sent', 'failed'])->default('queued');
            $table->dateTime('scheduled_for');
            $table->dateTime('processed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('attempts')->default(0);
            $table->integer('max_attempts')->default(3);
            $table->timestamps();
            
            $table->foreign('reminder_id')->references('id')->on('reminders')->onDelete('cascade');
            $table->index(['status', 'scheduled_for']);
            $table->index(['channel', 'status']);
        });

        // Update customer_follow_ups table if needed
        Schema::table('customer_follow_ups', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('customer_follow_ups', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('notes');
            }
            if (!Schema::hasColumn('customer_follow_ups', 'status')) {
                $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending')->after('priority');
            }
            if (!Schema::hasColumn('customer_follow_ups', 'assigned_to')) {
                $table->unsignedBigInteger('assigned_to')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_queue');
        Schema::dropIfExists('reminder_logs');
        Schema::dropIfExists('reminders');
        Schema::dropIfExists('reminder_templates');
        
        Schema::table('customer_follow_ups', function (Blueprint $table) {
            if (Schema::hasColumn('customer_follow_ups', 'priority')) {
                $table->dropColumn('priority');
            }
            if (Schema::hasColumn('customer_follow_ups', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('customer_follow_ups', 'assigned_to')) {
                $table->dropColumn('assigned_to');
            }
        });
    }
};