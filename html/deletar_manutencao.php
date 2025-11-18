<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
$manutencao = null;

if($id){
    $stmt = $conn->prepare("SELECT m.*, t.numero_serie, t.modeloTrem FROM Manutencoes m JOIN Trens t ON m.idTrem = t.idTrem WHERE m.idManutencoes = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $manutencao = $result->fetch_assoc();
    $stmt->close();
}

if(!$manutencao){
    header("Location: manutencao.php");
    exit;
}

$msg = "";
$msg_type = "";

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirmar_delete'])){
    $stmt = $conn->prepare("DELETE FROM Manutencoes WHERE idManutencoes = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        $msg = "Manutenção deletada com sucesso!";
        $msg_type = "success";
        header("Location: manutencao.php?msg=" . urlencode($msg) . "&type=" . $msg_type);
        exit;
    }else{
        $msg = "Erro ao deletar manutenção: " . $conn->error;
        $msg_type = "error";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Manutenção</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="manutencao.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Deletar Manutenção</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <div style="width:100%;max-width:500px;margin:0 auto;text-align:center;">
        <h3>Confirmar Exclusão</h3>
        <?php if($msg): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>

        <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #f9f9f9; margin: 20px 0;">
          <h4>Detalhes da Manutenção</h4>
          <p><strong>Trem:</strong> <?=$manutencao['numero_serie']?> - <?=$manutencao['modeloTrem']?></p>
          <p><strong>Tipo:</strong> <?=$manutencao['tipoManutencoes']?></p>
          <p><strong>Descrição:</strong> <?=$manutencao['descricaoManutencoes']?></p>
          <p><strong>Data Agendada:</strong> <?=date('d/m/Y', strtotime($manutencao['data_agendada']))?></p>
          <p><strong>Status:</strong> <?=$manutencao['statusManutencoes']?></p>
          <p><strong>Custo:</strong> R$ <?=number_format($manutencao['custoManutencoes'], 2, ',', '.')?></p>
        </div>

        <p style="color: #dc3545; font-weight: bold;">⚠️ Atenção: Esta ação não pode ser desfeita!</p>

        <form method="post" style="display: inline-block; margin-top: 20px;">
          <button type="submit" name="confirmar_delete" value="1" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; margin-right: 10px;">Confirmar Exclusão</button>
          <a href="manutencao.php" style="background-color: #6c757d; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-block;">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
