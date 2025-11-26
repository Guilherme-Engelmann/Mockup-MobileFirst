<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || ( $_SESSION["cargo"] !== "admin" && $_SESSION["cargo"] !== "adm" )){
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

// Verificar mensagens de sucesso
$msg = "";
if(isset($_GET['msg'])){
    switch($_GET['msg']){
        case 'estacao_editada':
            $msg = "Estação editada com sucesso!";
            $msg_type = "success";
            break;
        case 'estacao_deletada':
            $msg = "Estação deletada com sucesso!";
            $msg_type = "success";
            break;
        case 'estacao_em_uso':
            $msg = "Não é possível deletar esta estação pois ela está sendo utilizada em rotas.";
            $msg_type = "error";
            break;
    }
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
      <?php if($msg): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>
      <?php if(empty($estacoes)): ?>
        <p>Nenhuma estação cadastrada.</p>
      <?php else: ?>
        <div class="search-container" style="margin-bottom: 20px;">
          <input type="text" id="searchInput" placeholder="Buscar estação por nome..." style="width: 100%; max-width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <table id="estacoesTable" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
          <thead>
            <tr style="background-color: #f5f5f5;">
              <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Nome da Estação</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Tipo</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Latitude</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Longitude</th>
              <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($estacoes as $estacao): ?>
              <tr style="border: 1px solid #ddd;">
                <td style="border: 1px solid #ddd; padding: 12px;"><strong><?=$estacao['nomeEstacao']?></strong></td>
                <td style="border: 1px solid #ddd; padding: 12px;"><?=$estacao['tipoEstacao']?></td>
                <td style="border: 1px solid #ddd; padding: 12px; text-align: center;"><?=$estacao['latitude']?></td>
                <td style="border: 1px solid #ddd; padding: 12px; text-align: center;"><?=$estacao['longitude']?></td>
                <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">
                  <button onclick="editarEstacao(<?=$estacao['idEstacao']?>)" style="background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; margin-right: 5px;">Editar</button>
                  <button onclick="deletarEstacao(<?=$estacao['idEstacao']?>)" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Deletar</button>
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
    const rows = document.querySelectorAll('#estacoesTable tbody tr');

    rows.forEach(row => {
        const nomeEstacao = row.cells[0].textContent.toLowerCase();
        if (nomeEstacao.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function editarEstacao(id) {
    window.location.href = 'editar_estacao.php?id=' + id;
}

function deletarEstacao(id) {
    if (confirm('Tem certeza que deseja deletar esta estação?')) {
        window.location.href = 'deletar_estacao.php?id=' + id;
    }
}
</script>
</body>
</html>
