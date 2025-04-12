<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('StudentId')->constrained('students', 'StudentId')->onDelete('cascade');
            $table->foreignId('CourseId')->constrained('courses', 'CourseId')->onDelete('cascade');
            $table->decimal('score', 5, 2);
            $table->string('grade_letter');
            $table->string('semester');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
};
