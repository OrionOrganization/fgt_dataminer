<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatamineDividaAbertaRawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datamine_divida_aberta_raws', function (Blueprint $table) {
            $table->id();

            $table->string('cpf_cnpj')->nullable();
            $table->string('tipo_pessoa')->nullable();
            $table->string('tipo_devedor')->nullable();
            $table->string('nome_devedor')->nullable();
            $table->string('uf_devedor')->nullable();
            $table->string('unidade_responsavel')->nullable();
            $table->string('entidade_responsavel')->nullable();
            $table->string('unidade_inscricao')->nullable();
            $table->string('numero_inscricao')->nullable();
            $table->string('tipo_situacao_inscricao')->nullable();
            $table->string('situacao_inscricao')->nullable();
            $table->string('tipo_credito')->nullable();
            $table->string('receita_principal')->nullable();
            $table->date('data_inscricao')->nullable();
            $table->string('indicador_ajuizado')->nullable();
            $table->bigInteger('valor_consolidado')->nullable();
            $table->string('file_type')->nullable();
            $table->integer('file_year')->nullable();
            $table->integer('file_quarter')->nullable();
            $table->integer('file_time')->nullable();
            $table->string('file_name', 400)->nullable();
            $table->integer('status')->nullable();

            $table->timestamps();

            $table->index('cpf_cnpj');
            $table->index('tipo_pessoa');
            $table->index('tipo_devedor');
            $table->index('uf_devedor');
            $table->index('numero_inscricao');
            $table->index('tipo_situacao_inscricao');
            $table->index('situacao_inscricao');
            $table->index('data_inscricao');
            $table->index('valor_consolidado');

            $table->index('file_type');
            $table->index('file_year');
            $table->index('file_quarter');
            $table->index('file_time');
            $table->index('file_name');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datamine_divida_aberta_raws');
    }
}
