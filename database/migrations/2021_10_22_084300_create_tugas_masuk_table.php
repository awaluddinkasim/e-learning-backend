<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tugas');
            $table->foreignId('uploader');
            $table->string('file');
            $table->timestamps();
            $table->foreign('id_tugas')->references('id')->on('tugas')
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
        Schema::dropIfExists('tugas_masuk');
    }
}
