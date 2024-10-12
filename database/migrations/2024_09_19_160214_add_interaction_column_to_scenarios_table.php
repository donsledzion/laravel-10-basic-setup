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
            $table->unsignedBigInteger('interaction_id')->nullable();
        });
        Schema::table('scenarios', function (Blueprint $table) {
            $table->foreign('interaction_id')
                ->references('id')
                ->on('answering_interaction_types')
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
            Schema::table('scenarios', function (Blueprint $table) {
                $table->dropForeign('scenarios_interaction_id_foreign');
            });
            Schema::table('scenarios', function (Blueprint $table) {
                $table->dropColumn('interaction_id');
            });
        });
    }
};
