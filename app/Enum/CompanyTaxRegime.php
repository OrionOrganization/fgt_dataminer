<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self NATIONAL_SIMPLE()
 * @method static self PRESUMED_PROFIT()
 * @method static self REAL_PROFIT()
 * @method static self NONE()
 */
class CompanyTaxRegime extends Enum
{
    private const NATIONAL_SIMPLE = 0;
    private const PRESUMED_PROFIT = 1;
    private const REAL_PROFIT = 2;
    private const NONE = 3;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::NATIONAL_SIMPLE => __('Simples Nacional'),
            self::PRESUMED_PROFIT => __('Lucro Presumido'),
            self::REAL_PROFIT => __('Lucro Real'),
            self::NONE => __('Não informado'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
