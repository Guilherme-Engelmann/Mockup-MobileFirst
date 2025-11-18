<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$trens = [];
$result = $conn->query("SELECT t.*, r.nomeRota FROM Trens t LEFT JOIN Rotas r ON t.idRota = r.idRota ORDER BY t.numero_serie");
if($result){
    while($row = $result->fetch_assoc()){
        $trens[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Trens</title>
    <link rel="stylesheet" href="../css/dashboard3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Trens Cadastrados</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <?php if(empty($trens)): ?>
        <p>Nenhum trem cadastrado.</p>
      <?php else: ?>
        <ul style="list-style: none; padding: 0;">
          <?php foreach($trens as $trem): ?>
            <li style="border: 1px solid #ccc; margin: 10px 0; padding: 10px; border-radius: 5px;">
              <strong>Série: <?=$trem['numero_serie']?></strong><br>
              Modelo: <?=$trem['modeloTrem']?><br>
              Data Fabricação: <?=$trem['data_fabricacao']?><br>
              Capacidade Passageiros: <?=$trem['capacidade_passageiros']?><br>
              Capacidade Carga: <?=$trem['capacidade_carga']?><br>
              Status: <?=$trem['status_operacional']?><br>
              Rota Associada: <?=$trem['nomeRota'] ?: 'Nenhuma'?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
