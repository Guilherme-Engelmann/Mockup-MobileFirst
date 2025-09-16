<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tela de Login</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>

 

    <div class="phone-content">
      <div class="header">
        <i class="fas fa-arrow-left back-icon"></i>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Tela de login</h2>
        </div>
      </div>

      <div class="login-box">
        <?php if (isset($_GET['message'])): ?>
          <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>
        <div class="avatar">
          <img src="../imagens/perfil.png" alt="Avatar">
        </div>

        <form class="login-form" action="../login.php" method="POST" id="meuFormulario">
          <h2>Login</h2>

          <div class="input-group">
            <span class="icon">📧</span>
            <input type="text" placeholder="Login" name="login" id="login" required />
            <div class="error" id="erroLogin"></div>
          </div>

          <div class="input-group">
            <input type="password" placeholder="Senha..." name="senha" id="senha" required />
            <div class="error" id="erroSenha"></div>
          </div>

          <div class="options">
            <label><input type="checkbox" checked /> Mantenha-me Conectado</label>
            <a href="esqueceuasenha.php">Esqueceu a senha?</a>
          </div>

          <button type="submit" class="btn-login">Login</button>
          <p class="register">Não tem uma conta ainda? <a href="inscreverse.php">Inscrever-se</a></p>
        </form>
      </div>
    </div>
  </div>



</body>
</html>
