<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id_student');
            $table->string('student_name',100);
            $table->date('date_of_birth');
            $table->enum('gender', ['L','P']);
            $table->text('address');
            $table->text('image');
            $table->unsignedBigInteger('id_class');
            $table->timestamps();

            $table->foreign('id_class')->references('id_class')->on('grade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
