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
            $table->foreignId('periodo_id')->nullable(false);
            $table->string('nome')->nullable(false);
            $table->foreignId('acn_id')->nullable(false);
            $table->integer('horas_semanais')->nullable(false);
            $table->boolean('laboratorio')->nullable(false);
            $table->text('software');
            $table->integer('ects')->nullable(false);
            $table->boolean('sala_avaliacao')->nullable(false);
            $table->foreignId('docente_responsavel_id')->nullable(false)->constrained(
                table: 'docentes', indexName: 'id'
            );
            $table->decimal('percentagem_semanal', 5, 4);
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
