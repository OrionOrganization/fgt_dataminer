<?php

namespace App\Enum\Datamine;

use MyCLabs\Enum\Enum;

/**
 * @method static self NEW()
 * @method static self ANALYZED()
 * @method static self ERROR_ANALYZED()
 * @method static self ERROR_GET_PUBLIC_INFORMATION()
 */
class DataMineRawStatus extends Enum
{
    private const NEW = 0;
    private const ANALYZED = 1;
    private const ERROR_ANALYZED = 2;
    private const ERROR_GET_PUBLIC_INFORMATION = 3;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::NEW => __('Novo'),
            self::ANALYZED => __('Analisado'),
            self::ERROR_ANALYZED => __('Erro ao Analisar'),
            self::ERROR_GET_PUBLIC_INFORMATION => __('Erro ao obter informações publicas'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
