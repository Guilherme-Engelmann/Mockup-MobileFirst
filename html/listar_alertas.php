<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || ($_SESSION["cargo"] !== "admin" && $_SESSION["cargo"] !== "adm")){
    header("Location: index.php");
    exit;
}

// Buscar todos os alertas
$alertas = [];
$result = $conn->query("SELECT a.*, t.numero_serie, r.nomeRota FROM Alertas a LEFT JOIN Viagens v ON a.idViagem = v.idViagem LEFT JOIN Trens t ON v.idTrem = t.idTrem LEFT JOIN Rotas r ON v.idRota = r.idRota ORDER BY a.tempoAlerta DESC");
if($result){
    while($row = $result->fetch_assoc()){
        $alertas[] = $row;
    }
    $result->free();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Alertas e Notificações</title>
    <link rel="stylesheet" href="../css/dashboard3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-bell header-icon"></i>
        <h2>Alertas e Notificações</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <h3>Todos os Alertas e Notificações</h3>
      <?php if(empty($alertas)): ?>
        <p style="text-align:center; color:#666;">Nenhum alerta ou notificação cadastrada.</p>
      <?php else: ?>
        <table style="width:100%; border-collapse:collapse; margin-top:20px;">
          <thead>
            <tr style="background:#f5f5f5;">
              <th style="padding:10px; border:1px solid #ccc;">Data/Hora</th>
              <th style="padding:10px; border:1px solid #ccc;">Trem</th>
              <th style="padding:10px; border:1px solid #ccc;">Rota</th>
              <th style="padding:10px; border:1px solid #ccc;">Tipo</th>
              <th style="padding:10px; border:1px solid #ccc;">Severidade</th>
              <th style="padding:10px; border:1px solid #ccc;">Descrição</th>
              <th style="padding:10px; border:1px solid #ccc;">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($alertas as $alerta): ?>
              <tr>
                <td style="padding:10px; border:1px solid #ccc; font-size:13px;"> <?=htmlspecialchars($alerta['tempoAlerta'])?> </td>
                <td style="padding:10px; border:1px solid #ccc;"> <?=htmlspecialchars($alerta['numero_serie'] ?? '-')?> </td>
                <td style="padding:10px; border:1px solid #ccc;"> <?=htmlspecialchars($alerta['nomeRota'] ?? '-')?> </td>
                <td style="padding:10px; border:1px solid #ccc;"> <?=htmlspecialchars($alerta['tipoAlerta'])?> </td>
                <td style="padding:10px; border:1px solid #ccc;"> <?=htmlspecialchars($alerta['severidadeAlerta'])?> </td>
                <td style="padding:10px; border:1px solid #ccc;"> <?=htmlspecialchars($alerta['descricaoAlerta'])?> </td>
                <td style="padding:10px; border:1px solid #ccc;"> <?=htmlspecialchars($alerta['statusResolucao'])?> </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
