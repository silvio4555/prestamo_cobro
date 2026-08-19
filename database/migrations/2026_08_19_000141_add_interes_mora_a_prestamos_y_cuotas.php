<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {

            // Si el préstamo aplica un interés extra cuando una cuota se vence.
            $table->boolean('aplica_interes_mora')
                ->default(false)
                ->after('dias_plazo');

            // Porcentaje que se suma sobre el saldo de la cuota al vencerse.
            $table->decimal('porcentaje_interes_mora', 5, 2)
                ->nullable()
                ->after('aplica_interes_mora');
        });

        Schema::table('cuotas', function (Blueprint $table) {

            // Cuánto interés de mora se le ha sumado ya a esta cuota.
            $table->decimal('interes_mora', 10, 2)
                ->default(0)
                ->after('dias_retraso');

            // Evita que el interés de mora se vuelva a sumar cada vez que
            // corre el comando cuotas:actualizar-vencidas.
            $table->boolean('mora_aplicada')
                ->default(false)
                ->after('interes_mora');
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropColumn(['aplica_interes_mora', 'porcentaje_interes_mora']);
        });

        Schema::table('cuotas', function (Blueprint $table) {
            $table->dropColumn(['interes_mora', 'mora_aplicada']);
        });
    }
};