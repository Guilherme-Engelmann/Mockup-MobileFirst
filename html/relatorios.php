<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

// Estatísticas gerais
$stats = [];

// Total de rotas
$result = $conn->query("SELECT COUNT(*) as total FROM Rotas");
$stats['rotas'] = $result->fetch_assoc()['total'];

// Total de trens
$result = $conn->query("SELECT COUNT(*) as total FROM Trens");
$stats['trens'] = $result->fetch_assoc()['total'];

// Total de estações
$result = $conn->query("SELECT COUNT(*) as total FROM Estacoes");
$stats['estacoes'] = $result->fetch_assoc()['total'];

// Total de viagens
$result = $conn->query("SELECT COUNT(*) as total FROM Viagens");
$stats['viagens'] = $result->fetch_assoc()['total'];

// Alertas pendentes
$result = $conn->query("SELECT COUNT(*) as total FROM Alertas WHERE statusResolucao = 'pendente'");
$stats['alertas_pendentes'] = $result->fetch_assoc()['total'];

// Manutenções em andamento
$result = $conn->query("SELECT COUNT(*) as total FROM Manutencoes WHERE statusManutencoes = 'em_andamento'");
$stats['manutencoes_andamento'] = $result->fetch_assoc()['total'];

// Usuários ativos
$result = $conn->query("SELECT COUNT(*) as total FROM Usuarios WHERE cargo IN ('admin', 'func')");
$stats['usuarios'] = $result->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link rel="stylesheet" href="../css/dashboard3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Relatórios do Sistema</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <h3>Estatísticas Gerais</h3>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; text-align: center;">
          <h4><?=$stats['rotas']?></h4>
          <p>Rotas Cadastradas</p>
        </div>
        <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; text-align: center;">
          <h4><?=$stats['trens']?></h4>
          <p>Trens Cadastrados</p>
        </div>
        <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; text-align: center;">
          <h4><?=$stats['estacoes']?></h4>
          <p>Estações Cadastradas</p>
        </div>
        <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; text-align: center;">
          <h4><?=$stats['viagens']?></h4>
          <p>Viagens Programadas</p>
        </div>
        <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; text-align: center;">
          <h4><?=$stats['alertas_pendentes']?></h4>
          <p>Alertas Pendentes</p>
        </div>
        <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; text-align: center;">
          <h4><?=$stats['manutencoes_andamento']?></h4>
          <p>Manutenções em Andamento</p>
        </div>
        <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; text-align: center;">
          <h4><?=$stats['usuarios']?></h4>
          <p>Usuários Ativos</p>
        </div>
      </div>

      <h3>Relatórios Detalhados</h3>
      <div class="app-grid">
        <div class="app-item">
          <img src="../imagens/dashboard.png" alt="Relatório de Viagens">
          <a href="#viagens">Relatório de Viagens</a>
        </div>
        <div class="app-item">
          <img src="../imagens/manutenção.jpg" alt="Relatório de Manutenções">
          <a href="#manutencoes">Relatório de Manutenções</a>
        </div>
        <div class="app-item">
          <img src="../imagens/notificação.avif" alt="Relatório de Alertas">
          <a href="#alertas">Relatório de Alertas</a>
        </div>
      </div>

      <div id="viagens" style="margin-top: 30px;">
        <h4>Viagens Recentes</h4>
        <?php
        $viagens = [];
        $result = $conn->query("SELECT v.*, r.nomeRota, t.numero_serie FROM Viagens v JOIN Rotas r ON v.idRota = r.idRota JOIN Trens t ON v.idTrem = t.idTrem ORDER BY v.horario_partida_previsto DESC LIMIT 10");
        if($result){
            while($row = $result->fetch_assoc()){
                $viagens[] = $row;
            }
            $result->free();
        }
        if(empty($viagens)){
            echo "<p>Nenhuma viagem encontrada.</p>";
        }else{
            echo "<ul style='list-style: none; padding: 0;'>";
            foreach($viagens as $viagem){
                echo "<li style='border: 1px solid #ccc; margin: 10px 0; padding: 10px; border-radius: 5px;'>";
                echo "<strong>Rota: {$viagem['nomeRota']}</strong><br>";
                echo "Trem: {$viagem['numero_serie']}<br>";
                echo "Saída: {$viagem['horario_partida_previsto']} | Chegada: {$viagem['horario_chegada_previsto']}<br>";
                echo "Status: {$viagem['statusViagens']}";
                echo "</li>";
            }
            echo "</ul>";
        }
        ?>
      </div>

      <div id="manutencoes" style="margin-top: 30px;">
        <h4>Manutenções Recentes</h4>
        <?php
        $manutencoes = [];
        $result = $conn->query("SELECT m.*, t.numero_serie FROM Manutencoes m JOIN Trens t ON m.idTrem = t.idTrem ORDER BY m.data_agendada DESC LIMIT 10");
        if($result){
            while($row = $result->fetch_assoc()){
                $manutencoes[] = $row;
            }
            $result->free();
        }
        if(empty($manutencoes)){
            echo "<p>Nenhuma manutenção encontrada.</p>";
        }else{
            echo "<ul style='list-style: none; padding: 0;'>";
            foreach($manutencoes as $manutencao){
                echo "<li style='border: 1px solid #ccc; margin: 10px 0; padding: 10px; border-radius: 5px;'>";
                echo "<strong>Trem: {$manutencao['numero_serie']}</strong><br>";
                echo "Tipo: {$manutencao['tipoManutencoes']}<br>";
                echo "Data: {$manutencao['data_agendada']}<br>";
                echo "Status: {$manutencao['statusManutencoes']} | Custo: R$ {$manutencao['custoManutencoes']}";
                echo "</li>";
            }
            echo "</ul>";
        }
        ?>
      </div>

      <div id="alertas" style="margin-top: 30px;">
        <h4>Alertas Recentes</h4>
        <?php
        $alertas = [];
        $result = $conn->query("SELECT a.*, r.nomeRota FROM Alertas a JOIN Viagens v ON a.idViagem = v.idViagem JOIN Rotas r ON v.idRota = r.idRota ORDER BY a.tempoAlerta DESC LIMIT 10");
        if($result){
            while($row = $result->fetch_assoc()){
                $alertas[] = $row;
            }
            $result->free();
        }
        if(empty($alertas)){
            echo "<p>Nenhum alerta encontrado.</p>";
        }else{
            echo "<ul style='list-style: none; padding: 0;'>";
            foreach($alertas as $alerta){
                echo "<li style='border: 1px solid #ccc; margin: 10px 0; padding: 10px; border-radius: 5px;'>";
                echo "<strong>{$alerta['tipoAlerta']} - {$alerta['severidadeAlerta']}</strong><br>";
                echo "Rota: {$alerta['nomeRota']}<br>";
                echo "Descrição: {$alerta['descricaoAlerta']}<br>";
                echo "Status: {$alerta['statusResolucao']} | {$alerta['tempoAlerta']}";
                echo "</li>";
            }
            echo "</ul>";
        }
        ?>
      </div>

      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
