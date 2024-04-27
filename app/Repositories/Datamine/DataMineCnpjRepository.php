<?php

namespace App\Repositories\Datamine;

use App\Models\Datamine\DatamineCnpj;

class DataMineCnpjRepository
{
    /**
     * @param string $cnpj
     * 
     * @return array|null
     */
    public function getDatamineCnpjData(string $cnpj): ?array
    {
        return DatamineCnpj::cnpj($cnpj)->first()->json ?? null;
    }

    /**
     * @param array $data
     * 
     * @return DatamineCnpj
     */
    public function createNewCnpjData(array $data): DatamineCnpj
    {
        return DatamineCnpj::create($data);
    }

    /**
     * mapperBrasilApiToCnpjData
     * 
     * @param array $brasilApiData
     * 
     * @return array
     */
    public function mapperBrasilApiToCnpjData(array $brasilApiData): array
    {
        return [
            "uf" => isset($brasilApiData["uf"]) ? $brasilApiData["uf"] : null,
            "cep" => isset($brasilApiData["cep"]) ? $brasilApiData["cep"] : null,
            "qsa" => isset($brasilApiData["qsa"]) ? $brasilApiData["qsa"] : [],
            "cnpj" => isset($brasilApiData["cnpj"]) ? (int) $brasilApiData["cnpj"] : null,
            "pais" => isset($brasilApiData["pais"]) ? $brasilApiData["pais"] : null,
            "email" => isset($brasilApiData["email"]) ? $brasilApiData["email"] : null,
            "porte" => isset($brasilApiData["porte"]) ? $brasilApiData["porte"] : null,
            "bairro" => isset($brasilApiData["bairro"]) ? $brasilApiData["bairro"] : null,
            "numero" => isset($brasilApiData["numero"]) ? $brasilApiData["numero"] : null,
            "ddd_fax" => isset($brasilApiData["ddd_fax"]) ? $brasilApiData["ddd_fax"] : null,
            "municipio" => isset($brasilApiData["municipio"]) ? $brasilApiData["municipio"] : null,
            "logradouro" => isset($brasilApiData["logradouro"]) ? $brasilApiData["logradouro"] : null,
            "cnae_fiscal" => isset($brasilApiData["cnae_fiscal"]) ? $brasilApiData["cnae_fiscal"] : null,
            "codigo_pais" => isset($brasilApiData["codigo_pais"]) ? $brasilApiData["codigo_pais"] : null,
            "complemento" => isset($brasilApiData["complemento"]) ? $brasilApiData["complemento"] : null,
            "codigo_porte" => isset($brasilApiData["codigo_porte"]) ? $brasilApiData["codigo_porte"] : null,
            "razao_social" => isset($brasilApiData["razao_social"]) ? $brasilApiData["razao_social"] : null,
            "nome_fantasia" => isset($brasilApiData["nome_fantasia"]) ? $brasilApiData["nome_fantasia"] : null,
            "capital_social" => isset($brasilApiData["capital_social"]) ? $brasilApiData["capital_social"] : null,
            "ddd_telefone_1" => isset($brasilApiData["ddd_telefone_1"]) ? $brasilApiData["ddd_telefone_1"] : null,
            "ddd_telefone_2" => isset($brasilApiData["ddd_telefone_2"]) ? $brasilApiData["ddd_telefone_2"] : null,
            "opcao_pelo_mei" => isset($brasilApiData["opcao_pelo_mei"]) ? $brasilApiData["opcao_pelo_mei"] : null,
            "descricao_porte" => isset($brasilApiData["descricao_porte"]) ? $brasilApiData["descricao_porte"] : null,
            "codigo_municipio" => isset($brasilApiData["codigo_municipio"]) ? $brasilApiData["codigo_municipio"] : null,
            "cnaes_secundarios" => isset($brasilApiData["cnaes_secundarios"]) ? $brasilApiData["cnaes_secundarios"] : [],
            "natureza_juridica" => isset($brasilApiData["natureza_juridica"]) ? $brasilApiData["natureza_juridica"] : null,
            "situacao_especial" => isset($brasilApiData["situacao_especial"]) ? $brasilApiData["situacao_especial"] : null,
            "opcao_pelo_simples" => isset($brasilApiData["opcao_pelo_simples"]) ? $brasilApiData["opcao_pelo_simples"] : null,
            "situacao_cadastral" => isset($brasilApiData["situacao_cadastral"]) ? $brasilApiData["situacao_cadastral"] : null,
            "data_opcao_pelo_mei" => isset($brasilApiData["data_opcao_pelo_mei"]) ? $brasilApiData["data_opcao_pelo_mei"] : null,
            "data_exclusao_do_mei" => isset($brasilApiData["data_exclusao_do_mei"]) ? $brasilApiData["data_exclusao_do_mei"] : null,
            "cnae_fiscal_descricao" => isset($brasilApiData["cnae_fiscal_descricao"]) ? $brasilApiData["cnae_fiscal_descricao"] : null,
            "codigo_municipio_ibge" => isset($brasilApiData["codigo_municipio_ibge"]) ? $brasilApiData["codigo_municipio_ibge"] : null,
            "data_inicio_atividade" => isset($brasilApiData["data_inicio_atividade"]) ? $brasilApiData["data_inicio_atividade"] : null,
            "data_situacao_especial" => isset($brasilApiData["data_situacao_especial"]) ? $brasilApiData["data_situacao_especial"] : null,
            "data_opcao_pelo_simples" => isset($brasilApiData["data_opcao_pelo_simples"]) ? $brasilApiData["data_opcao_pelo_simples"] : null,
            "data_situacao_cadastral" => isset($brasilApiData["data_situacao_cadastral"]) ? $brasilApiData["data_situacao_cadastral"] : null,
            "nome_cidade_no_exterior" => isset($brasilApiData["nome_cidade_no_exterior"]) ? $brasilApiData["nome_cidade_no_exterior"] : null,
            "codigo_natureza_juridica" => isset($brasilApiData["codigo_natureza_juridica"]) ? $brasilApiData["codigo_natureza_juridica"] : null,
            "data_exclusao_do_simples" => isset($brasilApiData["data_exclusao_do_simples"]) ? $brasilApiData["data_exclusao_do_simples"] : null,
            "motivo_situacao_cadastral" => isset($brasilApiData["motivo_situacao_cadastral"]) ? $brasilApiData["motivo_situacao_cadastral"] : null,
            "ente_federativo_responsavel" => isset($brasilApiData["ente_federativo_responsavel"]) ? $brasilApiData["ente_federativo_responsavel"] : null,
            "identificador_matriz_filial" => isset($brasilApiData["identificador_matriz_filial"]) ? $brasilApiData["identificador_matriz_filial"] : null,
            "qualificacao_do_responsavel" => isset($brasilApiData["qualificacao_do_responsavel"]) ? $brasilApiData["qualificacao_do_responsavel"] : null,
            "descricao_situacao_cadastral" => isset($brasilApiData["descricao_situacao_cadastral"]) ? $brasilApiData["descricao_situacao_cadastral"] : null,
            "descricao_tipo_de_logradouro" => isset($brasilApiData["descricao_tipo_de_logradouro"]) ? $brasilApiData["descricao_tipo_de_logradouro"] : null,
            "descricao_motivo_situacao_cadastral" => isset($brasilApiData["descricao_motivo_situacao_cadastral"]) ? $brasilApiData["descricao_motivo_situacao_cadastral"] : null,
            "descricao_identificador_matriz_filial" => isset($brasilApiData["descricao_identificador_matriz_filial"]) ? $brasilApiData["descricao_identificador_matriz_filial"] : null
        ];
    }
}
