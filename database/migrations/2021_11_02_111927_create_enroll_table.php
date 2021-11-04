<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enroll', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kelas', 7);
            $table->foreignId('id_user');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')
            ->onDelete('cascade')
            ->onDelete('cascade');
            $table->foreign('kode_kelas')->references('kode')->on('kelas')
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
        Schema::dropIfExists('enroll');
    }
}
