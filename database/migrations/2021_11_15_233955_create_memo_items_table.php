<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('memo_id')->unsigned();
            $table->string('comic_title');
            $table->bigInteger('comic_number')->default(1);
            $table->bigInteger('order');
            $table->timestamps();
            $table->foreign('memo_id')->references('id')->on('memos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memo_items');
        Schema::dropForeign('memo_items_memo_id_foreign');;
    }
}
