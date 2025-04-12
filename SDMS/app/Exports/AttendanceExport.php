<?php
namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Attendance;

class AttendanceExport {
    protected $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function export() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        $sheet->fromArray([
            ['Course', 'Section', 'Student Name', 'Status', 'Date', 'Remarks']
        ], NULL, 'A1');

        // Add data
        $data = $this->getAttendanceData();
        $sheet->fromArray($data, NULL, 'A2');

        $writer = new Xlsx($spreadsheet);
        $filename = 'attendance_report_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
    }

    private function getAttendanceData() {
        return Attendance::query()
            ->join('courses', 'attendances.course_id', '=', 'courses.id')
            ->join('sections', 'attendances.section_id', '=', 'sections.id')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->select('courses.course_name', 'sections.section_name',
                    'students.name as student_name', 'attendances.*')
            // Add your existing filters here
            ->get()
            ->map(function($attendance) {
                return [
                    $attendance->course_name,
                    $attendance->section_name,
                    $attendance->student_name,
                    ucfirst($attendance->status),
                    $attendance->created_at->format('Y-m-d'),
                    $attendance->remarks ?? '-'
                ];
            })
            ->toArray();
    }
}
