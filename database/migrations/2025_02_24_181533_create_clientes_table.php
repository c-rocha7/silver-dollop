<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigInteger('recnum')->unsigned();
            $table->decimal('empresa', 4, 0);
            $table->decimal('codigo', 14, 0)->primary();
            $table->string('razao_social', 255);
            $table->enum('tipo', ['PJ', 'PF']);
            $table->string('cpf_cnpj', 14);
            $table->timestamps();

            // Garantimos que recnum seja único
            $table->unique('recnum');
            $table->foreign('empresa')->references('codigo')->on('empresas');
        });

        // Criamos uma tabela auxiliar para manter o contador
        DB::unprepared('CREATE TABLE IF NOT EXISTS cliente_sequence (id INT NOT NULL, seq_value BIGINT NOT NULL, PRIMARY KEY (id))');
        DB::unprepared('INSERT INTO cliente_sequence (id, seq_value) VALUES (1, 0)');

        // Criamos um trigger BEFORE INSERT para atualizar o recnum
        DB::unprepared('
            CREATE TRIGGER tr_cliente_before_insert
            BEFORE INSERT ON clientes
            FOR EACH ROW
            BEGIN
                UPDATE cliente_sequence SET seq_value = seq_value + 1 WHERE id = 1;
                SET NEW.recnum = (SELECT seq_value FROM cliente_sequence WHERE id = 1);
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tr_cliente_before_insert');
        DB::unprepared('DROP TABLE IF EXISTS cliente_sequence');
        Schema::dropIfExists('clientes');
    }
};
