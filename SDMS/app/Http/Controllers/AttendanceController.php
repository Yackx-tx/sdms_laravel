<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'course', 'section'])
            ->select('StudentId', DB::raw('MAX(id) as id'));

        if ($request->filled('SectionId')) {
            $query->where('SectionId', $request->SectionId);
        }

        if ($request->filled('CourseId')) {
            $query->where('CourseId', $request->CourseId);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->groupBy('StudentId')
            ->get()
            ->map(function ($attendance) {
                return Attendance::with(['student', 'course', 'section'])->find($attendance->id);
            });

        $sections = Section::all();
        $courses = Course::all();

        return view('attendance.index', compact('attendances', 'sections', 'courses'));
    }

    public function create(Request $request)
    {
        $sections = Section::all();
        $courses = Course::all();
        $students = collect();

        if ($request->has('section')) {
            $students = Student::where('SectionId', $request->section)->get();
        }

        return view('attendance.create', compact('sections', 'courses', 'students'));
    }




    public function getSectionStudents($sectionId)
    {
        $students = Student::where('SectionId', $sectionId)->get();
        return response()->json($students);
    }

    public function getAttendanceSummary(Request $request)
    {
        $query = Attendance::with(['student', 'course', 'section'])
            ->select(
                'courses.CourseName as course_name',
                'sections.SectionName as section_name',
                DB::raw('COUNT(*) as total_records'),
                DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count'),
                DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count')
            )
            ->join('courses', 'attendances.CourseId', '=', 'courses.CourseId')
            ->join('sections', 'attendances.SectionId', '=', 'sections.SectionId')
            ->groupBy('courses.CourseName', 'sections.SectionName');

        if ($request->filled('SectionId')) {
            $query->where('attendances.SectionId', $request->SectionId);
        }

        return $query->get();
    }




    public function store(Request $request)
    {
        $request->validate([
            'SectionId' => 'required|exists:sections,SectionId',
            'CourseId' => 'required|exists:courses,CourseId',
            'date' => 'required|date',
            'StudentId' => 'required|array',
            'status' => 'required|array'
        ]);

        foreach ($request->StudentId as $key => $studentId) {
            Attendance::create([
                'StudentId' => $studentId,
                'SectionId' => $request->SectionId,
                'CourseId' => $request->CourseId,
                'date' => $request->date,
                'status' => $request->status[$key]
            ]);
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully');
    }
    public function getStudentsBySection($sectionId)
    {
        $students = Student::where('SectionId', $sectionId)->get();
        return response()->json($students);
    }

    public function edit($id)
    {
        $attendance = Attendance::with(['student', 'course', 'section'])->findOrFail($id);
        $sections = Section::all();
        $courses = Course::all();

        return view('attendance.edit', compact('attendance', 'sections', 'courses'));
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record deleted successfully');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'SectionId' => 'required|exists:sections,SectionId',
            'CourseId' => 'required|exists:courses,CourseId',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late'
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'SectionId' => $request->SectionId,
            'CourseId' => $request->CourseId,
            'date' => $request->date,
            'status' => $request->status
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully');
    }
}
