<?php
require_once '../../config/database.php';

$stmt = $pdo->query("SELECT * FROM tupas ORDER BY id ASC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
