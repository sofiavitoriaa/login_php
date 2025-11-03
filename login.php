<?php

session_start();

$users = [
    'user@example.com' => 'secret123',
    'admin@site.com'   => 'admin000'
];

if (isset($_SESSION['user_email'])) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $errors[] = 'Informe o e-mail.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'E-mail inválido.';
    }

    if ($password === '') {
        $errors[] = 'Informe a senha.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Senha deve ter ao menos 6 caracteres.';
    }

    if (empty($errors)) {
        if (isset($users[$email]) && $users[$email] === $password) {
            // sucesso - inicializa sessão
            session_regenerate_id(true);
            $_SESSION['user_email'] = $email;
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'E-mail ou senha incorretos.';
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Login — Exemplo Básico</title>
<style>
body{font-family:Arial;padding:20px;max-width:480px;margin:auto}
.input{display:block;margin:8px 0;padding:8px;width:100%}
.btn{padding:8px 12px}
.error{color:#b00}
.card{border:1px solid #ddd;padding:18px;border-radius:6px}
</style>
</head>
<body>
<div class="card">
  <h2>Login (exemplo)</h2>

  <?php if (!empty($errors)): ?>
    <div class="error">
      <ul>
        <?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" action="">
    <label for="email">E-mail</label>
    <input id="email" class="input" type="email" name="email" value="<?=htmlspecialchars($email)?>" required>

    <label for="password">Senha</label>
    <input id="password" class="input" type="password" name="password" required>

    <button class="btn" type="submit">Entrar</button>
  </form>

  <hr>
  <p><strong>Usuários de teste:</strong><br>
  user@example.com / <em>secret123</em><br>
  admin@site.com / <em>admin000</em></p>
</div>
</body>
</html>
