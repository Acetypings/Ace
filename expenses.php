=<?php include __DIR__.'/includes/header.php'; ?>
<?php include __DIR__.'/includes/db.php'; ?>

<main class="max-w-4xl mx-auto p-4">
  <h1 class="text-xl font-bold mb-4">Expenses</h1>

  <!-- Add Expense Form -->
  <form method="POST" class="bg-white p-5 rounded-lg shadow-sm mb-6">
    <div class="mb-3">
      <label class="block text-sm font-medium mb-1">Amount</label>
      <input type="number" step="0.01" name="amount" required class="w-full border rounded px-3 py-2">
    </div>
    <div class="mb-3">
      <label class="block text-sm font-medium mb-1">Category</label>
      <input type="text" name="category" required class="w-full border rounded px-3 py-2">
    </div>
    <div class="mb-3">
      <label class="block text-sm font-medium mb-1">Date</label>
      <input type="date" name="expense_date" required class="w-full border rounded px-3 py-2">
    </div>
    <button type="submit" name="add_expense" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">Save</button>
  </form>

  <!-- Save to DB -->
  <?php
  if (isset($_POST['add_expense'])) {
    $amount = $_POST['amount'];
    $cat    = $_POST['category'];
    $date   = $_POST['expense_date'];
    $conn->query("INSERT INTO expenses (amount, category, expense_date) VALUES ('$amount', '$cat', '$date')");
    echo "<script>window.location.href='expenses.php';</script>";
  }
  ?>

  <!-- List Expenses -->
  <h2 class="text-lg font-bold mb-3">Recent Expenses</h2>
  <div class="bg-white rounded-lg shadow-sm p-4">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2">Date</th>
          <th class="text-left py-2">Category</th>
          <th class="text-right py-2">Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM expenses ORDER BY expense_date DESC LIMIT 10");
        while ($row = $result->fetch_assoc()) {
          echo "<tr class='border-b'>
                  <td class='py-2'>{$row['expense_date']}</td>
                  <td class='py-2'>{$row['category']}</td>
                  <td class='py-2 text-right'>$".number_format($row['amount'], 2)."</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</main>

<?php include __DIR__.'/includes/footer.php'; ?>
