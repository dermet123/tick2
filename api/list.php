<?php
require_once '../config/database.php';

$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
