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
            $table->foreignId('curso_id')->nullable(false);
            $table->foreignId('unidade_curricular_id')->nullable(false)->constrained(
                table:'unidades_curriculares', indexName:'id'
            );

            $table->unique(['curso_id', 'unidade_curricular_id']);
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
