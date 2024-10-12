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
        Schema::create('skybox_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('texture_id')->nullable();
            $table->unsignedBigInteger('thumbnail_id')->nullable();
            $table->timestamps();
        });

        Schema::table('skybox_backgrounds', function (Blueprint $table) {
            $table->foreign('texture_id')
                ->references('id')
                ->on('media_files')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('thumbnail_id')
                ->references('id')
                ->on('media_files')
                ->onDelete('set null')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skybox_backgrounds');
    }
};
