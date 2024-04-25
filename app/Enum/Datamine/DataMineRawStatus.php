<?php

namespace App\Enum\Datamine;

use MyCLabs\Enum\Enum;

/**
 * @method static self NEW()
 * @method static self ANALYZED()
 */
class DataMineRawStatus extends Enum
{
    private const NEW = 0;
    private const ANALYZED = 1;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::NEW => __('Novo'),
            self::ANALYZED => __('Analisado'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
