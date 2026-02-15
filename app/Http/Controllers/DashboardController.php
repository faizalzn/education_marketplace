<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Student Dashboard
        if ($user->isStudent()) {
            $bookings = $user->bookings()
                ->with('course', 'course.instructor')
                ->whereNotIn('status', ['cancelled'])
                ->latest()
                ->take(5)
                ->get();

            $stats = [
                'enrolledCourses' => $user->bookings()->whereIn('status', ['confirmed', 'started'])->count(),
                'inProgress' => $user->bookings()->where('status', 'started')->count(),
                'completed' => $user->bookings()->where('status', 'completed')->count(),
                'accountBalance' => 0,
            ];

            return Inertia::render('Dashboard', [
                'bookings' => $bookings,
                'stats' => $stats,
                'activities' => [],
            ]);
        }

        // Instructor Dashboard
        if ($user->isInstructor()) {
            $courses = $user->courses()->count();
            $totalStudents = $user->courses()
                ->join('bookings', 'courses.id', '=', 'bookings.course_id')
                ->count();

            $settlements = $user->settlements()
                ->where('status', 'completed')
                ->sum('final_amount');

            $activities = [
                [
                    'id' => 1,
                    'icon' => '📚',
                    'title' => 'New student enrolled',
                    'value' => '+2',
                    'timestamp' => 'Today at 2:30 PM',
                ],
                [
                    'id' => 2,
                    'icon' => '💰',
                    'title' => 'Payment received',
                    'value' => '$150',
                    'timestamp' => 'Yesterday',
                ],
            ];

            $stats = [
                'totalEarnings' => number_format($settlements, 2),
                'activeCourses' => $courses,
                'totalStudents' => $totalStudents,
                'accountBalance' => 0,
            ];

            return Inertia::render('Dashboard', [
                'stats' => $stats,
                'activities' => $activities,
                'bookings' => [],
            ]);
        }

        // Admin Dashboard
        $stats = [
            'totalUsers' => \App\Models\User::count(),
            'totalCourses' => \App\Models\Course::count(),
            'totalBookings' => \App\Models\Booking::count(),
            'totalRevenue' => \App\Models\Transaction::where('status', 'completed')->sum('platform_fee'),
            'accountBalance' => 0,
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'activities' => [],
        ]);
    }
}
