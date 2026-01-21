<?php

namespace App\Helpers;

class NumberHelper
{
    /**
     * Convert number to Indonesian words (terbilang)
     * 
     * @param int|float $angka
     * @return string
     */
    public static function terbilang($angka)
    {
        // Convert string to number by removing any non-numeric characters except decimal point
        if (is_string($angka)) {
            $angka = (int) preg_replace('/[^0-9]/', '', $angka);
        }
        
        $angka = abs($angka);
        $huruf = [
            '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan',
            'Sepuluh', 'Sebelas'
        ];

        $temp = '';

        if ($angka < 12) {
            $temp = $huruf[$angka];
        } elseif ($angka < 20) {
            $temp = self::terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $temp = self::terbilang($angka / 10) . ' Puluh ' . self::terbilang($angka % 10);
        } elseif ($angka < 200) {
            $temp = 'Seratus ' . self::terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $temp = self::terbilang($angka / 100) . ' Ratus ' . self::terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $temp = 'Seribu ' . self::terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $temp = self::terbilang($angka / 1000) . ' Ribu ' . self::terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $temp = self::terbilang($angka / 1000000) . ' Juta ' . self::terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $temp = self::terbilang($angka / 1000000000) . ' Miliar ' . self::terbilang(fmod($angka, 1000000000));
        } elseif ($angka < 1000000000000000) {
            $temp = self::terbilang($angka / 1000000000000) . ' Triliun ' . self::terbilang(fmod($angka, 1000000000000));
        }

        // Clean up multiple spaces
        return preg_replace('/\s+/', ' ', trim($temp));
    }

    /**
     * Format number to Indonesian Rupiah format (with dots as thousand separator)
     * 
     * @param int|float $angka
     * @param bool $withPrefix
     * @return string
     */
    public static function formatRupiah($angka, $withPrefix = true)
    {
        $formatted = number_format($angka, 0, ',', '.');
        return $withPrefix ? 'Rp ' . $formatted : $formatted;
    }
}
