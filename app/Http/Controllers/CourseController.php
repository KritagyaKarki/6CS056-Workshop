<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $courses = Course::all();

    return view('course.list', [
        'courses' => $courses
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('course.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate($this->rules());

    $course = Course::create($validated);

    return redirect()->route('courses.index')
        ->with('success', "Course {$course->name} created successfully!");
}

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
{
    return view('course.detail', [
        'course' => $course
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
{
    return view('course.edit', [
        'course' => $course
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
{
    $validated = $request->validate($this->rules());

    $course->update($validated);

    return redirect()->route('courses.show', $course)
        ->with('success', 'Course updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
{
    $course->delete();

    return redirect()->route('courses.index')
        ->with('success', 'Course deleted successfully!');
}

    private function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'required|integer|min:1',
        'fee' => 'required|numeric|min:0',
        'difficulty' => [
            'required',
            Rule::in(['Easy', 'Medium', 'Hard']),
        ],
        'is_active' => 'boolean',
    ];
}
}
