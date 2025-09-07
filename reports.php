<?php 
include __DIR__.'/includes/header.php'; 
include __DIR__.'/includes/db.php';
include __DIR__.'/includes/currency.php'; // formatCurrency()

// --- Totals ---
$totalSales    = (float)(($conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM sales")->fetch_assoc())['t'] ?? 0);
$totalExpenses = (float)(($conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM expenses")->fetch_assoc())['t'] ?? 0);
$netProfit     = $totalSales - $totalExpenses;

// --- Monthly Sales & Expenses ---
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

// Calculate profit
foreach($allMonths as $month => $data){
    $allMonths[$month]['profit'] = $data['sales'] - $data['expenses'];
}

// --- Expense Breakdown ---
$categoriesRes = $conn->query("SELECT category, SUM(amount) as total FROM expenses GROUP BY category");
$categories = [];
while($row = $categoriesRes->fetch_assoc()){
    $categories[$row['category']] = (float)$row['total'];
}

// --- Highest Profit Month ---
$highestProfit = 0;
$highestMonth = '';
foreach($allMonths as $month => $data){
    if($data['profit'] > $highestProfit){
        $highestProfit = $data['profit'];
        $highestMonth = $month;
    }
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

    <!-- Monthly Performance Table -->
    <div class="bg-white rounded-xl shadow-sm p-5 mb-6 overflow-x-auto">
        <h2 class="text-lg font-medium mb-3">Monthly Performance</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-3 border-b">Month</th>
                    <th class="py-2 px-3 border-b">Sales</th>
                    <th class="py-2 px-3 border-b">Expenses</th>
                    <th class="py-2 px-3 border-b">Net Profit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allMonths as $month => $data): ?>
                    <?php if($data['sales']>0 || $data['expenses']>0): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-3 border-b"><?= $month ?></td>
                            <td class="py-2 px-3 border-b"><?= formatCurrency($data['sales']) ?></td>
                            <td class="py-2 px-3 border-b"><?= formatCurrency($data['expenses']) ?></td>
                            <td class="py-2 px-3 border-b"><?= formatCurrency($data['profit']) ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Expense Categories Table -->
    <div class="bg-white rounded-xl shadow-sm p-5 mb-6 overflow-x-auto">
        <h2 class="text-lg font-medium mb-3">Expense Categories</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-3 border-b">Category</th>
                    <th class="py-2 px-3 border-b">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $cat => $total): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-3 border-b"><?= $cat ?></td>
                        <td class="py-2 px-3 border-b"><?= formatCurrency($total) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <h2 class="mb-3 font-medium">Sales vs Expenses</h2>
            <canvas id="lineChart" height="200"></canvas>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <h2 class="mb-3 font-medium">Expense Breakdown</h2>
            <canvas id="pieChart" height="200"></canvas>
        </div>
    </div>

    <!-- Key Insights -->
    <div class="bg-white rounded-xl p-5 shadow-sm mb-6">
        <h2 class="text-lg font-medium mb-3">Key Insights</h2>
        <p>Highest Net Profit Month: <span class="font-semibold"><?= $highestMonth ?> (<?= formatCurrency($highestProfit) ?>)</span></p>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3">
        <a href="sales.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">+ Add Sale</a>
        <a href="expenses.php" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg">+ Add Expense</a>
        <a href="downloads_report.php" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-3 rounded-lg">Download CSV</a>
    </div>
</main>

<script>
    const months = <?= json_encode(array_keys($allMonths)) ?>;
    const sales = <?= json_encode(array_map(fn($d)=> $d['sales'],$allMonths)) ?>;
    const expenses = <?= json_encode(array_map(fn($d)=> $d['expenses'],$allMonths)) ?>;
    const categories = <?= json_encode(array_keys($categories)) ?>;
    const categoryTotals = <?= json_encode(array_values($categories)) ?>;

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                { label: 'Sales', data: sales, borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,0.1)', tension:0.35 },
                { label: 'Expenses', data: expenses, borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.1)', tension:0.35 }
            ]
        },
        options: { responsive:true, plugins:{ legend:{ position:'bottom' } } }
    });

    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: { labels: categories, datasets:[{ data: categoryTotals, backgroundColor:['#3b82f6','#10b981','#f59e0b','#ef4444','#6366f1','#8b5cf6'] }] },
        options: { responsive:true, plugins:{ legend:{ position:'bottom' } } }
    });
</script>

<?php include __DIR__.'/includes/footer.php'; ?>
