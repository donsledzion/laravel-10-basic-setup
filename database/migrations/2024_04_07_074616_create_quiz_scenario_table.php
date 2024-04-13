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
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('scenario_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['quiz_id','scenario_id']);
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
