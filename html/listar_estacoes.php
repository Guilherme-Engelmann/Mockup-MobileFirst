<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$estacoes = [];
$result = $conn->query("SELECT * FROM Estacoes ORDER BY nomeEstacao");
if($result){
    while($row = $result->fetch_assoc()){
        $estacoes[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Estações</title>
    <link rel="stylesheet" href="../css/dashboard3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Estações Cadastradas</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <?php if(empty($estacoes)): ?>
        <p>Nenhuma estação cadastrada.</p>
      <?php else: ?>
        <ul style="list-style: none; padding: 0;">
          <?php foreach($estacoes as $estacao): ?>
            <li style="border: 1px solid #ccc; margin: 10px 0; padding: 10px; border-radius: 5px;">
              <strong><?=$estacao['nomeEstacao']?></strong><br>
              Tipo: <?=$estacao['tipoEstacao']?><br>
              Latitude: <?=$estacao['latitude']?>, Longitude: <?=$estacao['longitude']?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
