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


$success_msg = "";
if(isset($_GET['msg']) && $_GET['msg'] === 'rota_deletada'){
    $success_msg = "Rota deletada com sucesso!";
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
      <?php if($success_msg): ?><p class="message success"><?=$success_msg?></p><?php endif; ?>
      <?php if(empty($rotas)): ?>
        <p>Nenhuma rota cadastrada.</p>
      <?php else: ?>
        <div class="search-container" style="margin-bottom: 20px;">
          <input type="text" id="searchInput" placeholder="Buscar rota por nome..." style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
        </div>
        <table id="rotasTable" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
          <thead>
            <tr style="background-color: #f5f5f5;">
              <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Nome da Rota</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Origem</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Destino</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Distância (km)</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Tempo Médio</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($rotas as $rota): ?>
              <tr style="border: 1px solid #ddd;">
                <td style="border: 1px solid #ddd; padding: 12px;"><strong><?=$rota['nomeRota']?></strong></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><?=$rota['origem']?></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><?=$rota['destino']?></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><?=$rota['distanciaTotal']?></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><?=$rota['tempoMedioPercurso']?></td>
                <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">
                  <a href="editar_rota.php?id=<?=$rota['idRota']?>" style="background-color: #007bff; color: white; text-decoration: none; padding: 5px 10px; border-radius: 3px; margin-right: 5px; display: inline-block;">Editar</a>
                  <a href="deletar_rota.php?id=<?=$rota['idRota']?>" onclick="return confirm('Tem certeza que deseja deletar esta rota?')" style="background-color: #dc3545; color: white; text-decoration: none; padding: 5px 10px; border-radius: 3px; display: inline-block;">Deletar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#rotasTable tbody tr');

    rows.forEach(row => {
        const nomeRota = row.cells[0].textContent.toLowerCase();
        if (nomeRota.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function editarRota(id) {
    window.location.href = 'editar_rota.php?id=' + id;
}

function deletarRota(id) {
    if (confirm('Tem certeza que deseja deletar esta rota?')) {
        window.location.href = 'deletar_rota.php?id=' + id;
    }
}
</script>
</body>
</html>
