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
            $table->unsignedBigInteger('up_picture_id');
            $table->unsignedBigInteger('down_picture_id');
            $table->unsignedBigInteger('front_picture_id');
            $table->unsignedBigInteger('back_picture_id');
            $table->unsignedBigInteger('left_picture_id');
            $table->unsignedBigInteger('right_picture_id');
            $table->timestamps();
        });

        Schema::table('skybox_backgrounds', function (Blueprint $table) {
            $table->foreign('up_picture_id')
                ->references('id')
                ->on('media_files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('down_picture_id')
                ->references('id')
                ->on('media_files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('front_picture_id')
                ->references('id')
                ->on('media_files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('back_picture_id')
                ->references('id')
                ->on('media_files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('left_picture_id')
                ->references('id')
                ->on('media_files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('right_picture_id')
                ->references('id')
                ->on('media_files')
                ->onDelete('cascade')
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
