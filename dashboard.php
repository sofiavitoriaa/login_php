<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user_email'];
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Dashboard</title></head>
<body>
  <h1>Bem-vindo(a), <?=htmlspecialchars($user)?>!</h1>
  <p>Área restrita (exemplo básico).</p>
  <p><a href="logout.php">Sair</a></p>
</body>
</html>
