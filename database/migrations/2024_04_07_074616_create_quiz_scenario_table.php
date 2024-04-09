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
        Schema::create('quiz_scenario', function (Blueprint $table) {
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('scenario_id');
            $table->unique(['quiz_id','scenario_id']);
        });

        Schema::table('quiz_scenario', function (Blueprint $table) {
            $table->foreign('quiz_id')
                    ->references('id')
                    ->on('quizzes')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('scenario_id')
                    ->references('id')
                    ->on('scenarios')
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
        Schema::dropIfExists('quiz_scenario');
    }
};
