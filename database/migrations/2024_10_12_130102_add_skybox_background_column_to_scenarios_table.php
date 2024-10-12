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
            $table->unsignedBigInteger('skybox_background_id')->nullable();
        });
        Schema::table('scenarios', function (Blueprint $table) {
            $table->foreign('skybox_background_id')
                ->references('id')
                ->on('skybox_backgrounds')
                ->onUpdate('cascade')
                ->nullOnDelete();
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
            $table->dropForeign('scenarios_skybox_background_id_foreign');
        });
        Schema::table('scenarios', function (Blueprint $table) {
            $table->dropColumn('skybox_background_id');
        });
    }
};
