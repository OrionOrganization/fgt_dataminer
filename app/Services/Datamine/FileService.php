<?php

namespace App\Services\Datamine;

use App\Models\Datamine\DatamineDividaAbertaRaw;
use App\Traits\Log\LogMessage;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileService
{
    use LogMessage;

    protected const LOCAL_TEMP = 'datamine/tmp/';
    public const LOCAL = 'datamine/files/';
    protected const LOCAL_FILED = 'datamine/filed/';
    protected const LOCAL_PATH_STORAGE = "storage/app/";

    protected const LOG_ROW_MOD = 500;

    protected $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('local');
    }


    public function processFiles()
    {
        $files = $this->disk->files(self::LOCAL);

        $this->handleMessageLog('debug', __FUNCTION__, "Arquivos encontrados: ", $files);

        foreach ($files as $file) {

            $this->processFile($file);
        }
    }

    public function processFile(string $fileName): void
    {
        if (!$this->disk->exists($fileName)) {
            $message = "Arquivo não existe: '$fileName'";
            throw new Exception($message);
        }

        $attributes = $this->processFileGetAttributes($fileName);

        if ($this->processFileGetSaveType($attributes)) {
            if ($this->processFileReadMulti($attributes)) {
                $this->processFileArchive($attributes);
            }
        }
    }

    /**
     * processFileGetAttributes
     *
     * @param string fileName
     *
     * @return array
     */
    protected function processFileGetAttributes(string $fileName): array
    {
        $data = [];

        $data['type'] = Str::between($fileName, 'TYPE_', '_YEAR_');
        $data['year'] = Str::between($fileName, '_YEAR_', '_QUARTER_');
        $data['quarter'] = Str::between($fileName, '_QUARTER_', '_NAME_');
        $data['name'] = Str::between($fileName, '_NAME_', '_TIME_');
        $data['time'] = Str::between($fileName, '_TIME_', '.');
        $data['fileName'] = $fileName;
        $data['fullName'] = self::LOCAL_PATH_STORAGE . $fileName;

        return $data;
    }

    /**
     * processFileGetSaveType
     *
     * @param array attributes
     *
     * @return bool
     */
    protected function processFileGetSaveType(array &$attributes): bool
    {
        switch ($attributes['type']) {
            case '1_divida_fgts':
                $attributes['functionName'] = 'processFileReadSaveLineFGTS';
                return true;
            case '2_divida_ativa_nao_prev':
                $attributes['functionName'] = 'processFileReadSaveLineNotPrev';
                return true;
            case '3_divida_ativa_prev':
                $attributes['functionName'] = 'processFileReadSaveLinePrev';
                return true;
        }

        $this->handleMessageLog('error', __FUNCTION__, "Não encontrado o tipo para processar", $attributes);

        return false;
    }

    /**
     * processFileArchive
     *
     * @param array attributes
     *
     * @return void
     */
    protected function processFileArchive(array $attributes): void
    {
        if (!$name = Str::afterLast($attributes['fileName'], '/')) {
            $name = Str::afterLast($attributes['fileName'], '\\');
        }

        $newFullName = $this->processFileArchiveGetUnicName(self::LOCAL_FILED . $name);

        $oldFullName = $attributes['fileName'];

        $this->disk->move($oldFullName, $newFullName);

        $this->handleMessageLog('debug', __FUNCTION__, "Arquivado from: '$oldFullName' -> to: '$newFullName'");
    }

    /**
     * processFileArchiveGetUnicName
     *
     * @param string fileName
     *
     * @return string
     */
    protected function processFileArchiveGetUnicName(string $fileName): string
    {
        if (!$this->disk->exists($fileName)) return $fileName;

        $i = 0;

        $nameExplode = explode('.', $fileName);

        do {
            $i++;

            $nemName = $nameExplode[0] . "_" . $i . "_" . $nameExplode[1];
        } while ($this->disk->exists($nemName));

        return $nemName;
    }


    protected function processFileChunk(string $fileName): void
    {
        //quebra em arquivos menores
        dd(__FUNCTION__, $fileName);
    }

    /**
     * processFileRead
     *
     * @param array attributes
     *
     * @return bool
     */
    protected function processFileRead(array $attributes): bool
    {
        $totalRow = $this->processFileReadCountRow($attributes);

        $this->handleMessageLog('info', __FUNCTION__, "Iniciando a conversão do arquivo. Total de registros: '$totalRow'", $attributes);

        $fileStream = fopen($attributes['fullName'], 'r');

        $skipHeader = true;

        $row = 0;

        $functionName = $attributes['functionName'];

        $logInRow = self::LOG_ROW_MOD;

        while ($line = $this->fileGetRow($fileStream)) {
            if ($skipHeader) {
                $skipHeader = false;
                continue;
            }

            if (($row % $logInRow) == 0) {
                $message = "Processando linha:'$row' de total:'$totalRow' em '$logInRow}' -> " . implode("; ", $line);

                $this->handleMessageLog('Debug', __FUNCTION__, $message);
            }

            $row++;

            $this->{$functionName}($attributes, $line);
        }

        $message = "Processados linha:'$row'";
        $this->handleMessageLog('Debug', __FUNCTION__, $message);

        fclose($fileStream);

        $message = "Arquivo finalizado'";
        $this->handleMessageLog('Debug', __FUNCTION__, $message);

        return true;
    }


    protected function processFileReadMulti(array $attributes): bool
    {
        ini_set('memory_limit', '-1');


        $totalRow = $this->processFileReadCountRow($attributes);

        $this->handleMessageLog('info', __FUNCTION__, "Iniciando a conversão do arquivo. Total de registros: '$totalRow'", $attributes);

        $fileStream = fopen($attributes['fullName'], 'r');

        $skipHeader = true;

        $row = 0;

        $functionName = $attributes['functionName'];

        $logInRow = self::LOG_ROW_MOD;

        $dataRows = [];
        $startMemory = memory_get_usage(true);

        while ($line = $this->fileGetRow($fileStream)) {
            if ($skipHeader) {
                $skipHeader = false;
                continue;
            }

            if (($row % ($logInRow)) == 0) {
                $this->processFileSaveData($dataRows);

                $dataRows = null;
                unset($dataRows);
                $nowMemory = memory_get_usage(true);

                $dataRows = [];
                $message = "Processando linha:'$row' de total:'$totalRow' em '$logInRow' -> MemoryStart: '$startMemory' = MemoryNow: '$nowMemory' =  MemoryDif:" . ($nowMemory - $startMemory);  //. implode("; ", $line);

                $this->handleMessageLog('Debug', __FUNCTION__, $message);
            }

            $row++;


            $dataRows[] = $this->processFileReadSaveLinePrevData($attributes, $line);
        }

        $message = "Processados linha:'$row'";
        $this->handleMessageLog('Debug', __FUNCTION__, $message);

        fclose($fileStream);

        $message = "Arquivo finalizado'";
        $this->handleMessageLog('Debug', __FUNCTION__, $message);

        return true;
    }

    protected function processFileReadSaveLineNotPrevData(array $attributes, array $dataRow): array
    {
        $data = [
            'status' => 0,
            'cpf_cnpj' => $dataRow[0] ?? '',
            'tipo_pessoa' => $dataRow[1] ?? '',
            'tipo_devedor' => $dataRow[2] ?? '',
            'nome_devedor' => $dataRow[3] ?? '',
            'uf_devedor' => $dataRow[4] ?? '',
            'unidade_responsavel' => $dataRow[5] ?? '',
            'numero_inscricao' => $dataRow[6] ?? '',
            'tipo_situacao_inscricao' => $dataRow[7] ?? '',
            'situacao_inscricao' => $dataRow[8] ?? '',
            'receita_principal' => $dataRow[9] ?? '',
            'indicador_ajuizado' => $dataRow[11] ?? '',
            'file_type' => $attributes['type'] ?? '',
            'file_year' => $attributes['year'] ?? '',
            'file_time' => $attributes['time'] ?? '',
            'file_name' => $attributes['fileName'] ?? '',
        ];

        $data['file_quarter'] = substr($attributes['quarter'] ?? '', 0, 1);

        $data['valor_consolidado'] = $this->processFileConvertValue($dataRow[12] ?? '');

        $data['data_inscricao'] = Carbon::createFromFormat('d/m/Y', $dataRow[10]);

        return $data;
    }

    protected function processFileReadSaveLinePrevData(array $attributes, array $dataRow): array
    {
        $data = [
            'status' => 0,
            'cpf_cnpj' => $dataRow[0] ?? '',
            'tipo_pessoa' => $dataRow[1] ?? '',
            'tipo_devedor' => $dataRow[2] ?? '',
            'nome_devedor' => $dataRow[3] ?? '',
            'uf_devedor' => $dataRow[4] ?? '',
            'unidade_responsavel' => $dataRow[5] ?? '',
            'numero_inscricao' => $dataRow[6] ?? '',
            'tipo_situacao_inscricao' => $dataRow[7] ?? '',
            'situacao_inscricao' => $dataRow[8] ?? '',
            'tipo_credito' => $dataRow[9] ?? '',
            'indicador_ajuizado' => $dataRow[11] ?? '',
            'file_type' => $attributes['type'] ?? '',
            'file_year' => $attributes['year'] ?? '',
            'file_time' => $attributes['time'] ?? '',
            'file_name' => $attributes['fileName'] ?? '',
        ];

        $data['file_quarter'] = substr($attributes['quarter'] ?? '', 0, 1);

        $data['valor_consolidado'] = $this->processFileConvertValue($dataRow[12] ?? '');

        $data['data_inscricao'] = Carbon::createFromFormat('d/m/Y', $dataRow[10]);


        return $data;
    }


    protected function processFileSaveData(array $data): void
    {
        DatamineDividaAbertaRaw::insert($data);
    }

    /**
     * processFileReadCountRow
     *
     * @param array attributes
     *
     * @return int
     */
    protected function processFileReadCountRow(array $attributes): int
    {
        $linecount = 0;

        $handle = fopen($attributes['fullName'], "r");

        while (!feof($handle)) {
            $line = fgets($handle);
            $linecount++;
        }

        fclose($handle);

        return $linecount;
    }

    public static function convertCharset($str)
    {
        return iconv("Windows-1252", "UTF-8", $str);
    }

    protected function fileGetRow($fileStream)
    {
        if ($row = fgetcsv($fileStream, 0, ";")) {
            $row = array_map(function ($str) {
                return iconv("Windows-1252", "UTF-8", $str);
            }, $row);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * processFileReadSaveLineNaoPrevidenciario
     *
     * @param array data
     *
     * @return DatamineDividaAbertaRaw
     */
    protected function processFileReadSaveLineFGTS(array $attributes, array $dataRow): DatamineDividaAbertaRaw
    {
        $data = [
            'status' => 0,
            'cpf_cnpj' => $dataRow[0] ?? '',
            'tipo_pessoa' => $dataRow[1] ?? '',
            'tipo_devedor' => $dataRow[2] ?? '',
            'nome_devedor' => $dataRow[3] ?? '',
            'uf_devedor' => $dataRow[4] ?? '',
            'unidade_responsavel' => $dataRow[5] ?? '',
            'entidade_responsavel' => $dataRow[6] ?? '',
            'unidade_inscricao' => $dataRow[7] ?? '',
            'numero_inscricao' => $dataRow[8] ?? '',
            'tipo_situacao_inscricao' => $dataRow[9] ?? '',
            'situacao_inscricao' => $dataRow[10] ?? '',
            'receita_principal' => $dataRow[11] ?? '',
            'indicador_ajuizado' => $dataRow[13] ?? '',
            'file_type' => $attributes['type'] ?? '',
            'file_year' => $attributes['year'] ?? '',
            'file_time' => $attributes['time'] ?? '',
            'file_name' => $attributes['fileName'] ?? '',
        ];

        $data['file_quarter'] = substr($attributes['quarter'] ?? '', 0, 1);

        $data['valor_consolidado'] = $this->processFileConvertValue($dataRow[14] ?? '');

        $data['data_inscricao'] = Carbon::createFromFormat('d/m/Y', $dataRow[12]);

        $model = DatamineDividaAbertaRaw::create($data);

        return $model;
    }

    /**
     * processFileReadSaveLineNotPrev
     *
     * @param array attributes
     * @param array dataRow
     *
     * @return DatamineDividaAbertaRaw
     */
    protected function processFileReadSaveLineNotPrev(array $attributes, array $dataRow): DatamineDividaAbertaRaw
    {
        $data = [
            'status' => 0,
            'cpf_cnpj' => $dataRow[0] ?? '',
            'tipo_pessoa' => $dataRow[1] ?? '',
            'tipo_devedor' => $dataRow[2] ?? '',
            'nome_devedor' => $dataRow[3] ?? '',
            'uf_devedor' => $dataRow[4] ?? '',
            'unidade_responsavel' => $dataRow[5] ?? '',
            'numero_inscricao' => $dataRow[6] ?? '',
            'tipo_situacao_inscricao' => $dataRow[7] ?? '',
            'situacao_inscricao' => $dataRow[8] ?? '',
            'receita_principal' => $dataRow[9] ?? '',
            'indicador_ajuizado' => $dataRow[11] ?? '',
            'file_type' => $attributes['type'] ?? '',
            'file_year' => $attributes['year'] ?? '',
            'file_time' => $attributes['time'] ?? '',
            'file_name' => $attributes['fileName'] ?? '',
        ];

        $data['file_quarter'] = substr($attributes['quarter'] ?? '', 0, 1);

        $data['valor_consolidado'] = $this->processFileConvertValue($dataRow[12] ?? '');

        $data['data_inscricao'] = Carbon::createFromFormat('d/m/Y', $dataRow[10]);

        $model = DatamineDividaAbertaRaw::create($data);

        return $model;
    }

    /**
     * processFileReadSaveLinePrev
     *
     * @param array attributes
     * @param array dataRow
     *
     * @return DatamineDividaAbertaRaw
     */
    protected function processFileReadSaveLinePrev(array $attributes, array $dataRow): DatamineDividaAbertaRaw
    {
        $data = [
            'status' => 0,
            'cpf_cnpj' => $dataRow[0] ?? '',
            'tipo_pessoa' => $dataRow[1] ?? '',
            'tipo_devedor' => $dataRow[2] ?? '',
            'nome_devedor' => $dataRow[3] ?? '',
            'uf_devedor' => $dataRow[4] ?? '',
            'unidade_responsavel' => $dataRow[5] ?? '',
            'numero_inscricao' => $dataRow[6] ?? '',
            'tipo_situacao_inscricao' => $dataRow[7] ?? '',
            'situacao_inscricao' => $dataRow[8] ?? '',
            'tipo_credito' => $dataRow[9] ?? '',
            'indicador_ajuizado' => $dataRow[11] ?? '',
            'file_type' => $attributes['type'] ?? '',
            'file_year' => $attributes['year'] ?? '',
            'file_time' => $attributes['time'] ?? '',
            'file_name' => $attributes['fileName'] ?? '',
        ];

        $data['file_quarter'] = substr($attributes['quarter'] ?? '', 0, 1);

        $data['valor_consolidado'] = $this->processFileConvertValue($dataRow[12] ?? '');

        $data['data_inscricao'] = Carbon::createFromFormat('d/m/Y', $dataRow[10]);

        $model = DatamineDividaAbertaRaw::create($data);

        return $model;
    }

    /**
     * processFileConvertValue
     *
     * @param string value
     *
     * @return int
     */
    protected function processFileConvertValue(string $value): int
    {
        if (!is_numeric($value)) {
            throw new Exception("O valor não pode ser convertido: '$value'");
        }

        $newNumber = floatval($value) * 100;

        return (int) $newNumber;
    }
}
