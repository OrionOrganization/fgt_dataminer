<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self EFFETIVE()
 * @method static self POTENTIAL()
 * @method static self CONCURRENT()
 * @method static self SUPPLIER()
 * @method static self PARTNER()
 *
 */
class CompanyCategory extends Enum
{
    private const EFFETIVE = 0;
    private const POTENTIAL = 1;
    private const CONCURRENT = 2;
    private const SUPPLIER = 3;
    private const PARTNER = 4;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::EFFETIVE => __('Cliente Efetivo'),
            self::POTENTIAL => __('Cliente em Potencial'),
            self::CONCURRENT => __('Concorrente'),
            self::SUPPLIER => __('Fornecedor'),
            self::PARTNER => __('Parceiro'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
