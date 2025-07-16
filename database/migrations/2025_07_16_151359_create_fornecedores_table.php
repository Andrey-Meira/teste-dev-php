<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('tipo_documento', ['CPF', 'CNPJ']);
            $table->string('documento')->unique();
            $table->string('nome_fantasia');
            $table->string('razao_social');
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
};
