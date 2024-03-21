<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self COMMERCE()
 * @method static self RETAIL()
 * @method static self IMPORT()
 *
 */
class CompanySetor extends Enum
{
    private const COMMERCE = 0;
    private const RETAIL = 1;
    private const IMPORT = 2;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::COMMERCE => __('Comércio'),
            self::RETAIL => __('Varejo'),
            self::IMPORT => __('Importação'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
