<?php
include 'db.php'; // conexão com banco

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha   = $_POST['senha'];

    // consulta usuário (pode ser nome ou email)
    $stmt = $mysqli->prepare("SELECT idUsuario, nomeUsuario, email, senha FROM Usuarios WHERE nomeUsuario = ? OR email = ?");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['idUsuario']   = $user['idUsuario'];
            $_SESSION['nomeUsuario'] = $user['nomeUsuario'];
            header("Location: home.php"); // página após login
            exit();
        } else {
            $error = "Senha incorreta!";
        }
    } else {
        $error = "Usuário ou e-mail não encontrado!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Login</title>
  <style>
    /* Fundo */
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: url('fundo.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* Caixa central */
    .login-container {
      background: rgba(255,255,255,0.95);
      border-radius: 15px;
      padding: 25px;
      width: 320px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      text-align: center;
    }

    .login-container img {
      width: 80px;
      margin-bottom: 10px;
    }

    .login-container h2 {
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: bold;
    }

    /* Inputs */
    .input-group {
      position: relative;
      margin-bottom: 15px;
    }

    .input-group input {
      width: 100%;
      padding: 12px 40px 12px 12px;
      border: none;
      border-radius: 25px;
      background: #000;
      color: #fff;
      font-size: 14px;
      outline: none;
    }

    .input-group i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #fff;
    }

    /* Botão */
    .login-btn {
      width: 100%;
      padding: 12px;
      background: #28a745;
      border: none;
      border-radius: 25px;
      color: white;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .login-btn:hover {
      background: #218838;
    }

    /* Links */
    .options {
      margin-top: 10px;
      font-size: 13px;
    }

    .options a {
      text-decoration: none;
      color: #007bff;
    }

    .options a:hover {
      text-decoration: underline;
    }

    /* Erros */
    .error {
      color: red;
      margin-bottom: 10px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <img src="user-icon.png" alt="Usuário">
    <h2>Login</h2>

    <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
    <?php if (!empty($_GET['message'])) { echo "<p style='color:green;font-size:14px;'>" . $_GET['message'] . "</p>"; } ?>

    <form method="POST" action="">
      <div class="input-group">
        <input type="text" name="usuario" placeholder="Usuário ou e-mail" required>
        <i>📧</i>
      </div>
      <div class="input-group">
        <input type="password" name="senha" placeholder="Senha..." required>
        <i>🔒</i>
      </div>

      <button type="submit" class="login-btn">Login</button>
    </form>

    <div class="options">
      <label><input type="checkbox"> Mantenha-me Conectado</label><br>
      <a href="#">Esqueceu a senha?</a><br><br>
      <span>Não tem uma conta ainda? <a href="inscreverse.php">Inscreva-se</a></span>
    </div>
  </div>
</body>
</html>
