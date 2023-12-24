<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome')->nullable(false);
            $table->unsignedInteger('numero_funcionario')->nullable(false);
            $table->unsignedBigInteger('acn_id')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('numero_telefone');

            $table->foreign('acn_id')->references('id')->on('acns');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
