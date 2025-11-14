<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/dashboard3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>Dashboard Admin</title>
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="index.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Dashboard Admin</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <div class="app-grid">
        <div class="app-item">
          <img src="../imagens/rota.png" alt="Cadastrar Rotas">
          <a href="criar_rota.php">Cadastrar Rota</a>
        </div>
        <div class="app-item">
          <img src="../imagens/rota.png" alt="Listar Rotas">
          <a href="listar_rotas.php">Listar Rotas</a>
        </div>
        <div class="app-item">
          <img src="../imagens/trem.jpg" alt="Cadastrar Trens">
          <a href="criar_trem.php">Cadastrar Trem</a>
        </div>
        <div class="app-item">
          <img src="../imagens/trem.jpg" alt="Listar Trens">
          <a href="listar_trens.php">Listar Trens</a>
        </div>
        <div class="app-item">
          <img src="../imagens/mapa-rota.png" alt="Cadastrar Estações">
          <a href="criar_estacao.php">Cadastrar Estação</a>
        </div>
        <div class="app-item">
          <img src="../imagens/mapa-rota.png" alt="Listar Estações">
          <a href="listar_estacoes.php">Listar Estações</a>
        </div>
        <div class="app-item">
          <img src="../imagens/meusdados_logo.png" alt="Cadastrar Usuários">
          <a href="cadastro.php">Cadastrar Usuário</a>
        </div>
        <div class="app-item">
          <img src="../imagens/manutenção.jpg" alt="Manutenções">
          <a href="manutencao.php">Manutenções</a>
        </div>
        <div class="app-item">
          <img src="../imagens/dashboard.png" alt="Relatórios">
          <a href="relatorios.php">Relatórios</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
