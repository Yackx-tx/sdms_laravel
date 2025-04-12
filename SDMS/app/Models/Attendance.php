<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'StudentId',
        'SectionId',
        'CourseId',
        'date',
        'status',
        'remarks'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'StudentId', 'StudentId');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'SectionId', 'SectionId');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'CourseId', 'CourseId');
    }

    public static function getAttendanceByDate($sectionId, $courseId, $date)
    {
        return self::where([
            'SectionId' => $sectionId,
            'CourseId' => $courseId,
            'date' => $date
        ])->get();
    }
}
