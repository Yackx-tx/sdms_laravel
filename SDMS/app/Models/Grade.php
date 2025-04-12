<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $appends = ['student_name'];

    protected $fillable = [
        'StudentId',
        'CourseId',
        'score',
        'grade_letter',
        'semester'
    ];


    public function student()
    {
        return $this->belongsTo(Student::class, 'StudentId', 'StudentId');
    }

    public function getStudentNameAttribute()
    {
        return $this->student->FirstName . ' ' . $this->student->LastName;
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'CourseId', 'CourseId');
    }
}
