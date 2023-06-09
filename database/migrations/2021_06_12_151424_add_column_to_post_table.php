<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('heart')->default(0);
            $table->integer('haha')->default(0);
            $table->integer('sad')->default(0);
            $table->integer('angry')->default(0);
            $table->integer('wow')->default(0);
            $table->integer('like')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->removeColumn('heart');
            $table->removeColumn('haha');
            $table->removeColumn('sad');
            $table->removeColumn('angry');
            $table->removeColumn('wow');
            $table->removeColumn('like');
            $table->integer('upvote');
            $table->integer('downvote');
        });
    }
}
