<?php include __DIR__.'/includes/header.php'; ?>
<?php 
include __DIR__.'/includes/db.php';
include_once __DIR__.'/includes/currency.php';

// Handle form submission
$message = '';
if(isset($_POST['currency'])){
    file_put_contents(__DIR__.'/includes/currency.txt', $_POST['currency']);
    $message = "Currency updated successfully!";
}

// Current currency
$currentCurrency = file_exists(__DIR__.'/includes/currency.txt') ? trim(file_get_contents(__DIR__.'/includes/currency.txt')) : "₱";
?>

<main class="max-w-4xl mx-auto p-4 md:p-6">
  <div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Settings</h2>

    <?php if($message): ?>
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" class="grid grid-cols-1 gap-4">
      <label class="text-gray-600 font-medium">Select Currency</label>
      <select name="currency" class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="₱" <?= $currentCurrency=="₱" ? "selected":"" ?>>Philippine Peso (₱)</option>
        <option value="$" <?= $currentCurrency=="$" ? "selected":"" ?>>US Dollar ($)</option>
        <option value="€" <?= $currentCurrency=="€" ? "selected":"" ?>>Euro (€)</option>
      </select>

      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-medium mt-4">Save Changes</button>
    </form>
  </div>
</main>

<?php include __DIR__.'/includes/footer.php'; ?>
