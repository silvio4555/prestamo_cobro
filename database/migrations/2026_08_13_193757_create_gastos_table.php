<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();

            $table->date('fecha');
            $table->string('categoria', 20);
            $table->decimal('monto', 12, 2);
            $table->text('descripcion')->nullable();

            $table->timestamps();

            $table->index(['categoria', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};