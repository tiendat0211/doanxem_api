<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToFcmTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->string('device_model')->default('');
            $table->string('device_name')->default('');
            $table->string('app_version')->default('');
            $table->string('os_version')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->dropColumn('device_model');
            $table->dropColumn('device_id');
            $table->dropColumn('app_version');
            $table->dropColumn('os_version');
        });
    }
}
