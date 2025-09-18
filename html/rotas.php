<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rotas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
 
    <div class="phone-content">
      <div class="header">
         <a href="dashboard3.php"><i class="fas fa-arrow-left back-icon"></i></a>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Rotas</h2>
        </div>
      </div>
  
    
     
      
      
    </header>
    <section class="route-box">
        <div class="map-section">
        <div class="linha-info">
          <div class="train-icon">🚆</div>
          <div class="linha-num">031</div>
        </div>
        <img src="../imagens/mapa-rota.png" alt="Mapa da Rota" class="mapa">
      </div>

      <div class="info">
        <p class="data">28 de março de 2025</p>

        <div class="hora-bloco">
          <span class="hora">10:30</span>
          <button class="acao">Saída da estação X</button>
        </div>

        <div class="pontos">⋮</div>

        <div class="hora-bloco">
          <span class="hora">10:50</span>
          <button class="acao">Chegada na estação Y</button>
        </div>
      </div>

      
    </section>
    
    </div>
    
    <script>
    document.getElementById('backBtn').addEventListener('click', () => {
      window.location.href = "dashboard3.html";
    });
  </script>
</body>
</html>