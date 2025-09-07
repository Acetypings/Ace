<?php include __DIR__.'/includes/header.php'; ?>
<?php 
include __DIR__.'/includes/db.php';
include_once __DIR__.'/includes/currency.php';

// Totals
$totalSales    = (float)(($conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM sales")->fetch_assoc())['t'] ?? 0);
$totalExpenses = (float)(($conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM expenses")->fetch_assoc())['t'] ?? 0);
$netProfit     = $totalSales - $totalExpenses;

// Sales vs Expenses by Month
$salesData = $conn->query("SELECT DATE_FORMAT(sale_date, '%b') as month, SUM(amount) as total FROM sales GROUP BY MONTH(sale_date)");
$expensesData = $conn->query("SELECT DATE_FORMAT(expense_date, '%b') as month, SUM(amount) as total FROM expenses GROUP BY MONTH(expense_date)");

$months = [];
$salesTotals = [];
$expenseTotals = [];

while ($row = $salesData->fetch_assoc()) {
    $months[] = $row['month'];
    $salesTotals[] = (float)$row['total'];
}

while ($row = $expensesData->fetch_assoc()) {
    $expenseTotals[] = (float)$row['total'];
}

// Expense Breakdown by Category
$categoriesRes = $conn->query("SELECT category, SUM(amount) as total FROM expenses GROUP BY category");
$categories = [];
$categoryTotals = [];

while ($row = $categoriesRes->fetch_assoc()) {
    $categories[] = $row['category'];
    $categoryTotals[] = (float)$row['total'];
}
?>

<main class="max-w-6xl mx-auto p-4 md:p-6">
  <!-- Quick Stats -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 shadow-sm">
      <div class="text-gray-500 text-sm">Total Sales</div>
      <div class="text-3xl font-bold text-blue-600"><?= formatCurrency($totalSales) ?></div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm">
      <div class="text-gray-500 text-sm">Total Expenses</div>
      <div class="text-3xl font-bold text-red-500"><?= formatCurrency($totalExpenses) ?></div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm">
      <div class="text-gray-500 text-sm">Net Profit</div>
      <div class="text-3xl font-bold text-green-600"><?= formatCurrency($netProfit) ?></div>
    </div>
  </div>

  <!-- Charts -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl p-5 shadow-sm">
      <h2 class="mb-3 font-medium">Sales vs Expenses</h2>
      <canvas id="lineChart" height="200"></canvas>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm">
      <h2 class="mb-3 font-medium">Expense Breakdown</h2>
      <canvas id="pieChart" height="200"></canvas>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="flex gap-3 mt-6">
    <a href="sales.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">+ Add Sale</a>
    <a href="expenses.php" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg">+ Add Expense</a>
  </div>
</main>

<script>
  const lineLabels = <?= json_encode($months) ?>;
  const salesSeries = <?= json_encode($salesTotals) ?>;
  const expensesSeries = <?= json_encode($expenseTotals) ?>;
  const categories = <?= json_encode($categories) ?>;
  const categoryTotals = <?= json_encode($categoryTotals) ?>;

  new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
      labels: lineLabels,
      datasets: [
        { label: 'Sales', data: salesSeries, borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,0.1)', tension: 0.35 },
        { label: 'Expenses', data: expensesSeries, borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.1)', tension: 0.35 }
      ]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });

  new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
      labels: categories,
      datasets: [{
        data: categoryTotals,
        backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#6366f1','#8b5cf6']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
</script>

<?php include __DIR__.'/includes/footer.php'; ?>
