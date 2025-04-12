<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Section;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentController extends Controller
{
    private $validationRules = [
        'FirstName' => 'required|string|max:255',
        'LastName' => 'required|string|max:255',
        'SectionId' => 'required|exists:sections,SectionId',
        'Gender' => 'required|in:Male,Female,Other',
        'DateOfBirth' => 'required|date|before:today|age_at_least:15',
        'ContactNumber' => 'required|string|max:20',
        'Email' => 'required|email|unique:students,Email',
        'Address' => 'required|string|max:500',
        'EnrollmentDate' => 'required|date'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = $this->getStudentsWithRelations()
            ->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('students.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);

        return DB::transaction(function () use ($validated, $request) {
            $student = Student::create($validated);
            if ($request->has('courses')) {
                $student->courses()->attach($request->courses);
            }

            Activity::record('added a new student: ' . $student->FirstName, 'success', 'success');


            return redirect()
                ->route('students.index')
                ->with('success', 'Student record created successfully');
        });
    }

    public function show(Student $student)
    {
        return view('students.show', [
            'student' => $student->load(['courses', 'attendances', 'grades'])
        ]);
    }

    public function edit(Student $student)
    {
        return view('students.edit', [
            'student' => $student->load('courses')
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $rules = $this->validationRules;
        $rules['Email'] = 'required|email|unique:students,Email,' . $student->StudentId . ',StudentId';

        $validated = $request->validate($rules);

        return DB::transaction(function () use ($student, $validated) {
            $student->update($validated);

            if (request()->has('courses')) {
                $student->courses()->sync(request('courses'));
            }

            return redirect()
                ->route('students.index')
                ->with('success', 'Student record updated successfully');
        });
    }

    public function destroy(Student $student)
    {
        return DB::transaction(function () use ($student) {
            $student->delete();
            return redirect()
                ->route('students.index')
                ->with('success', 'Student record deleted successfully');
        });
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $students = $this->getStudentsWithRelations()
            ->where('FirstName', 'like', "%{$query}%")
            ->orWhere('LastName', 'like', "%{$query}%")
            ->orWhere('Email', 'like', "%{$query}%")
            ->paginate(10);

        return view('students.index', compact('students'));
    }
    private function getStudentsWithRelations()
    {
        return Student::with(['courses', 'attendances', 'grades', 'section']);
    }
}
