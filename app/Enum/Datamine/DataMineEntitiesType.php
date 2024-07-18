<?php

namespace App\Enum\Datamine;

use MyCLabs\Enum\Enum;

/**
 * @method static self PJ()
 * @method static self PF()
 */
class DataMineEntitiesType extends Enum
{
    private const PJ = 0;
    private const PF = 1;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::PJ => __('PJ'),
            self::PF => __('PF'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
