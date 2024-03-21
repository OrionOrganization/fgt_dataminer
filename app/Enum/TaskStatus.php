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
            self::NON_STARTED => __('Não Iniciado'),
            self::STARTED => __('Iniciado'),
            self::PAUSED => __('Pausado'),
            self::FINISHED => __('Finalizado'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
