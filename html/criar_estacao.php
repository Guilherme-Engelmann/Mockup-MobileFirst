<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['criar_estacao'])){
    $nome = trim($_POST['nome'] ?? "");
    $latitude = trim($_POST['latitude'] ?? "");
    $longitude = trim($_POST['longitude'] ?? "");
    $tipo = trim($_POST['tipo'] ?? "");

    if($nome && $latitude && $longitude && $tipo){
        $stmt = $conn->prepare("INSERT INTO Estacoes (nomeEstacao, latitude, longitude, tipoEstacao) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdds", $nome, $latitude, $longitude, $tipo);
        if($stmt->execute()){
            $msg = "Estação cadastrada com sucesso!";
        }else{
            $msg = "Erro ao cadastrar estação: " . $conn->error;
        }
        $stmt->close();
    }else{
        $msg = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Estação</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Cadastrar Estação</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Cadastrar Nova Estação</h3>
        <?php if($msg): ?><p><?=$msg?></p><?php endif; ?>
        <input type="text" name="nome" placeholder="Nome da Estação" required>
        <input type="number" step="any" name="latitude" placeholder="Latitude" required>
        <input type="number" step="any" name="longitude" placeholder="Longitude" required>
        <select name="tipo" required>
            <option value="">Selecione o Tipo</option>
            <option value="terminal">Terminal</option>
            <option value="intermediaria">Intermediária</option>
            <option value="final">Final</option>
        </select>
        <button type="submit" name="criar_estacao" value="1">Cadastrar</button>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
