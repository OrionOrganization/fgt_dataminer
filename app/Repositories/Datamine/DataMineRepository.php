<?php

namespace App\Repositories\Datamine;

use App\Enum\Datamine\DataMineRawStatus;
use App\Models\Datamine\DatamineDividaAbertaRaw;
use App\Models\Datamine\DatamineEntity;
use App\Models\Datamine\DatamineEntityValue;
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
     * @param array $dataCpfCnpj
     * @param array $dataValues
     * @param string $key
     * 
     * @return void
     */
    public function updateOrCreateDataMineEntityWithValues(
        array $dataCpfCnpj,
        array $dataValues,
        string $key
    ): void {
        $model = DatamineEntity::updateOrCreate(['key' => $key], $dataCpfCnpj);

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