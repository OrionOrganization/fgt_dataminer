<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self NON_STARTED()
 * @method static self STARTED()
 * @method static self PAUSED()
 * @method static self FINISHED()
 *
 */
class TaskStatus extends Enum
{
    private const NON_STARTED = 0;
    private const STARTED = 1;
    private const PAUSED = 2;
    private const FINISHED = 3;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::NON_STARTED => __('Não Iniciada'),
            self::STARTED => __('Iniciada'),
            self::PAUSED => __('Pausada'),
            self::FINISHED => __('Finalizada'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
