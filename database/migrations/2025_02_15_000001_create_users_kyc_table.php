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
        Schema::create('user_kyc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Personal Information
            $table->string('full_name');
            $table->string('phone_number');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('nationality');
            
            // Address Information
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            
            // Identity Verification
            $table->enum('id_type', ['passport', 'national_id', 'driver_license']);
            $table->string('id_number')->unique();
            $table->date('id_expiry_date');
            $table->string('id_document_path')->nullable();
            
            // Address Verification
            $table->string('address_proof_path')->nullable();
            
            // Bank Details
            $table->string('bank_name');
            $table->string('bank_account_number');
            $table->string('bank_routing_number')->nullable();
            $table->string('bank_account_holder_name');
            $table->string('bank_statement_path')->nullable();
            
            // Face Recognition/Liveness
            $table->string('selfie_path')->nullable();
            $table->boolean('liveness_check_passed')->default(false);
            
            // KYC Status
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_kyc');
    }
};
