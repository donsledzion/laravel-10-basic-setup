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
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('logo');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('logo')
                ->after('headset_login')
                ->nullable();
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->foreign('logo')
                ->references('id')
                ->on('media_files')
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
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign('organizations_logo_foreign');
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('logo');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->string('logo')->nullable();
        });

    }
};
