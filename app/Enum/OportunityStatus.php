<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self PROSPECTION()
 * @method static self CONTACT_MADE()
 * @method static self PROPOSAL_SENT()
 * @method static self NEGOTIATION()
 * @method static self WON()
 * @method static self LOST()
 */
class OportunityStatus extends Enum
{
    private const PROSPECTION = 0;
    private const CONTACT_MADE = 1;
    private const PROPOSAL_SENT = 2;
    private const NEGOTIATION = 3;
    private const WON = 4;
    private const LOST = 5;

    /**
     * Display values for the enum.
     */
    public static function labels(): array
    {
        return [
            self::PROSPECTION => __('Prospecção'),
            self::CONTACT_MADE => __('Em Contato'),
            self::PROPOSAL_SENT => __('Proposta Enviada'),
            self::NEGOTIATION => __('Em Negociação'),
            self::WON => __('Negócio Fechado'),
            self::LOST => __('Perdida'),
        ];
    }

    public function getLabel(): string
    {
        return self::labels()[$this->value];
    }
}
