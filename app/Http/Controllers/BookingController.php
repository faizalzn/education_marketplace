<?php

namespace App\Http\Controllers;

use App\Actions\CreateBooking;
use App\Models\Booking;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()
            ->bookings()
            ->with('course', 'course.instructor')
            ->latest()
            ->paginate(10);

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    public function show(Booking $booking)
    {
        // Verify ownership
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Bookings/Show', [
            'booking' => $booking->load('course', 'course.instructor', 'transactions'),
        ]);
    }

    public function store(Request $request, CreateBooking $action)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $user = $request->user();

        try {
            $booking = $action->execute($user, $course);
            return redirect("/bookings/{$booking->id}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cancel(Request $request, Booking $booking)
    {
        // Verify ownership
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $booking->cancel($validated['reason']);

        return redirect("/bookings/{$booking->id}")
            ->with('success', 'Booking cancelled successfully.');
    }
}
