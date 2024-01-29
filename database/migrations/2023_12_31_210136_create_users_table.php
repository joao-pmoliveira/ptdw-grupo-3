<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome')->nullable(false);
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verificado_a')->nullable();
            $table->string('password')->nullable(false);
            $table->rememberToken();
            $table->boolean('admin')->nullable(false);
            $table->unsignedInteger('numero_funcionario')->nullable(false);
            $table->string('numero_telefone')->nullable();
            $table->unsignedBigInteger('docente_id')->nullable();

            $table->foreign('docente_id')->references('id')->on('docentes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
