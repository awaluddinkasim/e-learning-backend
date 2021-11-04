<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuisAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuis_attachment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kuis');
            $table->foreignId('uploader');
            $table->string('file');
            $table->timestamps();
            $table->foreign('id_kuis')->references('id')->on('kuis')
            ->onDelete('cascade')
            ->onDelete('cascade');
            $table->foreign('uploader')->references('id')->on('users')
            ->onDelete('cascade')
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
        Schema::dropIfExists('kuis_attachment');
    }
}
