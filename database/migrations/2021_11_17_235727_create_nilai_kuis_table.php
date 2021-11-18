<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiKuisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kuis');
            $table->tinyInteger('nilai');
            $table->timestamps();
            $table->foreign('id_kuis')->references('id')->on('kuis_attachment')
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
        Schema::dropIfExists('nilai_kuis');
    }
}
