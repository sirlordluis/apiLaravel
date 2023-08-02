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
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('folio')->unique();
            $table->integer('numeroCentro');
            $table->string('empresa');
            $table->string('pais');
            $table->string('estado');
            $table->string('nombreDenunciante')->nullable();
            $table->string('correoDenunciante')->nullable();
            $table->string('telefonoDenunciante')->nullable();
            $table->string('detalle');
            $table->date('fecha');
            $table->string('contrasena');
            $table->string('status');

            $table->foreignId('fk_admin')
            ->constrained('administradors')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
