<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$rotas = [];
$result = $conn->query("SELECT r.*, e1.nomeEstacao AS origem, e2.nomeEstacao AS destino FROM Rotas r JOIN Estacoes e1 ON r.estacaoOrigem = e1.idEstacao JOIN Estacoes e2 ON r.estacaoDestino = e2.idEstacao ORDER BY r.nomeRota");
if($result){
    while($row = $result->fetch_assoc()){
        $rotas[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Rotas</title>
    <link rel="stylesheet" href="../css/dashboard3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Rotas Cadastradas</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <?php if(empty($rotas)): ?>
        <p>Nenhuma rota cadastrada.</p>
      <?php else: ?>
        <ul style="list-style: none; padding: 0;">
          <?php foreach($rotas as $rota): ?>
            <li style="border: 1px solid #ccc; margin: 10px 0; padding: 10px; border-radius: 5px;">
              <strong><?=$rota['nomeRota']?></strong><br>
              Origem: <?=$rota['origem']?> → Destino: <?=$rota['destino']?><br>
              Distância: <?=$rota['distanciaTotal']?> km<br>
              Tempo Médio: <?=$rota['tempoMedioPercurso']?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
