<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_return', function (Blueprint $table) {
            $table->bigIncrements('id_book_return');
            $table->unsignedBigInteger('id_book_borrow');
            $table->date('date_of_returning');
            $table->integer('fine');
            $table->timestamps();

            $table->foreign('id_book_borrow')->references('id_book_borrow')->on('book_borrow');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_return');
    }
}
