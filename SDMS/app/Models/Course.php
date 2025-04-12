<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $primaryKey = 'CourseId';

    protected $fillable = [
        'course_code',
        'course_name',
        'description',
        'credits',
        'instructor',
        'status'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'CourseId', 'StudentId')
            ->withTimestamps();
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
