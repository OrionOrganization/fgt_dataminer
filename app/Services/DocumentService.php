<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * Service to create and check verification digits of document numbers.
 * Currently supports Brazilian documents CPF and CNPJ.
 * Since 2021-03-19 also supports Brazilian Voter's ID.
 *
 * Based on (pt-BR):
 * http://ghiorzi.org/DVnew.htm
 * https://souforce.cloud/regra-de-validacao-para-cpf-e-cnpj/amp/
 */
class DocumentService
{
    public const REGEX_CPF = '/^(\d{3}).(\d{3}).(\d{3})-(\d{2})$/';

    public const REGEX_RG = '/^(\d{2}).(\d{3}).(\d{3})-(\d{1})$/';

    public const REGEX_CNPJ = '/^(\d{2}).(\d{3}).(\d{3})\/(\d{4})-(\d{2})$/';

    public const REGEX_CEP = '/^(\d{2})[.]?(\d{3})[-]?(\d{3})$/';

    public const REGEX_NCM = '/^(\d{4})[.]?(\d{2})[.]?(\d{2})$/';

    public const REGEX_TELEFONE_CELULAR = '/\(?(\d{2})\)?\s?(\d?)\s?(\d{4})\-?(\d{4})$/';


    /**
     * getOnlyNumber
     *
     * @param string value
     *
     * @return string
     */
    public static function getOnlyNumber(string $value): string
    {
        return preg_replace('/\D/', '', $value);
    }

    /**
     * getOnlyNumberOrZero
     *
     * @param string|null value
     *
     * @return int
     */
    public static function getOnlyNumberOrZero(string $value = null): int
    {
        if (is_null($value)) return 0;

        $info = self::getOnlyNumber($value);

        return ($info) ? $info : 0;
    }

    /**
     * Return valid telefone
     * @param string $telefone
     *
     * @return null|string
     */
    public static function getValidTelefone(string $telefone): ?string
    {
        if (preg_match(self::REGEX_TELEFONE_CELULAR, $telefone, $output))
            return $output[1] . $output[2] . $output[3] . $output[4];
        return null;
    }

    /**
     * getValidPhoneOrCellphoneOfString
     *
     * @param string phone
     * @param string ddd
     *
     * @return array
     */
    public static function getValidPhoneOrCellphoneOfString(
        string $phone,
        string $ddd = '19'
    ): ?array {

        $info = self::getOnlyNumber($phone);

        $phoneNew = '';
        $cellphone = '';

        $len = strlen($info);

        if ($len == 0) return null;

        switch ($len) {
            case 8:
                $phoneNew = $ddd . $info;
                break;
            case 9:
                $cellphone = $ddd . $info;
                break;
            case 10:
                $phoneNew = $info;
                break;
            case 11:
                if ($info[0] == '0') {
                    $phoneNew = substr($info, 1);
                } else {
                    $cellphone = $info;
                }
                break;
            case 12:
                if ($info[0] == '0') {
                    $cellphone = substr($info, 1);
                } else {
                    return null;
                }
                break;
            default:
                return null;
        }

        return [
            'phone' => $phoneNew,
            'cellphone' => $cellphone,
        ];
    }

    /**
     * Return valid NCM
     * @param string $NCM
     *
     * @return null|string
     */
    public static function getValidNCM(string $ncm): ?string
    {
        if (preg_match(self::REGEX_NCM, $ncm, $output))
            return $output[1] . $output[2] . $output[3];

        return null;
    }

    /**
     * Return valid CEP
     * @param string $cep
     *
     * @return null|string
     */
    public static function getValidCEP(string $cep): ?string
    {
        if (preg_match(self::REGEX_CEP, $cep, $output))
            return $output[1] . $output[2] . $output[3];

        return null;
    }

    /**
     * Return valid CPF
     * @param string $cpf
     *
     * @return null|string
     */
    public static function getValidCpf(string $cpf): ?string
    {
        if (preg_match(self::REGEX_CPF, $cpf, $output))
            return $output[1] . $output[2] . $output[3] . $output[4];
        return null;
    }

    /**
     * Return valid Cnpj
     * @param string $Cnpj
     *
     * @return null|string
     */
    public static function getValidCnpj(string $cnpj): ?string
    {
        if (preg_match(self::REGEX_CNPJ, $cnpj, $output))
            return $output[1] . $output[2] . $output[3] . $output[4] . $output[5];
        return null;
    }

    /**
     * Return valid RG
     * @param string $rg
     *
     * @return null|string
     */
    public static function getValidRG(string $rg): ?string
    {
        if (preg_match(self::REGEX_RG, $rg, $output))
            return $output[1] . $output[2] . $output[3] . $output[4];
        return null;
    }

    /**
     * Check telefone
     *
     * @param string $value
     * @return bool
     */
    public static function validateTelefone(string $value): bool
    {
        if (!$value) return true;

        return (self::getValidTelefone($value)) ? true : false;
    }

    /**
     * Check if the first 9 digits of the value are a valid RG.
     *
     * @param string $value
     * @return bool
     */
    public static function validateRg(string $value): bool
    {
        $digits = self::collectDigits($value);

        return count($digits) == 9;

        $v = self::calculateCpf($digits);
        return $digits->only([9, 10])->join('') === implode('', $v);
    }

    /**
     * Check if the first 11 digits of the value are a valid CPF.
     *
     * @param string $value
     * @return bool
     */
    public static function validateCpf(string $value): bool
    {
        $digits = self::collectDigits($value);
        $v = self::calculateCpf($digits);
        return $digits->only([9, 10])->join('') === implode('', $v);
    }

    /**
     * Check if the first 14 digits of the value are a valid CPNJ.
     *
     * @param string $value
     * @return bool
     */
    public static function validateCnpj(string $value): bool
    {
        $digits = self::collectDigits($value);
        $v = self::calculateCnpj($digits);
        return $digits->only([12, 13])->join('') === implode('', $v);
    }

    /**
     * Check if the first 10 digits of the value are a valid Voter's ID.
     *
     * @param string $value
     * @return bool
     */
    public static function validateVoter(string $value): bool
    {
        $digits = self::collectDigits($value);
        $v = self::calculateVoter($digits);
        $pos = ($digits->count() % 2) ? [11, 12] : [10, 11];
        return $digits->only($pos)->join('') === implode('', $v);
    }

    /**
     * Generate a valid random CPF.
     *
     * @param bool $format
     * @return string
     */
    public static function randomCpf(bool $format = false): string
    {
        $d = self::collectDigits(self::randomValue(9));
        $txt = $d->concat(self::calculateCpf($d))->join('');
        return $format ? self::formatCpf($txt) : $txt;
    }

    /**
     * Generate a valid random CNPJ.
     *
     * @param bool $format
     * @return string
     */
    public static function randomCnpj(bool $format = false): string
    {
        $d = self::collectDigits(self::randomValue(12));
        $txt = $d->concat(self::calculateCnpj($d))->join('');
        return $format ? self::formatCnpj($txt) : $txt;
    }

    /**
     * Generate a valid random Voter's ID with 12 digits.
     *
     * @param bool $format
     * @return string
     */
    public static function randomVoter(bool $format = false): string
    {
        $d = self::collectDigits(self::randomValue(8));
        $d = $d->concat(str_split(sprintf('%02d', rand(1, 28))));
        $txt = $d->concat(self::calculateVoter($d))->join('');
        return $format ? implode(' ', str_split($txt, 4)) : $txt;
    }

    /**
     * Format an 11-digit string representing a CPF.
     *
     * @param string $value Example: `12345678901`
     * @return string Example: `123.456.789-01`
     */
    public static function formatCpf(string $value): string
    {
        return self::joinGroups(
            '/^(\d{3})(\d{3})(\d{3})(\d{2})/',
            preg_replace('/\D/', '', $value),
            ['.', '.', '-']
        );
    }

    /**
     * Format an 14-digit string representing a CNPJ.
     *
     * @param string $value Example: `12345678901234`
     * @return string Example: `12.345.678/9012-34`
     */
    public static function formatCnpj(string $value): string
    {
        return self::joinGroups(
            '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',
            preg_replace('/\D/', '', $value),
            ['.', '.', '/', '-']
        );
    }

    /**
     * Format an 8-digit string representing a CEP.
     *
     * @param string $value Example: `12345678`
     * @return string Example: `12.345-678`
     */
    public static function formatCep(string $value): string
    {
        return self::joinGroups(
            self::REGEX_CEP,
            preg_replace('/\D/', '', $value),
            ['.', '-']
        );
    }

    /**
     * Return a collection of the digits in a string.
     *
     * @param string $value
     * @return \Illuminate\Support\Collection
     */
    protected static function collectDigits(string $value): Collection
    {
        return collect(str_split(preg_replace('/\D/', '', $value)));
    }

    /**
     * Return a random number of a specified length with leading zeroes.
     *
     * @param int $length
     * @return string
     */
    protected static function randomValue(int $length): string
    {
        $rand = rand(1, pow(10, $length) - 2);
        return str_pad($rand, $length, '0', STR_PAD_LEFT);
    }

    /**
     * Perform a regular expression match and return the captured groups joined.
     * If provided, the captured groups are "glued" with the separators.
     *
     * @param string $pattern
     * @param string $subject
     * @param array $separators
     * @return string
     */
    protected static function joinGroups(
        string $pattern,
        string $subject,
        array $separators = []
    ): string {
        $matches = [];
        preg_match($pattern, $subject, $matches);
        return collect(array_slice($matches, 1))->reduce(
            function ($joined, $match, $key) use ($separators) {
                $glue = $separators[$key] ?? null;
                return $joined . $match . ($glue ?? '');
            },
            ''
        );
    }

    /**
     * Calculate the sum of the multiplications of values by weights,
     * and return the rest of the division by 11.
     *
     * @param array $values All values should be numeric
     * @param bool $restoreWeight Never have weight less than 2
     * @param int $baseWeight Value the weight starts at (and is restored to)
     * @param int $limit Number of elements to process (only applies when > 0)
     * @return int Sum of multiplications modulo 11
     */
    protected static function mod11(
        array $values,
        bool $restoreWeight = true,
        int $baseWeight = 9,
        int $limit = 0
    ): int {
        $sum = 0;
        $w = $baseWeight;

        // Stop when the weight is 0 or the index reaches the limit
        foreach (array_values($values) as $i => $v) {
            if (!$w || ($limit > 0 && $i >= $limit)) break;
            $sum += $w-- * $v;
            if ($w < 2 && $restoreWeight) $w = $baseWeight;
        }

        return $sum % 11;
    }

    /**
     * Calculate the two verification digits of a CPF.
     *
     * @param \Illuminate\Support\Collection $digits
     * @return array
     */
    protected static function calculateCpf(Collection $digits): array
    {
        $digits = $digits->slice(0, 9);

        // Add first verification digit
        $rest = self::mod11($digits->reverse()->toArray(), false);
        $digits->push($rest % 10);

        // Add first verification digit
        $rest = self::mod11($digits->reverse()->toArray(), false);
        $digits->push($rest % 10);

        // Return the two verification digits
        return $digits->slice(-2)->values()->toArray();
    }

    /**
     * Calculate the two verification digits of a CNPJ.
     *
     * @param \Illuminate\Support\Collection $digits
     * @return array
     */
    protected static function calculateCnpj(Collection $digits): array
    {
        $digits = $digits->slice(0, 12);

        // Add first verification digit
        $rest = self::mod11($digits->reverse()->toArray());
        $digits->push($rest % 10);

        // Add second verification digit
        $rest = self::mod11($digits->reverse()->toArray());
        $digits->push($rest % 10);

        // Return the two verification digits
        return $digits->slice(-2)->values()->toArray();
    }

    /**
     * Calculate the two verification digits of a Voter's ID.
     *
     * @param \Illuminate\Support\Collection $digits
     * @return array
     */
    protected static function calculateVoter(Collection $digits): array
    {
        // Some voter IDs have an odd number of characters
        $digits = $digits->slice(0, ($digits->count() % 2) ? 11 : 10);

        // The number includes a state code in the last 2 digits (0 < code < 29)
        $stateCode = $digits->slice(-2)->join('');
        if ($stateCode < 1 || $stateCode > 28) return [-1, -1];

        // Special rule for states code 01 (São Paulo) and 02 (Minas Gerais)
        // https://pt.wikipedia.org/wiki/T%C3%ADtulo_eleitoral#cite_note-10
        $specialRule = in_array($stateCode, ['01', '02']);

        // Add first verification digit
        $rest = self::mod11($digits->slice(0, -2)->reverse()->toArray());
        if ($rest == 0 && $specialRule) $rest = 1;
        $digits->push($rest % 10);

        // Add second verification digit
        $rest = self::mod11($digits->slice(-3)->reverse()->toArray());
        if ($rest == 0 && $specialRule) $rest = 1;
        $digits->push($rest % 10);

        // Return the two verification digits
        return $digits->slice(-2)->values()->toArray();
    }
}
