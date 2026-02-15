<?php

namespace App\Http\Controllers;

use App\Actions\GenerateSettlement;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettlementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:view,settlement')->only('show');
        $this->middleware('can:manage-settlements')->only(['approve', 'reject']);
    }

    public function index(Request $request)
    {
        $settlements = Settlement::where('instructor_id', auth()->id())
            ->latest()
            ->paginate(10);

        return Inertia::render('Settlements/Index', [
            'settlements' => $settlements,
        ]);
    }

    public function show(Settlement $settlement)
    {
        // Verify ownership or admin
        if ($settlement->instructor_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return Inertia::render('Settlements/Show', [
            'settlement' => $settlement->load('instructor'),
        ]);
    }

    public function generate(Request $request, GenerateSettlement $action)
    {
        // Only allow instructors
        if (!auth()->user()->isInstructor()) {
            abort(403);
        }

        $validated = $request->validate([
            'period' => 'required|in:weekly,biweekly,monthly',
        ]);

        $settlement = $action->execute(auth()->user(), $validated['period']);
        $action->finalize($settlement);

        return redirect("/settlements/{$settlement->id}")
            ->with('success', 'Settlement generated successfully.');
    }

    public function approve(Request $request, Settlement $settlement)
    {
        // Admin only
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $settlement->approve();

        return back()->with('success', 'Settlement approved.');
    }

    public function reject(Request $request, Settlement $settlement)
    {
        // Admin only
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $settlement->reject($validated['reason']);

        return back()->with('success', 'Settlement rejected.');
    }

    public function pay(Request $request, Settlement $settlement)
    {
        // Admin only
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if (!$settlement->isApproved()) {
            return back()->withErrors(['error' => 'Settlement must be approved before payment.']);
        }

        $settlement->process();
        // In real implementation, integrate with payment gateway
        $settlement->markAsPaid();

        return back()->with('success', 'Settlement payment processed.');
    }
}
