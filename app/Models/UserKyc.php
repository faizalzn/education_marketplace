<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserKyc extends Model
{
    use SoftDeletes;

    protected $table = 'user_kyc';

    protected $fillable = [
        'user_id',
        'full_name',
        'phone_number',
        'date_of_birth',
        'gender',
        'nationality',
        'street_address',
        'city',
        'state',
        'postal_code',
        'country',
        'id_type',
        'id_number',
        'id_expiry_date',
        'id_document_path',
        'address_proof_path',
        'bank_name',
        'bank_account_number',
        'bank_routing_number',
        'bank_account_holder_name',
        'bank_statement_path',
        'selfie_path',
        'liveness_check_passed',
        'status',
        'rejection_reason',
        'approved_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'id_expiry_date' => 'date',
        'liveness_check_passed' => 'boolean',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function approve(): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function reject(string $reason): bool
    {
        return $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }

    public function sendForReview(): bool
    {
        return $this->update([
            'status' => 'under_review',
        ]);
    }
}
