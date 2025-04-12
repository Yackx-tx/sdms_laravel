<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'StudentId';

    protected $fillable = [
        'FirstName',
        'LastName',
        'SectionId',
        'Gender',
        'DateOfBirth',
        'ContactNumber',
        'Email',
        'Address',
        'EnrollmentDate'
    ];
    protected $dates = [
        'DateOfBirth',
        'EnrollmentDate'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->FirstName} {$this->LastName}";
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'SectionId');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'StudentId', 'CourseId');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'StudentId', 'StudentId');
    }


    public function grades()
    {
        return $this->hasMany(Grade::class, 'StudentId', 'StudentId');
    }
}
