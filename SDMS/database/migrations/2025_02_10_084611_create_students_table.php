<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->bigIncrements('SectionId');
            $table->string('SectionName');
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('StudentId');
            $table->unsignedBigInteger('SectionId');
            $table->string('FirstName');
            $table->string('LastName');
            $table->enum('Gender', ['Male', 'Female', 'Other']);
            $table->date('DateOfBirth');
            $table->string('ContactNumber', 20);
            $table->string('Email')->unique();
            $table->text('Address')->nullable();
            $table->date('EnrollmentDate');
            $table->timestamps();

            $table->foreign('SectionId')
                ->references('SectionId')
                ->on('sections')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('sections');
    }
};
