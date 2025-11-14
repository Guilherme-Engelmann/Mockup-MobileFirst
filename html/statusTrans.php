<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Status dos Trens</title>
  <link rel="stylesheet" href="../css/trens.css">
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
        <?php
        include "db.php";
        $trens = [];
        $result = $conn->query("SELECT * FROM Trens ORDER BY numero_serie");
        if($result){
            while($row = $result->fetch_assoc()){
                $trens[] = $row;
            }
            $result->free();
        }
        if(empty($trens)){
            echo "<p>Nenhum trem cadastrado.</p>";
        }else{
            foreach($trens as $trem){
                ?>
                <div class="train-card">
                  <div class="train-icon">
                    <i class="fas fa-subway"></i>
                    <img src="pngtrem.jpg" alt="">
                    <div class="train-id"><?=$trem['numero_serie']?></div>
                  </div>
                  <div class="train-info">
                    <p><strong>Modelo:</strong> <?=$trem['modeloTrem']?></p>
                    <p><strong>Carga:</strong> <?=$trem['capacidade_carga']?></p>
                    <p><strong>Data Fabricação:</strong> <?=$trem['data_fabricacao']?></p>
                    <p><strong>Capacidade Passageiros:</strong> <?=$trem['capacidade_passageiros']?></p>

                    <div class="desempenho">
                      <span class="label">Status</span>
                      <div class="options">
                        <label><?=$trem['status_operacional']?></label>
                      </div>
                    </div>

                    <div class="battery">
                      <i class="fas fa-bolt"></i> 80%
                    </div>
                  </div>
                </div>
                <?php
            }
        }
        ?>
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
