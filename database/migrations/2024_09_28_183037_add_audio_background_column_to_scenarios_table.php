<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scenarios', function (Blueprint $table) {
            $table->unsignedBigInteger('audio_background_id')->nullable();
        });
        Schema::table('scenarios', function (Blueprint $table) {
            $table->foreign('audio_background_id')
                ->references('id')
                ->on('audio_backgrounds')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scenarios', function (Blueprint $table) {
            $table->dropForeign('scenarios_audio_background_id_foreign');
        });
        Schema::table('scenarios', function (Blueprint $table) {
            $table->dropColumn('audio_background_id');
        });
    }
};
