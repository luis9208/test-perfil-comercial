<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellido_1');
            $table->string('apellido_2');
            $table->string('cedula');
            $table->date('fecha_nacimiento');
            $table->string('genero');
            $table->date('fecha_ingreso');
            $table->bigInteger('numero_empleado')->unique();
            $table->string('cargo');
            $table->bigInteger('jefe')->nullable();
            $table->string('zona');
            $table->string('municipio');
            $table->string('departamento');
            $table->double('ventas', 15,2)->nullable()->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('imagen');
            $table->string('celular');
            $table->boolean('admin')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
