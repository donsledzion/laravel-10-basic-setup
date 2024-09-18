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
            $table->string('color_floor')->default("#32cd78")->after('logo');
            $table->string('color_answer_background')->default("#ffffff")->after('logo');
            $table->string('color_question_background')->default("#000000")->after('logo');
            $table->string('color_answer_text')->default("#ffffff")->after('logo');
            $table->string('color_question_text')->default("#000000")->after('logo');
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
            $table->dropColumn('color_floor');
            $table->dropColumn('color_answer_background');
            $table->dropColumn('color_question_background');
            $table->dropColumn('color_answer_text');
            $table->dropColumn('color_question_text');
        });
    }
};
