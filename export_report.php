<?php
include __DIR__.'/includes/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="report.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['Month', 'Sales', 'Expenses', 'Net Profit']);

$result = $conn->query("
  SELECT DATE_FORMAT(sale_date, '%Y-%m') as month,
         COALESCE(SUM(amount),0) as sales,
         (SELECT COALESCE(SUM(amount),0) FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = DATE_FORMAT(s.sale_date, '%Y-%m')) as expenses
  FROM sales s
  GROUP BY DATE_FORMAT(sale_date, '%Y-%m')
");

while ($row = $result->fetch_assoc()) {
    $profit = $row['sales'] - $row['expenses'];
    fputcsv($output, [$row['month'], $row['sales'], $row['expenses'], $profit]);
}

fclose($output);
exit;
