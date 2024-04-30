<?php

namespace App\Traits\Models;

trait TranslatedNameTrait
{
    protected $translationKeyPrefix = 'permission.';

    public function getTranslatedNameAttribute(): string
    {
        $key = $this->translationKeyPrefix . $this->name;
        $translated = __($key);
        return ($translated === $key) ? $this->name : $translated;
    }
}
