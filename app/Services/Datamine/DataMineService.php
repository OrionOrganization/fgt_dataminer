<?php

namespace App\Services\Datamine;

use App\Enum\Datamine\CompanyTaxRegime;
use App\Enum\Datamine\DataMineEntitiesType;
use App\Enum\Datamine\SubscriptionSituationType;
use App\Integrations\Client\BrasilApiClient;
use App\Repositories\Datamine\DataMineRepository;
use App\Services\DocumentService;
use Exception;
use Illuminate\Support\Collection;

class DataMineService
{
    protected $taxBenefitType;
    protected $inCollectionType;
    protected $inNegociationType;
    protected $guaranteeType;
    protected $suspendType;
    protected $othersType;

    /**
     * @var \App\Repositories\Datamine\DataMineRepository
     */
    protected $dataMineRepository;

    /**
     * @var \App\Integrations\Client\BrasilApiClient
     */
    protected $brasilApiClient;

    public function __construct(
        DataMineRepository $dataMineRepository,
        BrasilApiClient $brasilApiClient
    ) {
        $this->dataMineRepository = $dataMineRepository;
        $this->brasilApiClient = $brasilApiClient;

        $this->taxBenefitType = SubscriptionSituationType::TAX_BENEFIT_TYPE()->getLabel();
        $this->inCollectionType = SubscriptionSituationType::IN_COLLECTION_TYPE()->getLabel();
        $this->inNegociationType = SubscriptionSituationType::IN_NEGOCIATION_TYPE()->getLabel();
        $this->guaranteeType = SubscriptionSituationType::GUARANTEE_TYPE()->getLabel();
        $this->suspendType = SubscriptionSituationType::SUSPENDED_TYPE()->getLabel();
        $this->othersType = SubscriptionSituationType::OTHERS_TYPE()->getLabel();
    }

    /**
     * @param string $key
     * 
     * @return void
     */
    public function analyzeDatamineRaws(string $key): void
    {
        if(DocumentService::validateCnpj($key)) {
            $this->analyzeDatamineRawCnpj($key);
        } else {
            $this->analyzeDatamineRawCpf($key);
        }
    }

    /**
     * @param string $cpf
     * 
     * @return void
     */
    protected function analyzeDatamineRawCpf(string $cpf): void
    {
        $cpfData = $this->cpfGetInformation($cpf);

        $dataMineRaws = $this->dataMineRepository->getDataMineRawsByCpf($cpf);

        $dataValues = $this->entityRawGroupByValues($dataMineRaws);

        $this->dataMineRepository->updateOrCreateDataMineEntityWithValues(
            $cpfData,
            $dataValues,
            $cpf
        );

        $this->dataMineRepository->setDatamineRawsStatusAnalyzed($cpf);
    }

    /**
     * @param string $cpf
     * 
     * @return array
     */
    protected function cpfGetInformation(string $cpf): array
    {
        return [
            'key' => $cpf,
            'type_entity' => DataMineEntitiesType::PF(),
            'type_tax_regime' => CompanyTaxRegime::NONE()
        ];
    }

    /**
     * @param string $cnpj
     * 
     * @return void
     */
    protected function analyzeDatamineRawCnpj(string $cnpj): void
    {
        $cnpjData = $this->cnpjGetInformation($cnpj);

        $dataMineRaws = $this->dataMineRepository->getDataMineRawsByCnpj($cnpj);

        $dataValues = $this->entityRawGroupByValues($dataMineRaws);

        $this->dataMineRepository->updateOrCreateDataMineEntityWithValues(
            $cnpjData,
            $dataValues,
            $cnpj
        );

        $this->dataMineRepository->setDatamineRawsStatusAnalyzed($cnpj);
    }

    /**
     * @param string $cnpj
     * 
     * @return array
     */
    protected function cnpjGetInformation(string $formatedCnpj): array
    {
        try {
            $cnpj = DocumentService::getOnlyNumber($formatedCnpj);

            $cnpjData = $this->brasilApiClient->getCnpj($cnpj);

            $taxRegime = $this->getCnpjTaxRegime($cnpjData);

            $address = $this->getCnpjAddress($cnpjData);

            return [
                'code_ibge' => $cnpjData['codigo_municipio_ibge'] ?? '',
                'type_tax_regime' => $taxRegime,
                'key' => $formatedCnpj,
                'type_entity' => DataMineEntitiesType::PJ(),
                'address' => $address
            ];
        } catch (Exception $e) {
            throw new Exception('Erro ao obter informações públicas do CNPJ');
        }
    }

    /**
     * @param Collection $dataMineRaws
     * 
     * @return array
     */
    protected function entityRawGroupByValues(Collection $dataMineRaws): array
    {
        $valueAll = $dataMineRaws->sum('valor_consolidado');

        $sumValues = $this->entityRawGroupByValuesType($dataMineRaws);

        $sumJudged = $dataMineRaws->where('indicador_ajuizado', 'SIM')->sum('valor_consolidado');
        $sumUnjudged = $dataMineRaws->where('indicador_ajuizado', 'NAO')->sum('valor_consolidado');

        return [
            'value_all' => $valueAll,
            'value_type_tax_benefit' => $sumValues[$this->taxBenefitType],
            'value_type_in_collection' => $sumValues[$this->inCollectionType],
            'value_type_in_negociation' => $sumValues[$this->inNegociationType],
            'value_type_guarantee' => $sumValues[$this->guaranteeType],
            'value_type_suspended' => $sumValues[$this->suspendType],
            'value_type_others' => $sumValues[$this->othersType],
            'value_indicador_ajuizado' => $sumJudged,
            'value_n_indicador_ajuizado' => $sumUnjudged,
        ];
    }

    /**
     * @param Collection $dataMineRaws
     * 
     * @return array
     */
    protected function entityRawGroupByValuesType(Collection $dataMineRaws): array
    {
        $groupedValues = $dataMineRaws->groupBy('tipo_situacao_inscricao');

        $sumValues = [
            $this->taxBenefitType => 0,
            $this->inCollectionType => 0,
            $this->inNegociationType => 0,
            $this->guaranteeType => 0,
            $this->suspendType => 0,
            $this->othersType => 0
        ];

        foreach ($groupedValues as $type => $group) {
            if (isset($sumValues[$type])) {
                $sumValues[$type] = $group->sum('valor_consolidado');
            } else {
                $sumValues[$this->othersType] += $group->sum('valor_consolidado');
            }
        }

        return $sumValues;
    }

    /**
     * @param array $cnpjData
     * 
     * @return string
     */
    protected function getCnpjTaxRegime(array $cnpjData): string
    {
        $taxRegime = ($cnpjData['opcao_pelo_simples'])
            ? CompanyTaxRegime::NATIONAL_SIMPLE()
            : ((!$cnpjData['opcao_pelo_mei']) ? CompanyTaxRegime::PROFIT() : CompanyTaxRegime::NONE());
        
        return $taxRegime;
    }

    /**
     * @param array $cnpjData
     * 
     * @return array
     */
    protected function getCnpjAddress(array $cnpjData): array
    {
        return [
            'Bairro: ' . $cnpjData["bairro"],
            'Número: ' . $cnpjData["numero"],
            'CEP: ' . $cnpjData["cep"],
            'Município: ' . $cnpjData["municipio"],
            'Logradouro: ' . $cnpjData["logradouro"],
            'UF: ' . $cnpjData["uf"]
        ];
    }
}
