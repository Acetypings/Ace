<?php
// index.php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Customer Feedback — Login / Sign Up</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="min-h-screen bg-blue-50 flex items-center justify-center p-6">

  <div class="w-full max-w-md">
    <div id="auth-card" class="bg-white rounded-2xl shadow-lg overflow-hidden card-transition transform hover:scale-[1.005] transition-transform duration-300 ease-in-out">
      
      <!-- Overall App Title -->
      <div class="pt-8 px-6 text-center">
        <h1 class="text-4xl font-extrabold text-blue-700 mb-6 tracking-tight">Customer Feedback</h1>
      </div>

      <!-- Header -->
      <div class="p-6 border-b border-blue-100 text-center">
        <h2 id="card-title" class="text-2xl font-bold text-blue-600">Welcome back</h2>
        <p id="card-sub" class="text-sm text-slate-500 mt-1">Sign in to continue to Customer Feedback Monitoring</p>
      </div>

      <!-- Content area -->
      <div class="p-6">
        <?php include(__DIR__ . "/sign_up.php"); ?>
      </div>

      <!-- Footer -->
      <div class="px-6 py-4 border-t border-blue-100 text-xs text-slate-400 text-center">
        © <span id="year"></span> Customer Feedback Monitoring
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
