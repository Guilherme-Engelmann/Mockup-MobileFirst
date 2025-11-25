<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || ( $_SESSION["cargo"] !== "admin" && $_SESSION["cargo"] !== "adm" )){
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

      <!-- Filtros -->
      <div class="filters-container" style="margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap;">
        <div>
          <label for="statusFilter" style="display: block; margin-bottom: 5px; font-weight: bold;">Status:</label>
          <select id="statusFilter" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">Todos</option>
            <option value="pendente">Pendente</option>
            <option value="em_andamento">Em Andamento</option>
            <option value="concluida">Concluída</option>
            <option value="cancelada">Cancelada</option>
          </select>
        </div>
        <div>
          <label for="dataFilter" style="display: block; margin-bottom: 5px; font-weight: bold;">Data:</label>
          <input type="date" id="dataFilter" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div>
          <label for="tremFilter" style="display: block; margin-bottom: 5px; font-weight: bold;">Buscar por Trem:</label>
          <input type="text" id="tremFilter" placeholder="Número de série ou modelo..." style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
      </div>

      <?php if(empty($manutencoes)): ?>
        <p>Nenhuma manutenção cadastrada.</p>
      <?php else: ?>
        <!-- Paginação -->
        <div class="pagination-info" style="margin-bottom: 20px; text-align: center;">
          <span id="paginationText">Mostrando 1-<?=count($manutencoes)?> de <?=count($manutencoes)?> manutenções</span>
        </div>

        <div class="manutencoes-grid" id="manutencoesContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
          <?php foreach($manutencoes as $index => $manutencao): ?>
            <div class="manutencao-card" data-status="<?=$manutencao['statusManutencoes']?>" data-data="<?=$manutencao['data_agendada']?>" data-trem="<?=$manutencao['numero_serie']?> <?=$manutencao['modeloTrem']?>" style="border: 1px solid #ddd; border-radius: 12px; padding: 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
              <div class="card-header" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">
                <h4 style="margin: 0; color: #333;"><i class="fas fa-train" style="margin-right: 8px; color: #007bff;"></i><?=$manutencao['numero_serie']?> - <?=$manutencao['modeloTrem']?></h4>
                <span class="status-badge status-<?=$manutencao['statusManutencoes']?>" style="display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 0.8em; font-weight: bold; text-transform: uppercase; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                  <?=$manutencao['statusManutencoes']?>
                </span>
              </div>

              <div class="card-body">
                <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                  <span><strong>Tipo:</strong></span>
                  <span><?=$manutencao['tipoManutencoes']?></span>
                </div>
                <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                  <span><strong>Data Agendada:</strong></span>
                  <span><?=date('d/m/Y', strtotime($manutencao['data_agendada']))?></span>
                </div>
                <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                  <span><strong>Data Conclusão:</strong></span>
                  <span><?=$manutencao['data_conclusao'] ? date('d/m/Y', strtotime($manutencao['data_conclusao'])) : 'Pendente'?></span>
                </div>
                <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                  <span><strong>Custo:</strong></span>
                  <span style="color: #28a745; font-weight: bold;">R$ <?=number_format($manutencao['custoManutencoes'], 2, ',', '.')?></span>
                </div>
                <div class="description-row" style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #eee;">
                  <strong>Descrição:</strong><br>
                  <span style="color: #666; font-style: italic;"><?=$manutencao['descricaoManutencoes']?></span>
                </div>
              </div>

              <div class="card-actions" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; display: flex; gap: 10px;">
                <button onclick="editarManutencao(<?=$manutencao['idManutencoes']?>)" class="action-btn edit-btn" style="flex: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: all 0.3s ease;">
                  <i class="fas fa-edit" style="margin-right: 5px;"></i>Editar
                </button>
                <button onclick="deletarManutencao(<?=$manutencao['idManutencoes']?>)" class="action-btn delete-btn" style="flex: 1; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: all 0.3s ease;">
                  <i class="fas fa-trash" style="margin-right: 5px;"></i>Deletar
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Controles de paginação -->
        <div class="pagination-controls" style="margin-top: 30px; text-align: center; display: flex; justify-content: center; gap: 10px;">
          <button id="prevPage" onclick="changePage(-1)" style="padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; display: none;">Anterior</button>
          <span id="pageInfo" style="padding: 10px 15px; background: #f8f9fa; border-radius: 6px;">Página 1</span>
          <button id="nextPage" onclick="changePage(1)" style="padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; display: none;">Próxima</button>
        </div>
      <?php endif; ?>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
<script>
let currentPage = 1;
const itemsPerPage = 6;
let filteredCards = [];

// Inicializar paginação
document.addEventListener('DOMContentLoaded', function() {
    const allCards = Array.from(document.querySelectorAll('.manutencao-card'));
    filteredCards = allCards;
    updatePagination();
});

// Filtros em tempo real
document.getElementById('statusFilter').addEventListener('change', filterManutencoes);
document.getElementById('dataFilter').addEventListener('change', filterManutencoes);
document.getElementById('tremFilter').addEventListener('keyup', filterManutencoes);

function filterManutencoes() {
    const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
    const dataFilter = document.getElementById('dataFilter').value;
    const tremFilter = document.getElementById('tremFilter').value.toLowerCase();

    const cards = document.querySelectorAll('.manutencao-card');
    filteredCards = [];

    cards.forEach(card => {
        const status = card.dataset.status.toLowerCase();
        const data = card.dataset.data;
        const trem = card.dataset.trem.toLowerCase();

        const statusMatch = !statusFilter || status === statusFilter;
        const dataMatch = !dataFilter || data === dataFilter;
        const tremMatch = !tremFilter || trem.includes(tremFilter);

        if (statusMatch && dataMatch && tremMatch) {
            card.style.display = '';
            filteredCards.push(card);
        } else {
            card.style.display = 'none';
        }
    });

    currentPage = 1;
    updatePagination();
}

function updatePagination() {
    const totalItems = filteredCards.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    // Esconder todas as cartas primeiro
    filteredCards.forEach(card => card.style.display = 'none');

    // Mostrar apenas as cartas da página atual
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const visibleCards = filteredCards.slice(startIndex, endIndex);

    visibleCards.forEach(card => card.style.display = '');

    // Atualizar controles de paginação
    const paginationText = document.getElementById('paginationText');
    const startItem = startIndex + 1;
    const endItem = Math.min(endIndex, totalItems);
    paginationText.textContent = `Mostrando ${startItem}-${endItem} de ${totalItems} manutenções`;

    const pageInfo = document.getElementById('pageInfo');
    pageInfo.textContent = `Página ${currentPage} de ${totalPages}`;

    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');

    prevBtn.style.display = currentPage > 1 ? '' : 'none';
    nextBtn.style.display = currentPage < totalPages ? '' : 'none';
}

function changePage(direction) {
    const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
    currentPage += direction;

    if (currentPage < 1) currentPage = 1;
    if (currentPage > totalPages) currentPage = totalPages;

    updatePagination();
}

function editarManutencao(id) {
    window.location.href = 'editar_manutencao.php?id=' + id;
}

function deletarManutencao(id) {
    if (confirm('Tem certeza que deseja deletar esta manutenção? Esta ação não pode ser desfeita.')) {
        window.location.href = 'deletar_manutencao.php?id=' + id;
    }
}
</script>

<style>
.status-pendente { background-color: #ffc107; color: #212529; }
.status-em_andamento { background-color: #17a2b8; color: white; }
.status-concluida { background-color: #28a745; color: white; }
.status-cancelada { background-color: #dc3545; color: white; }

.manutencao-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}
</style>
</body>
</html>
