<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigInteger('recnum')->unsigned();
            $table->decimal('codigo', 4, 0)->primary();
            $table->decimal('empresa', 4, 0);
            $table->string('sigla', 40);
            $table->string('razao_social', 255);
            $table->timestamps();

            // Garantimos que recnum seja único
            $table->unique('recnum');
        });

        // Criamos uma tabela auxiliar para manter o contador
        DB::unprepared('CREATE TABLE IF NOT EXISTS empresa_sequence (id INT NOT NULL, seq_value BIGINT NOT NULL, PRIMARY KEY (id))');
        DB::unprepared('INSERT INTO empresa_sequence (id, seq_value) VALUES (1, 0)');

        // Criamos um trigger BEFORE INSERT para atualizar o recnum
        DB::unprepared('
            CREATE TRIGGER tr_empresa_before_insert
            BEFORE INSERT ON empresas
            FOR EACH ROW
            BEGIN
                UPDATE empresa_sequence SET seq_value = seq_value + 1 WHERE id = 1;
                SET NEW.recnum = (SELECT seq_value FROM empresa_sequence WHERE id = 1);
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tr_empresa_before_insert');
        DB::unprepared('DROP TABLE IF EXISTS empresa_sequence');
        Schema::dropIfExists('empresas');
    }
};
