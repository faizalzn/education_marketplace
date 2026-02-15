<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function browse(Request $request)
    {
        $query = Course::where('status', 'published')
            ->with('instructor')
            ->latest();

        // Filter by search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by level
        if ($request->has('level') && $request->level) {
            $query->where('level', $request->level);
        }

        // Filter by price
        if ($request->has('price') && $request->price) {
            $prices = explode('-', $request->price);
            if (count($prices) === 2) {
                $query->whereBetween('price', [$prices[0], $prices[1]]);
            }
        }

        $courses = $query->paginate(12);

        return Inertia::render('Courses/Browse', [
            'courses' => $courses,
        ]);
    }

    public function show(Course $course)
    {
        if ($course->status !== 'published' && $course->instructor_id !== auth()->id()) {
            abort(404);
        }

        return Inertia::render('Courses/Show', [
            'course' => $course->load('instructor'),
        ]);
    }

    public function create()
    {
        // Verify user is instructor
        if (!auth()->user()->isInstructor()) {
            abort(403);
        }

        return Inertia::render('Courses/Create');
    }

    public function store(Request $request)
    {
        // Verify user is instructor
        if (!auth()->user()->isInstructor()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'learning_outcomes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_hours' => 'nullable|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'category' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['instructor_id'] = auth()->id();
        $validated['status'] = 'draft';

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('course-thumbnails');
        }

        $course = Course::create($validated);

        return redirect("/courses/{$course->id}/edit")
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        // Verify ownership
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Courses/Edit', [
            'course' => $course,
        ]);
    }

    public function update(Request $request, Course $course)
    {
        // Verify ownership
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'learning_outcomes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_hours' => 'nullable|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'category' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('course-thumbnails');
        }

        $course->update($validated);

        return back()->with('success', 'Course updated successfully.');
    }

    public function publish(Course $course)
    {
        // Verify ownership
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $course->publish();

        return back()->with('success', 'Course published successfully.');
    }

    public function destroy(Course $course)
    {
        // Verify ownership
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $course->delete();

        return redirect('/instructor/courses')
            ->with('success', 'Course deleted successfully.');
    }
}
