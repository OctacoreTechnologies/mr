<?php

use Carbon\Carbon;

if(!function_exists('formatDate')){

    function formatDate($date){
     return Carbon::parse($date)->format('d-m-Y');
    }
}
if(!function_exists('convertToIndianWords')){
    function convertToIndianWords($number){
    $words = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
        'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen',
        'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen', 'Twenty',
        30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    ];

    $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

    if ($number == 0) return 'Zero';

    $number = (int) $number;

    $result = '';

    $parts = [
        'Crore' => floor($number / 10000000),
        'Lakh' => floor(($number % 10000000) / 100000),
        'Thousand' => floor(($number % 100000) / 1000),
        'Hundred' => floor(($number % 1000) / 100),
        'Rest' => $number % 100
    ];

    foreach ($parts as $label => $val) {
        if ($val == 0) continue;

        if ($val < 21) {
            $result .= $words[$val] . ' ';
        } else if ($val < 100) {
            $result .= $words[10 * floor($val / 10)] . ' ' . ($val % 10 != 0 ? $words[$val % 10] : '') . ' ';
        }

        if ($label != 'Rest') $result .= $label . ' ';
    }

    return trim($result);
 }

}

if(!function_exists('format_indian_number')){
    
function format_indian_number($number) {
    $decimal = '';
    if (strpos($number, '.') !== false) {
        list($number, $decimal) = explode('.', number_format($number, 2, '.', ''));
    }

    $lastThree = substr($number, -3);
    $restUnits = substr($number, 0, -3);

    if ($restUnits != '') {
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
        $formatted = $restUnits . ',' . $lastThree;
    } else {
        $formatted = $lastThree;
    }

    return $decimal ? $formatted . '.' . $decimal : $formatted;
}
}
 if(!function_exists('statusCount')){
   function statusCount($items, $status) {
    return $items->where('status', $status)->count();
  }
 }

 if(!function_exists('getFinancialYear')){
     function getFinancialYear(): string{
    $year = now()->year;
    $month = now()->month;

    if ($month >= 4) {
        // Financial year starts in April
        $startYear = $year;
        $endYear = $year + 1;
    } else {
        $startYear = $year - 1;
        $endYear = $year;
    }

    return substr($startYear, -2) . '-' . substr($endYear, -2);
}

 }

?>