<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $activeCourses = Course::where('status', '=', 'active')->count();

        $todayAttendance = Attendance::whereDate('created_at', today())
            ->selectRaw('(COUNT(CASE WHEN status = "present" THEN 1 END) * 100.0 / NULLIF(COUNT(*), 0)) as percentage')
            ->first();
        $attendancePercentage = number_format($todayAttendance->percentage ?? 0, 1);

        $averageGrade = number_format(Grade::avg('score') ?? 0, 1);

        $activitiesQuery = Activity::with('user')->orderBy('created_at', 'desc');
        //filter
        $filter = request('filter');

        $query = Activity::query()->latest();

        $query->when($filter === 'today', function ($q) {
            return $q->whereDate('created_at', Carbon::today());
        })->when($filter === 'week', function ($q) {
            return $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })->when($filter === 'month', function ($q) {
            return $q->whereMonth('created_at', Carbon::now()->month);
        });

        $recentActivities = $query->paginate(10);
        return view('dashboard', compact('totalStudents', 'activeCourses', 'attendancePercentage', 'averageGrade', 'recentActivities'));
    }
}
