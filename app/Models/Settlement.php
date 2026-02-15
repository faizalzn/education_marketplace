<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Settlement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'instructor_id',
        'settlement_reference',
        'period',
        'period_start',
        'period_end',
        'total_bookings_amount',
        'total_bookings_count',
        'platform_commission',
        'net_amount',
        'gross_dispute_amount',
        'refund_amount',
        'final_amount',
        'status',
        'notes',
        'rejection_reason',
        'approved_at',
        'paid_at',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'total_bookings_amount' => 'decimal:2',
        'platform_commission' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'gross_dispute_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function booting()
    {
        static::creating(function ($model) {
            if (empty($model->settlement_reference)) {
                $model->settlement_reference = 'SETL' . date('Ymd') . Str::random(10);
            }
        });
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
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

    public function process(): bool
    {
        return $this->update(['status' => 'processing']);
    }

    public function markAsPaid(): bool
    {
        return $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    public function reject(string $reason): bool
    {
        return $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }

    public function calculateTotalAmount(): float
    {
        return round(
            $this->net_amount - $this->gross_dispute_amount - $this->refund_amount,
            2
        );
    }

    public function updateFinalAmount(): bool
    {
        return $this->update([
            'final_amount' => $this->calculateTotalAmount(),
        ]);
    }
}
