<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$id_estacao = intval($_GET['id'] ?? 0);

if(!$id_estacao){
    header("Location: listar_estacoes.php");
    exit;
}


$result = $conn->query("SELECT nomeEstacao FROM Estacoes WHERE idEstacao = $id_estacao");
if(!$result || $result->num_rows === 0){
    header("Location: listar_estacoes.php");
    exit;
}
$estacao = $result->fetch_assoc();
$result->free();


$check_rotas = $conn->query("SELECT COUNT(*) as total FROM Rotas WHERE estacaoOrigem = $id_estacao OR estacaoDestino = $id_estacao");
$rotas_count = $check_rotas->fetch_assoc()['total'];
$check_rotas->free();

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirmar_deletar'])){
    if($rotas_count > 0){
        header("Location: listar_estacoes.php?msg=estacao_em_uso");
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM Estacoes WHERE idEstacao = ?");
    $stmt->bind_param("i", $id_estacao);
    if($stmt->execute()){
        header("Location: listar_estacoes.php?msg=estacao_deletada");
        exit;
    }else{
        $msg = "Erro ao deletar estação: " . $conn->error;
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
    <title>Deletar Estação</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="listar_estacoes.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-trash header-icon"></i>
        <h2>Deletar Estação</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <div style="max-width: 500px; margin: 0 auto; text-align: center;">
        <h3>Confirmar Exclusão</h3>
        <?php if(isset($msg)): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin: 20px 0; border: 1px solid #dee2e6;">
          <p style="margin-bottom: 15px;"><strong>Estação:</strong> <?=$estacao['nomeEstacao']?></p>

          <?php if($rotas_count > 0): ?>
            <div style="background: #fff3cd; border: 1px solid #f39c12; padding: 15px; border-radius: 8px; margin: 15px 0;">
              <p style="color: #856404; margin: 0;"><strong>Atenção:</strong> Esta estação está sendo utilizada em <?=$rotas_count?> rota(s). Não é possível deletar esta estação enquanto ela estiver em uso.</p>
            </div>
            <p style="text-align: center; margin-top: 20px;">
              <a href="listar_estacoes.php" style="display: inline-block; padding: 12px 24px; background: #6c757d; color: white; text-decoration: none; border-radius: 8px;">Voltar</a>
            </p>
          <?php else: ?>
            <p style="color: #dc3545; margin: 20px 0;"><strong>Tem certeza que deseja deletar esta estação?</strong></p>
            <p style="color: #6c757d; font-size: 0.9em;">Esta ação não pode ser desfeita.</p>

            <form method="post" style="margin-top: 30px;">
              <div class="form-buttons">
                <button type="submit" name="confirmar_deletar" value="1" style="background: #dc3545;">Deletar Estação</button>
                <a href="listar_estacoes.php" style="display: inline-block; padding: 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 12px; border: none;">Cancelar</a>
              </div>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
