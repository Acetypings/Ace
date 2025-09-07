<?php include __DIR__.'/includes/header.php'; ?>
<?php include __DIR__.'/includes/db.php'; ?>

<main class="max-w-4xl mx-auto p-4">
  <h1 class="text-xl font-bold mb-4">Sales</h1>

  <!-- Add Sale Form -->
  <form method="POST" class="bg-white p-5 rounded-lg shadow-sm mb-6">
    <div class="mb-3">
      <label class="block text-sm font-medium mb-1">Amount</label>
      <input type="number" step="0.01" name="amount" required class="w-full border rounded px-3 py-2">
    </div>
    <div class="mb-3">
      <label class="block text-sm font-medium mb-1">Date</label>
      <input type="date" name="sale_date" required class="w-full border rounded px-3 py-2">
    </div>
    <button type="submit" name="add_sale" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">Save</button>
  </form>

  <!-- Save to DB -->
  <?php
  if (isset($_POST['add_sale'])) {
    $amount = $_POST['amount'];
    $date   = $_POST['sale_date'];
    $conn->query("INSERT INTO sales (amount, sale_date) VALUES ('$amount', '$date')");
    echo "<script>window.location.href='sales.php';</script>";
  }
  ?>

  <!-- List Sales -->
  <h2 class="text-lg font-bold mb-3">Recent Sales</h2>
  <div class="bg-white rounded-lg shadow-sm p-4">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2">Date</th>
          <th class="text-right py-2">Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM sales ORDER BY sale_date DESC LIMIT 10");
        while ($row = $result->fetch_assoc()) {
          echo "<tr class='border-b'>
                  <td class='py-2'>{$row['sale_date']}</td>
                  <td class='py-2 text-right'>$".number_format($row['amount'], 2)."</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</main>

<?php include __DIR__.'/includes/footer.php'; ?>
