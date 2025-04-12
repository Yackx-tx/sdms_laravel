<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Course;
use App\Models\Section;
use App\Models\Activity;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'course'])
            ->select('StudentId', DB::raw('MAX(id) as id'))
            ->groupBy('StudentId')
            ->get()
            ->map(function ($grade) {
                return Grade::with(['student', 'course'])->find($grade->id);
            });

        return view('grades.index', compact('grades'));
    }


    public function create(Request $request)
    {
        $sections = Section::all();
        $courses = Course::all();
        $students = collect();

        if ($request->has('SectionId')) {
            $students = Student::where('SectionId', $request->SectionId)
                ->orderBy('LastName')
                ->get();
        }

        return view('grades.create', compact('sections', 'courses', 'students'));
    }



    public function store(Request $request)
    {
        foreach ($request->StudentId as $key => $studentId) {
            Grade::create([
                'StudentId' => $studentId,
                'CourseId' => $request->CourseId,
                'SectionId' => $request->SectionId,
                'score' => $request->score[$key],
                'grade_letter' => $request->grade_letter[$key],
                'semester' => $request->semester
            ]);
        }
        Activity::record('recorded new grades', 'info', 'info');

        return redirect()->route('grades.index')
            ->with('success', 'Grades recorded successfully');
    }
    public function getSectionStudents($sectionId)
    {
        $students = Student::where('SectionId', $sectionId)->get();
        return response()->json($students);
    }
    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return redirect()->route('grades.index')
            ->with('success', 'Grade deleted successfully');
    }
}
