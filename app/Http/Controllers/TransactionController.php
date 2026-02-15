<?php

namespace App\Http\Controllers;

use App\Actions\ProcessTransaction;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function show(Transaction $transaction)
    {
        // Verify authorization
        if ($transaction->booking->user_id !== auth()->id() && 
            $transaction->payment_gateway_transaction_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Transactions/Show', [
            'transaction' => $transaction->load('booking', 'booking.course'),
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        // Verify ownership
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Transactions/Create', [
            'booking' => $booking->load('course'),
        ]);
    }

    public function store(Request $request, ProcessTransaction $action)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|in:credit_card,debit_card,bank_transfer,e_wallet',
            'gateway_transaction_id' => 'nullable|string',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        // Verify ownership
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction = $action->execute($booking, $validated);

        // In a real application, integrate with payment gateway here
        // For now, simulate payment processing
        $transaction->markAsCompleted();
        $booking->confirm();

        return redirect("/transactions/{$transaction->id}")
            ->with('success', 'Payment processed successfully!');
    }

    public function refund(Request $request, Transaction $transaction)
    {
        // Verify authorization
        if ($transaction->booking->user_id !== auth()->id()) {
            if (!auth()->user()->isAdmin()) {
                abort(403);
            }
        }

        $refund = $transaction->refund();

        if ($refund) {
            return back()->with('success', 'Refund initiated successfully.');
        }

        return back()->withErrors(['error' => 'Unable to process refund.']);
    }
}
