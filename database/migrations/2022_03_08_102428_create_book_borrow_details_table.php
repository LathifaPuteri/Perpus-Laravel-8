<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookBorrowDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_borrow_details', function (Blueprint $table) {
            $table->bigIncrements('id_book_borrow_detail');
            $table->unsignedBigInteger('id_book_borrow');
            $table->unsignedBigInteger('id_book');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('id_book_borrow')->references('id_book_borrow')->on('book_borrow');
            $table->foreign('id_book')->references('id_book')->on('book');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_borrow_details');
    }
}
