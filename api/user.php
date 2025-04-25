<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->execute([$id]);
  echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}
