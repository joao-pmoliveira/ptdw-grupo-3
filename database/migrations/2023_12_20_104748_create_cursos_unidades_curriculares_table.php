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
        Schema::create('cursos_unidades_curriculares', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('curso_id')->nullable(false);
            $table->unsignedBigInteger('unidade_curricular_id')->nullable(false);

            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->foreign('unidade_curricular_id')->references('id')->on('unidades_curriculares');

            $table->unique(['curso_id', 'unidade_curricular_id'], 'unique_curso_uc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_unidades_curriculares');
    }
};
