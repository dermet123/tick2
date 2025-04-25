<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $language = $_POST['language'];

  $stmt = $pdo->prepare("INSERT INTO users (email, name, phone, language) VALUES (?, ?, ?, ?)");
  if ($stmt->execute([$email, $name, $phone, $language])) {
    echo "Usuario guardado correctamente.";
  } else {
    echo "Error al guardar el usuario.";
  }
}
