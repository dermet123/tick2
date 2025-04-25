<?php
require_once '../config/database.php';
$stmt = $pdo->query("SELECT id, name FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Generar Ticket</title>
  <script>
    function generatePDF() {
      const userId = document.getElementById('user').value;
      if (userId) {
        window.open(`../generatePDF.php?id=${userId}`, '_blank');
      }
    }
  </script>
  <link href="style.css" rel="stylesheet">
</head>
<body class="p-8 bg-gray-100">
  <div class="max-w-md mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">Generar Ticket PDF</h2>
    <label for="user" class="block font-medium mb-2">Seleccionar Usuario:</label>
    <select id="user" class="w-full p-2 border rounded mb-4">
      <option value="">-- Seleccione --</option>
      <?php foreach ($users as $u): ?>
        <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
      <?php endforeach; ?>
    </select>

    <button onclick="generatePDF()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
      Generar PDF
    </button>
  </div>
</body>
</html>
