<?php

namespace App\Actions;

use App\Models\Settlement;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class GenerateSettlement
{
    public function execute(User $instructor, string $period = 'monthly'): Settlement
    {
        // Define period dates
        $now = Carbon::now();
        $periodStart = $now->copy()->startOfMonth();
        $periodEnd = $now->copy()->endOfMonth();

        // Get all completed transactions for this instructor in period
        $transactions = Transaction::whereHas('booking.course', function ($query) use ($instructor) {
            $query->where('instructor_id', $instructor->id);
        })
            ->where('status', 'completed')
            ->whereBetween('paid_at', [$periodStart, $periodEnd])
            ->get();

        $totalBookingsAmount = $transactions->sum('amount');
        $totalBookingsCount = $transactions->count();

        // Calculate commission (15% platform fee)
        $platformCommission = round($totalBookingsAmount * 0.15, 2);
        $netAmount = $totalBookingsAmount - $platformCommission;

        // Create settlement
        $settlement = Settlement::create([
            'instructor_id' => $instructor->id,
            'period' => $period,
            'period_start' => $periodStart->toDateString(),
            'period_end' => $periodEnd->toDateString(),
            'total_bookings_amount' => $totalBookingsAmount,
            'total_bookings_count' => $totalBookingsCount,
            'platform_commission' => $platformCommission,
            'net_amount' => $netAmount,
            'gross_dispute_amount' => 0,
            'refund_amount' => 0,
            'final_amount' => $netAmount,
            'status' => 'pending',
        ]);

        return $settlement;
    }

    public function calculateRefunds(Settlement $settlement): float
    {
        // Calculate total refunds during settlement period
        $refunds = Transaction::whereHas('booking.course', function ($query) use ($settlement) {
            $query->where('instructor_id', $settlement->instructor_id);
        })
            ->where('status', 'refunded')
            ->whereBetween('refunded_at', [
                $settlement->period_start,
                $settlement->period_end,
            ])
            ->sum('amount');

        return round($refunds, 2);
    }

    public function finalize(Settlement $settlement): bool
    {
        // Update refunds
        $refunds = $this->calculateRefunds($settlement);
        $settlement->update(['refund_amount' => $refunds]);

        // Calculate final amount
        return $settlement->updateFinalAmount();
    }
}
