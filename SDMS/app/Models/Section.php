<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $primaryKey = 'SectionId';

    protected $fillable = [
        'SectionName',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'SectionId', 'SectionId');
    }
}
