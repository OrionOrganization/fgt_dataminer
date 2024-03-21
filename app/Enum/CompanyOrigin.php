<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self EVENT()
 * @method static self RECOMMENDATION()
 * @method static self SITE()
 *
 */
class CompanyOrigin extends Enum
{
    private const EVENT = 0;
    private const RECOMMENDATION = 1;
    private const SITE = 2;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::EVENT => __('Evento'),
            self::RECOMMENDATION => __('Indicação'),
            self::SITE => __('Site'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
