<?php

namespace App\Traits\Crud;

use Illuminate\Support\Facades\Storage;

trait HandlesCrudFields
{
    /**
     * Callable used to generate the 'href' of the 'upload_multiple' column.
     * Returns a temporary URL (5 minutes) when the $disk is 's3'.
     * Based on the code for the 'upload_multiple' field.
     *
     * @param string $filePath
     * @param string $disk
     * @param string $prefix
     * @return string
     */
    public static function fileUrl(
        string $filePath,
        string $disk,
        string $prefix
    ): string {
        if (is_null($disk)) {
            $url = $prefix . $filePath;
        } else if ($disk == 's3') {
            $url = Storage::disk($disk)->temporaryUrl(
                $filePath,
                now()->addMinutes(5)
            );
        } else {
            $url = Storage::disk($disk)->url($filePath);
        }
        return asset($url);
    }

    /**
     * Helper to format integer cents into money strings.
     *
     * @param int|null $value
     * @param string $currency
     * @return string
     */
    public static function money(?int $value, string $currency = 'BRL'): string
    {
        if (!$value) $value = 0;
        switch ($currency) {
            case 'BRL':
                return 'R$ ' . number_format($value / 100, 2, ',', '.');
            case 'USD':
                return '$ ' . number_format($value / 100, 2, '.', ',');
            default:
                return $value;
        }
    }

    /**
     * Convert String Money To Float
     *
     * 1.223,00 to 1223.00
     * @param string $value
     *
     * @return float
     */
    protected function convertStringMoneyToFloat(string $value): float
    {
        $value = str_replace('.', '', $value);

        return number_format(floatval($value), 2, '.', '');
    }

    /**
     * Convert String Money To INT(11)
     *
     * RS 1.223,00 to 122300
     * U$ 1,223.00 to 122300
     * @param string $value
     *
     * @return float
     */
    protected function convertStringMoneyToInt(string $value): ?int
    {
        #padrão americano
        if (preg_match('/([\,?\d+]+)\.{1}(\d+)$/', $value, $matches) && substr_count($value, '.') == 1) {
            $num = floatval(str_replace(',', '', $matches[1]));

            $cents = floatval($matches[2] ?? 0) / 100;

            return intval(($num + round($cents, 2)) * 100);
        }

        #padrão br
        if (preg_match('/([\.?\d+]+)\,{1}(\d+)$/', $value, $matches) && substr_count($value, ',') == 1) {
            $num = floatval(str_replace('.', '', $matches[1]));

            $cents = floatval($matches[2] ?? 0) / 100;

            return intval(($num + round($cents, 2)) * 100);
        }

        return null;
    }
}
