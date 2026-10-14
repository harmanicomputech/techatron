<?php

namespace App\Support;

/**
 * Formats Nigerian phone numbers given in local form (e.g. 09022016978).
 */
class Phone
{
    /** International form for tel: links and structured data: +2349022016978 */
    public static function e164(string $number): string
    {
        $digits = preg_replace('/\D/', '', $number);

        return match (true) {
            str_starts_with($number, '+') => '+'.$digits,
            str_starts_with($digits, '234') => '+'.$digits,
            str_starts_with($digits, '0') => '+234'.substr($digits, 1),
            default => '+'.$digits,
        };
    }

    /** Readable local form: 0902 201 6978 */
    public static function display(string $number): string
    {
        $digits = preg_replace('/\D/', '', $number);

        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            return substr($digits, 0, 4).' '.substr($digits, 4, 3).' '.substr($digits, 7);
        }

        return $number;
    }
}
