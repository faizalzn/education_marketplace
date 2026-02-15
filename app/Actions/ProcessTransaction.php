<?php

namespace App\Actions;

use App\Models\Booking;
use App\Models\Transaction;

class ProcessTransaction
{
    public function execute(Booking $booking, array $paymentData): Transaction
    {
        // Create transaction record
        $transaction = Transaction::create([
            'booking_id' => $booking->id,
            'payer_user_id' => $booking->user_id,
            'amount' => $booking->amount,
            'status' => 'processing',
            'payment_method' => $paymentData['payment_method'] ?? 'credit_card',
            'payment_gateway_transaction_id' => $paymentData['gateway_transaction_id'] ?? null,
        ]);

        // Calculate commission (default 15% platform fee)
        $commission = $transaction->calculateCommission(0.15);
        $instructorAmount = $transaction->amount - $commission;

        // Update transaction with calculated amounts
        $transaction->update([
            'platform_fee' => $commission,
            'instructor_amount' => $instructorAmount,
        ]);

        return $transaction;
    }

    public function confirm(Transaction $transaction): bool
    {
        return $transaction->markAsCompleted();
    }

    public function fail(Transaction $transaction, string $reason): bool
    {
        return $transaction->markAsFailed($reason);
    }

    public function refund(Transaction $transaction): bool
    {
        return $transaction->refund();
    }
}
