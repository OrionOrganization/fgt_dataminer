<?php

namespace App\Repositories\Datamine;

use App\Enum\Datamine\DataMineRawStatus;
use App\Models\Datamine\DatamineDividaAbertaRaw;
use App\Models\Datamine\DatamineEntity;
use App\Models\Datamine\DatamineEntityValue;
use App\Services\DocumentService;
use Illuminate\Support\Collection;

class DataMineRepository
{
    /**
     * @param string $cnpj
     * 
     * @return Collection
     */
    public function getDataMineRawsByCnpj(string $cnpj): Collection
    {
        return DatamineDividaAbertaRaw::cnpj($cnpj)->get();
    }

    public function getDataMineRawsByCpf(string $cpf): Collection
    {
        return DatamineDividaAbertaRaw::cpf($cpf)->get();
    }

    /**
     * @param array $data
     * 
     * @return DataMineEntityValue
     */
    public function storeDataMineEntityValue(array $data): DataMineEntityValue
    {
        return DatamineEntityValue::create($data);
    }

    /**
     * @param array $dataCnpj
     * @param array $dataValues
     * @param string $key
     * 
     * @return void
     */
    public function updateOrCreateDataMineEntityWithValuesCnpj(
        array $dataCnpj,
        array $dataValues,
        string $key
    ): void {
        $model = DatamineEntity::updateOrCreate(['key' => $key], $dataCnpj);

        DataMineEntityValue::updateOrCreate(['id' => $model->id], $dataValues);
    }

        /**
     * @param array $dataCpf
     * @param array $dataValues
     * @param string $key
     * 
     * @return void
     */
    public function updateOrCreateDataMineEntityWithValuesCpf(
        array $dataCpf,
        array $dataValues,
        string $key
    ): void {
        $cpf = DocumentService::getOnlyNumber($key);

        $extra = json_decode($dataCpf['extra']);
        
        $model = DatamineEntity::updateOrCreate(
            ['key_unmask' => $cpf, 'extra->nome_devedor' => $extra->nome_devedor],
            $dataCpf,
        );

        DataMineEntityValue::updateOrCreate(['id' => $model->id], $dataValues);
    }

    /**
     * @param string $cpfCnpj
     * 
     * @return void
     */
    public function setDatamineRawsStatusAnalyzed(string $cpfCnpj): void
    {
        DatamineDividaAbertaRaw::query()
            ->where('cpf_cnpj', '=', $cpfCnpj)
            ->update(['status' => DataMineRawStatus::ANALYZED()]);
    }
}