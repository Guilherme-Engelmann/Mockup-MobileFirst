<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>App Trens - Admin</title>
</head>
<body>


    <div class="phone-content">
      <div class="header">
        <i id="backBtn" class="fas fa-arrow-left back-icon"></i>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Dashboard Admin</h2>
        </div>
      </div>

      <div class="container">
        <div class="phone">
          <div class="top-icon">
            <div class="app-item">
              <img src="../imagens/dashboard.png" alt="Dashboard">
              <a href="dashboardGeral.php">Dashboard</a>
            </div>
          </div>
          <div class="app-grid">
            <div class="app-item">
              <img src="../imagens/velocimetro.jpg" alt="Velocidade">
              <a href="velocidade.php">Velocidade</a>
            </div>
            <div class="app-item">
              <img src="../imagens/rota.png" alt="Rotas">
              <a href="rotas.php">Rotas</a>
            </div>
            <div class="app-item">
              <img src="../imagens/meusdados_logo.png" alt="Meus dados">
              <a href="meusDados.php">Meus dados</a>
            </div>
            <div class="app-item">
              <img src="../imagens/statustrem.jpg" alt="Status dos trens">
              <a href="statusTrans.php">Status do trem</a>
            </div>
            <div class="app-item">
              <img src="../imagens/chat.png" alt="Chat">
              <a href="chat.php">Chat</a>
            </div>
            <div class="app-item">
              <img src="../imagens/notificação.avif" alt="Alertas">
              <a href="alertas.php">Alertas e notificações</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('logoutBtn').addEventListener('click', () => {
      window.location.href = "logout.php";
    });
    document.querySelectorAll('.app-item a').forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const destino = link.getAttribute('data-destino');
        link.classList.add('clicked');
        setTimeout(() => {
          window.location.href = destino;
        }, 200);
      });
    });
  </script>

</body>
</html>
