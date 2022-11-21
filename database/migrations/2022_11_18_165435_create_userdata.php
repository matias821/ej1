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
        Schema::create('userdata', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('iduser');
            $table->string('nombre');
            $table->string('domicilio')->nullable();
            $table->string('imagenes')->nullable();
            $table->string('edad')->nullable();
            $table->string('actividad')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('userdata', function (Blueprint $table) {
            //
        });
    }
};
