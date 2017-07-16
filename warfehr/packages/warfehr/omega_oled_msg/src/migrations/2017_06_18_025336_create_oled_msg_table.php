<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOledMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('oled_msg')) {
            Schema::create('oled_msg', function (Blueprint $table) {
                $table->increments('id');
                $table->string('author');
                $table->longText('content');
                $table->integer('columns');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('oled_msg')) {
            Schema::drop('oled_msg');
        }
    }
}
