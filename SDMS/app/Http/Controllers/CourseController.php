<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Section;
use App\Models\Activity;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('courses.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|unique:courses,course_code|max:255',
            'course_name' => 'required|max:255',
            'description' => 'nullable',
            'credits' => 'required|integer|min:1',
            'instructor' => 'required|max:255',
        ]);

        $course = Course::create($validated);
        Activity::record('created a new course: ' . $course->course_name, 'success', 'success');

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }


    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_code' => 'required|unique:courses,course_code,' . $course->id . '|max:255',
            'course_name' => 'required|max:255',
            'description' => 'nullable',
            'credits' => 'required|integer|min:1',
            'instructor' => 'required|max:255',
        ]);

        $course->update($validated);
        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }
}
