<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$manutencoes = [];
$result = $conn->query("SELECT m.*, t.modeloTrem, t.numero_serie FROM Manutencoes m JOIN Trens t ON m.idTrem = t.idTrem ORDER BY m.data_agendada DESC");
if($result){
    while($row = $result->fetch_assoc()){
        $manutencoes[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenções</title>
    <link rel="stylesheet" href="../css/dashboard3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Manutenções</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <div class="app-grid">
        <div class="app-item">
          <img src="../imagens/manutenção.jpg" alt="Cadastrar Manutenção">
          <a href="criar_manutencao.php">Cadastrar Manutenção</a>
        </div>
      </div>

      <h3>Manutenções Cadastradas</h3>
      <?php if(empty($manutencoes)): ?>
        <p>Nenhuma manutenção cadastrada.</p>
      <?php else: ?>
        <ul style="list-style: none; padding: 0;">
          <?php foreach($manutencoes as $manutencao): ?>
            <li style="border: 1px solid #ccc; margin: 10px 0; padding: 10px; border-radius: 5px;">
              <strong>Trem: <?=$manutencao['numero_serie']?> - <?=$manutencao['modeloTrem']?></strong><br>
              Tipo: <?=$manutencao['tipoManutencoes']?><br>
              Descrição: <?=$manutencao['descricaoManutencoes']?><br>
              Data Agendada: <?=$manutencao['data_agendada']?><br>
              Data Conclusão: <?=$manutencao['data_conclusao'] ?: 'Pendente'?><br>
              Status: <?=$manutencao['statusManutencoes']?><br>
              Custo: R$ <?=$manutencao['custoManutencoes']?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
