<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$id_rota = intval($_GET['id'] ?? 0);

if(!$id_rota){
    header("Location: listar_rotas.php");
    exit;
}

// Verificar se a rota existe
$result = $conn->query("SELECT nomeRota FROM Rotas WHERE idRota = $id_rota");
if(!$result || $result->num_rows === 0){
    header("Location: listar_rotas.php");
    exit;
}
$rota = $result->fetch_assoc();
$result->free();

// Verificar se há viagens associadas a esta rota
$result = $conn->query("SELECT COUNT(*) as total FROM Viagens WHERE idRota = $id_rota");
$viagens_count = $result->fetch_assoc()['total'];
$result->free();

$msg = "";
$msg_type = "";

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirmar_deletar'])){
    if($viagens_count > 0){
        $msg = "Não é possível deletar esta rota pois existem $viagens_count viagem(ns) associada(s) a ela.";
        $msg_type = "error";
    }else{
        $stmt = $conn->prepare("DELETE FROM Rotas WHERE idRota = ?");
        $stmt->bind_param("i", $id_rota);
        if($stmt->execute()){
            header("Location: listar_rotas.php?msg=rota_deletada");
            exit;
        }else{
            $msg = "Erro ao deletar rota: " . $conn->error;
            $msg_type = "error";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Rota</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="listar_rotas.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-times-circle header-icon"></i>
        <h2>Deletar Rota</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <div style="width:100%;max-width:500px;margin:0 auto;text-align:center;">
        <h3>Confirmar Exclusão</h3>
        <?php if($msg): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>

        <div style="border: 1px solid #ccc; padding: 20px; border-radius: 5px; margin: 20px 0; background-color: #f9f9f9;">
          <h4><?=$rota['nomeRota']?></h4>
          <?php if($viagens_count > 0): ?>
            <p style="color: #dc3545;"><strong>Atenção:</strong> Esta rota possui <?=$viagens_count?> viagem(ns) associada(s).</p>
            <p>Não é possível deletar rotas que possuem viagens associadas.</p>
          <?php else: ?>
            <p>Tem certeza que deseja deletar esta rota?</p>
            <p style="color: #dc3545;"><strong>Esta ação não pode ser desfeita!</strong></p>
          <?php endif; ?>
        </div>

        <?php if($viagens_count === 0): ?>
          <form method="post" style="display: inline;">
            <button type="submit" name="confirmar_deletar" value="1" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Deletar Rota</button>
          </form>
        <?php endif; ?>
        <a href="listar_rotas.php" style="background-color: #6c757d; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Cancelar</a>
      </div>
    </div>
  </div>
</body>
</html>
