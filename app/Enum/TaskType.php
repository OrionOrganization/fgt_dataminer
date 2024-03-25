<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self TEXT()
 * @method static self EMAIL()
 * @method static self PHONE()
 * @method static self PROPOSAL()
 * @method static self MEETING()
 * @method static self VISITING()
 *
 */
class TaskType extends Enum
{
    private const TEXT = 0;
    private const EMAIL = 1;
    private const PHONE = 2;
    private const PROPOSAL = 3;
    private const MEETING = 4;
    private const VISITING = 5;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::TEXT => __('Texto'),
            self::EMAIL => __('Email'),
            self::PHONE => __('Telefone'),
            self::PROPOSAL => __('Proposta'),
            self::MEETING => __('Reunião'),
            self::VISITING => __('Visita'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
