<?php

namespace App\Enum\Datamine;

use MyCLabs\Enum\Enum;

/**
 * @method static self NEW()
 * @method static self ANALYZED()
 * @method static self ERROR_ANALYZED()
 */
class DataMineRawStatus extends Enum
{
    private const NEW = 0;
    private const ANALYZED = 1;
    private const ERROR_ANALYZED = 2;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::NEW => __('Novo'),
            self::ANALYZED => __('Analisado'),
            self::ERROR_ANALYZED => __('Erro ao Analisar'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
