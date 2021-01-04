<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImgTweetCreatedAts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('img_created_at', 'tweet_created_at')) {
            Schema::table('oled_msg', function (Blueprint $table) {
                $table->date('img_created_at')->nullable();
                $table->date('tweet_created_at')->nullable();
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
        if (Schema::hasColumn('img_created_at', 'tweet_created_at')) {
            Schema::table('oled_msg', function (Blueprint $table) {
                $table->dropColumn('img_created_at');
                $table->dropColumn('tweet_created_at');
            });
        }
    }
}
