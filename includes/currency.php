<?php
$currencyFile = __DIR__ . '/currency.txt';
$currency = file_exists($currencyFile) ? trim(file_get_contents($currencyFile)) : "₱";

// Prevent redeclaration
if (!function_exists('formatCurrency')) {
    function formatCurrency($amount){
        global $currency;
        return $currency . number_format($amount, 2);
    }
}
?>
