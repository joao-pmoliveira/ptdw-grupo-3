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
        Schema::create('unidades_curriculares', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('codigo')->nullable(false);
            $table->string('sigla')->nullable(false);
            $table->unsignedBigInteger('periodo_id')->nullable(false);
            $table->string('nome')->nullable(false);
            $table->unsignedBigInteger('acn_id')->nullable(false);
            $table->integer('horas_semanais')->nullable(false);
            $table->boolean('laboratorio')->nullable(false);
            $table->text('software');
            $table->integer('ects')->nullable(false);
            $table->boolean('sala_avaliacao')->nullable(false);
            $table->unsignedBigInteger('docente_responsavel_id')->nullable(false);

            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('acn_id')->references('id')->on('acns');
            $table->foreign('docente_responsavel_id')->references('id')->on('docentes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_curriculares');
    }
};
