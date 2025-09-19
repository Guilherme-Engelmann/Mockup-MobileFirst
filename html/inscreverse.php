<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscrever-se</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="signup-container">
      <div class="phone-content">
        <div class="header">
        <a href="index.php"><i class="fas fa-arrow-left back-icon"></i></a>
          <div class="icon-title">
            <i class="fas fa-clipboard-list header-icon"></i>
            <h2>Inscrever-se</h2>
          </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
          <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <form action="../create.php" method="POST" id="signup-form">
          <input type="text" name="nomeUsuario" placeholder="Digite seu nome de usuário" required>
          <input type="email" name="email" placeholder="Digite seu e-mail" required>
          <input type="password" name="senha" placeholder="Digite sua senha" required>
          <input type="password" name="confirm_senha" placeholder="Confirme sua senha" required>
          <button type="submit">Criar Conta</button>
        </form>
      </div>
    </div>
  </div>


</body>
</html>
