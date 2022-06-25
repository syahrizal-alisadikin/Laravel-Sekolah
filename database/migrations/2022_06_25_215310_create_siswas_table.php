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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('alamat')->nullable();
            $table->unsignedBigInteger('kelas_id');
            $table->enum('status', ['aktif', 'non-aktif'])->default('non-aktif');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->default('laki-laki');
            $table->string('password');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswas');
    }
};
