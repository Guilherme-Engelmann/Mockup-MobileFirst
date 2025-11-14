<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['criar_rota'])){
    $origem = intval($_POST['origem'] ?? 0);
    $destino = intval($_POST['destino'] ?? 0);
    $nome = trim($_POST['nome'] ?? "");
    $distancia = floatval($_POST['distancia'] ?? 0);
    $tempo = trim($_POST['tempo'] ?? "");

    if($origem && $destino && $nome && $distancia && $tempo){
        $stmt = $conn->prepare("INSERT INTO Rotas (estacaoDestino, estacaoOrigem, nomeRota, distanciaTotal, tempoMedioPercurso) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisds", $destino, $origem, $nome, $distancia, $tempo);
        if($stmt->execute()){
            $msg = "Rota cadastrada com sucesso!";
        }else{
            $msg = "Erro ao cadastrar rota: " . $conn->error;
        }
        $stmt->close();
    }else{
        $msg = "Preencha todos os campos.";
    }
}

// Buscar estações para dropdown
$estacoes = [];
$result = $conn->query("SELECT idEstacao, nomeEstacao FROM Estacoes");
if($result){
    while($row = $result->fetch_assoc()){
        $estacoes[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Rota</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Cadastrar Rota</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Cadastrar Nova Rota</h3>
        <?php if($msg): ?><p><?=$msg?></p><?php endif; ?>
        <select name="origem" required>
            <option value="">Selecione Estação de Origem</option>
            <?php foreach($estacoes as $estacao): ?>
                <option value="<?=$estacao['idEstacao']?>"><?=$estacao['nomeEstacao']?></option>
            <?php endforeach; ?>
        </select>
        <select name="destino" required>
            <option value="">Selecione Estação de Destino</option>
            <?php foreach($estacoes as $estacao): ?>
                <option value="<?=$estacao['idEstacao']?>"><?=$estacao['nomeEstacao']?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="nome" placeholder="Nome da Rota" required>
        <input type="number" step="any" name="distancia" placeholder="Distância Total (km)" required>
        <input type="time" name="tempo" placeholder="Tempo Médio (HH:MM:SS)" required>
        <button type="submit" name="criar_rota" value="1">Cadastrar</button>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
