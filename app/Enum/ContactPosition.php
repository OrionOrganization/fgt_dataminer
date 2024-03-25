<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self CEO()
 * @method static self MANAGER()
 * @method static self CFO()
 * @method static self OTHER()
 */
class ContactPosition extends Enum
{
    private const CEO = 0;
    private const MANAGER = 1;
    private const CFO = 2;
    private const OTHER = 3;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::CEO => __('Diretor'),
            self::MANAGER => __('Gerente'),
            self::CFO => __('Diretor Financeiro'),
            self::OTHER => __('Outro'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
