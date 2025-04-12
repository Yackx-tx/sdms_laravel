<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_student', function (Blueprint $table) {
            $table->primary(['StudentId', 'CourseId']);
            $table->foreignId('StudentId')->constrained('students', 'StudentId')->onDelete('cascade');
            $table->foreignId('CourseId')->constrained('courses', 'CourseId')->onDelete('cascade');
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('course_student');
    }
};
