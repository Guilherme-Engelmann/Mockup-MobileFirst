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
    <h2>Inscrever-se</h2>
 
    

      <div class="phone-content">
        <div class="header">
          <i id="backBtn" class="fas fa-arrow-left back-icon"></i>
          <div class="icon-title">
            <i class="fas fa-clipboard-list header-icon"></i>
            <h2>Inscrever-se</h2>
          </div>
        </div>

        <form id="signup-form">
          <input type="text" name="name" placeholder="Digite seu nome" required>
          <input type="email" name="email" placeholder="Digite seu e-mail" required>
          <input type="password" name="password" placeholder="Digite sua senha" required>
          <input type="password" name="confirm_password" placeholder="Confirme sua senha" required>
          <button type="submit">Criar Conta</button>
        </form>
      </div>
    </div>
  </div>

  <script>
        document.getElementById('backBtn').addEventListener('click', () => {
      window.location.href = "tela de login2.html";
    });
    document.getElementById('signup-form').addEventListener('submit', function(event) {
      event.preventDefault();

    
      window.location.href = 'tela de login2.html';
    });
  </script>
</body>
</html>
