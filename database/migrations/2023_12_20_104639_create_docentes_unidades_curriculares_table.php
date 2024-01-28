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
        Schema::create('docentes_unidades_curriculares', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('docente_id')->nullable(false);
            $table->unsignedBigInteger('unidade_curricular_id')->nullable(false);
            $table->string('percentagem_semanal')->nullable();

            $table->foreign('docente_id')->references('id')->on('docentes');
            $table->foreign('unidade_curricular_id')->references('id')->on('unidades_curriculares');

            $table->unique(['docente_id', 'unidade_curricular_id'], 'unique_docente_uc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes_unidades_curriculares');
    }
};
