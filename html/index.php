<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tela de Login</title>

  <script src="validador.js"></script>

  <link rel="stylesheet" href="style.css" />

</head>
<body>

  <div class="container">
    <div class="login-box">
      <div class="avatar">
        <img src="https://i.pinimg.com/736x/cf/3c/82/cf3c827e94daede62d82c30f28f5aab2.jpg" alt="Avatar">
      </div>
      <div class="login-form">
        <h2>Login</h2>
        <div class="input-group">
          <span class="icon">📧</span>
          <input type="text" placeholder="Usuário ou e-mail" />
        </div>

        <div class="input-group">
          <span class="icon">🔒</span>
          <input type="password" placeholder="Senha..." />
        </div>

        <div class="options">
          <label><input type="checkbox" checked /> Mantenha-me Conectado</label>
          <a href="esqueceuasenha.php">Esqueceu a senha?</a>
        </div>

        <button class="btn-login">Login</button>
        <a href="dashboardGeral.php"></a>

        <p class="register">Não tem uma conta ainda? <a href="inscreverse.php">Inscrever-se</a></p>
      </div>
    </div>
  </div>
</body>
</html>
