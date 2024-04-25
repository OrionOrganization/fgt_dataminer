<?php

namespace App\Enum\Datamine;

use MyCLabs\Enum\Enum;

/**
 * @method static self TAX_BENEFIT_TYPE()
 * @method static self IN_COLLECTION_TYPE()
 * @method static self IN_NEGOCIATION_TYPE()
 * @method static self GUARANTEE_TYPE()
 * @method static self SUSPENDED_TYPE()
 * @method static self OTHERS_TYPE()
 */
class SubscriptionSituationType extends Enum
{
    protected const TAX_BENEFIT_TYPE = 'TB';
    protected const IN_COLLECTION_TYPE = 'IC';
    protected const IN_NEGOCIATION_TYPE = 'IN';
    protected const GUARANTEE_TYPE = 'GT';
    protected const SUSPENDED_TYPE = 'ST';
    protected const OTHERS_TYPE = 'OT';

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::TAX_BENEFIT_TYPE => 'Benefício Fiscal',
            self::IN_COLLECTION_TYPE => 'Em cobrança',
            self::IN_NEGOCIATION_TYPE => 'Em negociação',
            self::GUARANTEE_TYPE => 'Garantia',
            self::SUSPENDED_TYPE => 'Suspenso por decisão judicial',
            self::OTHERS_TYPE => 'Outros',
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
