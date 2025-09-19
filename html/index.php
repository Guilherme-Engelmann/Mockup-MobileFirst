<?php

//faz a conexao
include "db.php";
//inicia a sessao
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha   = $_POST['senha'];

    // consulta usuário (pode ser nome ou email)
    $stmt = $mysqli->prepare("SELECT idUsuario, nomeUsuario, email, senha FROM Usuarios WHERE nomeUsuario = ? OR email = ?");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();

    $result = $stmt->get_result();
    $dados = $result -> fetch_assoc();
    $stmt->close();
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Simples</title>
    <link rel="stylesheet" href="../css/style.css">
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

<?php endif; ?> 
</body>
</html>