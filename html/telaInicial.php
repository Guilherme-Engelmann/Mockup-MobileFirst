<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tela de Carregamento</title>
  <link rel="stylesheet" href="../css/style.css" />
  <script>
    setTimeout(() => {
      window.location.href = "tela de login2.php"; 
    }, 3000);
  </script>
</head>
<body>
  

    <div class="phone-content">
      <div class="header">
        <i class="fas fa-arrow-left back-icon"></i>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Tela inicial</h2>
        </div>
      </div>

      <div class="container">
        <img src="../imagens/pngtrem.png" alt="Trem" class="trem" />
        <div class="tracktrain-title">
          <span class="track">TRACK</span><span class="train">TRAIN</span>
        </div>
        <p class="loading-text">Carregando...</p>
        <div class="progress-bar">
          <div class="progress"></div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
