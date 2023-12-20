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
            $table->foreignId('periodo_id')->nullable(false);
            $table->foreignId('docente_id')->nullable(false);
            $table->string('impedimentos')->nullable(false);
            $table->text('justificacao');

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
