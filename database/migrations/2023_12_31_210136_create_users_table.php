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
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamp('email_verificado_a')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('admin')->nullable(false);
            $table->unsignedBigInteger('docente_id')->nullable();

            $table->foreign('docente_id')->references('id')->on('docentes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
