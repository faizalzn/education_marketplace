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
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            
            $table->string('settlement_reference')->unique();
            $table->enum('period', ['weekly', 'biweekly', 'monthly'])->default('monthly');
            
            $table->date('period_start');
            $table->date('period_end');
            
            $table->decimal('total_bookings_amount', 12, 2)->default(0);
            $table->integer('total_bookings_count')->default(0);
            
            $table->decimal('platform_commission', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->default(0);
            
            $table->decimal('gross_dispute_amount', 12, 2)->default(0);
            $table->decimal('refund_amount', 12, 2)->default(0);
            $table->decimal('final_amount', 12, 2)->default(0);
            
            $table->enum('status', ['pending', 'approved', 'processing', 'completed', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('instructor_id');
            $table->index('status');
            $table->index('period_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};
