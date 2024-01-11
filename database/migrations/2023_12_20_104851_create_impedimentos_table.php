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
        Schema::create('impedimentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('periodo_id')->nullable(false);
            $table->unsignedBigInteger('docente_id')->nullable(false);
            $table->string('impedimentos')->default('0,0,0;0,0,0;0,0,0;0,0,0;0,0,0;0,0,0;');
            $table->text('justificacao');
            $table->boolean('submetido')->nullable(false);

            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('docente_id')->references('id')->on('docentes');


            $table->unique(['periodo_id', 'docente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impedimentos');
    }
};
