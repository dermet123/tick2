<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
  if ($stmt->execute([$id])) {
    echo "Usuario eliminado.";
  } else {
    echo "Error al eliminar.";
  }
}
