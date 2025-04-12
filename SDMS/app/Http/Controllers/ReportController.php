<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Exports\AttendanceExport;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view("reports.index");
    }
    public function attendance(Request $request)
    {
        $courses = Course::all();

        $query = Attendance::select(
            'courses.course_name',
            'sections.SectionName',
            DB::raw('COUNT(*) as total_records'),
            DB::raw('SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) as present_count'),
            DB::raw('SUM(CASE WHEN attendances.status = "absent" THEN 1 ELSE 0 END) as absent_count')
        )
            ->join('courses', 'attendances.CourseId', '=', 'courses.CourseId')
            ->join('sections', 'attendances.SectionId', '=', 'sections.SectionId')
            ->groupBy('courses.course_name', 'sections.SectionName');

        // Apply filters if present
        if ($request->filled('start_date')) {
            $query->whereDate('attendances.created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('attendances.created_at', '<=', $request->end_date);
        }
        if ($request->filled('CourseId')) {
            $query->where('attendances.CourseId', $request->CourseId);
        }
        if ($request->filled('SectionId')) {
            $query->where('attendances.SectionId', $request->SectionId);
        }

        $attendanceData = $query->get();

        // Calculate overall attendance rate
        $totalPresent = $attendanceData->sum('present_count');
        $totalRecords = $attendanceData->sum('total_records');
        $attendanceRate = $totalRecords > 0 ?
            round(($totalPresent / $totalRecords) * 100, 2) : 0;

        return view('reports.attendance', compact(
            'attendanceData',
            'courses',
            'attendanceRate'
        ));
    }

    public function exportAttendance(Request $request)
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'Course');
        $sheet->setCellValue('B1', 'Section');
        $sheet->setCellValue('C1', 'Total Students');
        $sheet->setCellValue('D1', 'Present');
        $sheet->setCellValue('E1', 'Absent');
        $sheet->setCellValue('F1', 'Attendance Rate');

        // Get data
        $query = Attendance::select(
            'courses.course_name',
            'sections.SectionName',
            DB::raw('COUNT(*) as total_records'),
            DB::raw('SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) as present_count'),
            DB::raw('SUM(CASE WHEN attendances.status = "absent" THEN 1 ELSE 0 END) as absent_count')
        )
            ->join('courses', 'attendances.CourseId', '=', 'courses.CourseId')
            ->join('sections', 'attendances.SectionId', '=', 'sections.SectionId')
            ->groupBy('courses.course_name', 'sections.SectionName');

        // Apply filters
        if ($request->filled('start_date')) {
            $query->whereDate('attendances.created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('attendances.created_at', '<=', $request->end_date);
        }
        if ($request->filled('CourseId')) {
            $query->where('attendances.CourseId', $request->CourseId);
        }

        $attendanceData = $query->get();

        // Fill data
        $row = 2;
        foreach ($attendanceData as $data) {
            $attendanceRate = $data->total_records > 0 ?
                round(($data->present_count / $data->total_records) * 100, 2) : 0;

            $sheet->setCellValue('A' . $row, $data->course_name);
            $sheet->setCellValue('B' . $row, $data->SectionName);
            $sheet->setCellValue('C' . $row, $data->total_records);
            $sheet->setCellValue('D' . $row, $data->present_count);
            $sheet->setCellValue('E' . $row, $data->absent_count);
            $sheet->setCellValue('F' . $row, $attendanceRate . '%');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="attendance_report.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


    public function getAttendanceDetails($id)
    {
        $details = Attendance::with(['student', 'course', 'section'])
            ->where('id', $id)
            ->first();

        return response()->json($details);
    }

    public function printAttendanceReport($id)
    {
        $data = Attendance::with(['student', 'course', 'section'])
            ->where('id', $id)
            ->first();

        return view('reports.print.attendance', compact('data'));
    }

    public function grades()
    {
        $courses = Course::all();
        $students = Student::all();

        // Updated grade distribution calculation based on grade_letter
        $gradePercentages = DB::table('grades')
            ->select('grade_letter', DB::raw('COUNT(*) * 100.0 / (SELECT COUNT(*) FROM grades) as percentage'))
            ->groupBy('grade_letter')
            ->get();

        // Updated course grades query to match the table structure
        $courseGrades = Course::select('courses.course_name')
            ->selectRaw('COALESCE(AVG(grades.score), 0) as average_grade')
            ->selectRaw('COALESCE(MAX(grades.score), 0) as highest_grade')
            ->selectRaw('COALESCE(MIN(grades.score), 0) as lowest_grade')
            ->leftJoin('grades', 'courses.CourseId', '=', 'grades.CourseId')
            ->groupBy('courses.course_name')
            ->get();

        return view('reports.grades', compact('gradePercentages', 'courseGrades'));
    }
    public function exportGrades()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'Course');
        $sheet->setCellValue('B1', 'Average Grade');
        $sheet->setCellValue('C1', 'Highest Grade');
        $sheet->setCellValue('D1', 'Lowest Grade');

        // Get data
        $courseGrades = Course::select('courses.course_name')
            ->selectRaw('COALESCE(AVG(grades.score), 0) as average_grade')
            ->selectRaw('COALESCE(MAX(grades.score), 0) as highest_grade')
            ->selectRaw('COALESCE(MIN(grades.score), 0) as lowest_grade')
            ->leftJoin('grades', 'courses.CourseId', '=', 'grades.CourseId')
            ->groupBy('courses.course_name')
            ->get();

        // Fill data
        $row = 2;
        foreach ($courseGrades as $grade) {
            $sheet->setCellValue('A' . $row, $grade->course_name);
            $sheet->setCellValue('B' . $row, number_format($grade->average_grade, 1));
            $sheet->setCellValue('C' . $row, $grade->highest_grade);
            $sheet->setCellValue('D' . $row, $grade->lowest_grade);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="grades_report.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
