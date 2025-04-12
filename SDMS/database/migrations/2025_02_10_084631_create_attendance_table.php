<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('StudentId')->constrained('students', 'StudentId')->onDelete('cascade');
            $table->foreignId('SectionId')->constrained('sections', 'SectionId')->onDelete('cascade');
            $table->foreignId('CourseId')->constrained('courses', 'CourseId')->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
