<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookBorrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_borrow', function (Blueprint $table) {
            $table->bigIncrements('id_book_borrow');
            $table->unsignedBigInteger('id_student');
            $table->date('date_of_borrowing');
            $table->date('date_of_returning');
            $table->timestamps();

            $table->foreign('id_student')->references('id_student')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_borrow');
    }
}
