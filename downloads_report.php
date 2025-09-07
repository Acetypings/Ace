<?php
include __DIR__.'/includes/db.php';
include __DIR__.'/includes/currency.php'; // formatCurrency()

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=SME_Business_Overview.csv');

// Force UTF-8 BOM for Excel
echo "\xEF\xBB\xBF"; // This fixes the weird â‚± symbols

$output = fopen('php://output', 'w');

// --- Totals ---
$totalSales    = (float)(($conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM sales")->fetch_assoc())['t'] ?? 0);
$totalExpenses = (float)(($conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM expenses")->fetch_assoc())['t'] ?? 0);
$netProfit     = $totalSales - $totalExpenses;

// Write Overview
fputcsv($output, ["SME Business Overview Report"]);
fputcsv($output, []);
fputcsv($output, ["Total Sales", "Total Expenses", "Net Profit"]);
fputcsv($output, [formatCurrency($totalSales), formatCurrency($totalExpenses), formatCurrency($netProfit)]);
fputcsv($output, []);

// --- Monthly Performance ---
$salesData = $conn->query("SELECT MONTHNAME(sale_date) as month, SUM(amount) as total FROM sales GROUP BY MONTH(sale_date) ORDER BY MONTH(sale_date)");
$expensesData = $conn->query("SELECT MONTHNAME(expense_date) as month, SUM(amount) as total FROM expenses GROUP BY MONTH(expense_date) ORDER BY MONTH(expense_date)");

$monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
$allMonths = [];
foreach($monthNames as $month){
    $allMonths[$month] = ['sales'=>0, 'expenses'=>0, 'profit'=>0];
}

while($row = $salesData->fetch_assoc()){
    $allMonths[$row['month']]['sales'] = (float)$row['total'];
}
while($row = $expensesData->fetch_assoc()){
    $allMonths[$row['month']]['expenses'] = (float)$row['total'];
}
foreach($allMonths as $month => $data){
    $allMonths[$month]['profit'] = $data['sales'] - $data['expenses'];
}

// Write Monthly Performance
fputcsv($output, ["Monthly Performance"]);
fputcsv($output, ["Month","Sales","Expenses","Net Profit"]);
foreach($allMonths as $month => $data){
    if($data['sales']>0 || $data['expenses']>0){
        fputcsv($output, [$month, formatCurrency($data['sales']), formatCurrency($data['expenses']), formatCurrency($data['profit'])]);
    }
}
fputcsv($output, []);

// --- Expense Categories ---
$categoriesRes = $conn->query("SELECT category, SUM(amount) as total FROM expenses GROUP BY category");
$categories = [];
while($row = $categoriesRes->fetch_assoc()){
    $categories[$row['category']] = (float)$row['total'];
}

fputcsv($output, ["Expense Categories"]);
fputcsv($output, ["Category","Total"]);
foreach($categories as $cat => $total){
    fputcsv($output, [$cat, formatCurrency($total)]);
}
fputcsv($output, []);

// --- Key Insights ---
$highestProfit = 0;
$highestMonth = '';
foreach($allMonths as $month => $data){
    if($data['profit'] > $highestProfit){
        $highestProfit = $data['profit'];
        $highestMonth = $month;
    }
}

fputcsv($output, ["Key Insights"]);
fputcsv($output, ["Highest Net Profit Month", $highestMonth, formatCurrency($highestProfit)]);

fclose($output);
exit;
?>
