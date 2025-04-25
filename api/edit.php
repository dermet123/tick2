<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $language = $_POST['language'];

  $stmt = $pdo->prepare("UPDATE users SET email=?, name=?, phone=?, language=? WHERE id=?");
  if ($stmt->execute([$email, $name, $phone, $language, $id])) {
    echo "Usuario actualizado correctamente.";
  } else {
    echo "Error al actualizar.";
  }
}
