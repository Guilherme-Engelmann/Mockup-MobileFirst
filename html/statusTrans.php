<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Status dos Trens</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
  

    <div class="phone-content">
      <div class="header">
        <a href="dashboard3.php"><i class="fas fa-arrow-left back-icon"></i></a>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Status dos trens</h2>
        </div>
      </div>

      <div class="train-list">
      
        <div class="train-card">
          <div class="train-icon">
            <i class="fas fa-subway"></i>
            <img src="pngtrem.jpg" alt="">
            <div class="train-id">031</div>
          </div>
          <div class="train-info">
            <p><strong>Modelo:</strong></p>
            <p><strong>Carga:</strong></p>
            <p><strong>Horário de saída e chegada</strong></p>
            <p><strong>Condutor</strong></p>

            <div class="desempenho">
              <span class="label">Desempenho</span>
              <div class="options">
                <label><input type="checkbox" checked> Ruim</label>
                <label><input type="checkbox"> Moderado</label>
                <label><input type="checkbox"> Bom</label>
              </div>
            </div>

            <div class="battery">
              <i class="fas fa-bolt"></i> 60%
            </div>
          </div>
        </div>

        <div class="train-card">
          <div class="train-icon">
            <i class="fas fa-subway"></i>
            <div class="train-id">057</div>
          </div>
          <div class="train-info">
            <p><strong>Modelo:</strong></p>
            <p><strong>Carga:</strong></p>
            <p><strong>Horário de saída da estação x</strong></p>
            <p><strong>Condutor</strong></p>

            <div class="desempenho">
              <span class="label">Desempenho</span>
              <div class="options">
                <label><input type="checkbox"> Ruim</label>
                <label><input type="checkbox" checked> Moderado</label>
                <label><input type="checkbox"> Bom</label>
              </div>
            </div>

            <div class="battery">
              <i class="fas fa-bolt"></i> 90%
            </div>
          </div>
        </div>

        <div class="train-card">
          <div class="train-icon">
            <i class="fas fa-subway"></i>
            <div class="train-id">341</div>
          </div>
          <div class="train-info">
            <p><strong>Modelo:</strong></p>
            <p><strong>Carga:</strong></p>
            <p><strong>Horário de saída da estação x</strong></p>
            <p><strong>Condutor</strong></p>

            <div class="desempenho">
              <span class="label active">Desempenho</span>
              <div class="options">
                <label><input type="checkbox"> Ruim</label>
                <label><input type="checkbox"> Moderado</label>
                <label><input type="checkbox" checked> Bom</label>
              </div>
            </div>

            <div class="battery">
              <i class="fas fa-bolt"></i> 75%
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('backBtn').addEventListener('click', () => {
      window.location.href = "dashboard3.html";
    });
  </script>
</body>
</html>
