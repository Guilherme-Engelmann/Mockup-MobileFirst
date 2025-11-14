d<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['criar_manutencao'])){
    $id_trem = intval($_POST['id_trem'] ?? 0);
    $tipo = trim($_POST['tipo'] ?? "");
    $descricao = trim($_POST['descricao'] ?? "");
    $data_agendada = trim($_POST['data_agendada'] ?? "");
    $custo = floatval($_POST['custo'] ?? 0);
    $status = trim($_POST['status'] ?? "");

    if($id_trem && $tipo && $descricao && $data_agendada && $custo && $status){
        $stmt = $conn->prepare("INSERT INTO Manutencoes (idTrem, tipoManutencoes, descricaoManutencoes, data_agendada, statusManutencoes, custoManutencoes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssd", $id_trem, $tipo, $descricao, $data_agendada, $status, $custo);
        if($stmt->execute()){
            $msg = "Manutenção cadastrada com sucesso!";
        }else{
            $msg = "Erro ao cadastrar manutenção: " . $conn->error;
        }
        $stmt->close();
    }else{
        $msg = "Preencha todos os campos.";
    }
}

// Buscar trens para dropdown
$trens = [];
$result = $conn->query("SELECT idTrem, numero_serie, modeloTrem FROM Trens ORDER BY numero_serie");
if($result){
    while($row = $result->fetch_assoc()){
        $trens[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Manutenção</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="manutencao.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Cadastrar Manutenção</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Cadastrar Nova Manutenção</h3>
        <?php if($msg): ?><p><?=$msg?></p><?php endif; ?>
        <select name="id_trem" required>
            <option value="">Selecione o Trem</option>
            <?php foreach($trens as $trem): ?>
                <option value="<?=$trem['idTrem']?>"><?=$trem['numero_serie']?> - <?=$trem['modeloTrem']?></option>
            <?php endforeach; ?>
        </select>
        <select name="tipo" required>
            <option value="">Selecione o Tipo</option>
            <option value="preventiva">Preventiva</option>
            <option value="corretiva">Corretiva</option>
            <option value="emergencial">Emergencial</option>
        </select>
        <input type="text" name="descricao" placeholder="Descrição da Manutenção" required>
        <input type="date" name="data_agendada" placeholder="Data Agendada" required>
        <input type="number" step="0.01" name="custo" placeholder="Custo (R$)" required>
        <select name="status" required>
            <option value="">Selecione Status</option>
            <option value="agendada">Agendada</option>
            <option value="em_andamento">Em Andamento</option>
            <option value="concluida">Concluída</option>
            <option value="cancelada">Cancelada</option>
        </select>
        <button type="submit" name="criar_manutencao" value="1">Cadastrar</button>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="manutencao.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
