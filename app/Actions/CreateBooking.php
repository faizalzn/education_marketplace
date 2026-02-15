<?php

namespace App\Actions;

use App\Models\Booking;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateBooking
{
    /**
     * @throws ModelNotFoundException
     */
    public function execute(User $user, Course $course): Booking
    {
        // Verify user can book
        if (!$user->canBook()) {
            throw new \Exception('User is not eligible to make bookings');
        }

        // Check if already booked
        $existingBooking = Booking::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereNotIn('status', ['cancelled'])
            ->first();

        if ($existingBooking) {
            throw new \Exception('User has already booked this course');
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'status' => 'pending',
        ]);

        return $booking;
    }
}
