<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || ( $_SESSION["cargo"] !== "admin" && $_SESSION["cargo"] !== "adm" )){
    header("Location: index.php");
    exit;
}

$msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['criar_trem'])){
    $numero_serie = intval($_POST['numero_serie'] ?? 0);
    $modelo = trim($_POST['modelo'] ?? "");
    $data_fab = trim($_POST['data_fab'] ?? "");
    $cap_pass = intval($_POST['cap_pass'] ?? 0);
    $cap_carga = trim($_POST['cap_carga'] ?? "");
    $status = trim($_POST['status'] ?? "");
    $id_rota = intval($_POST['id_rota'] ?? 0);

    if($numero_serie && $modelo && $data_fab && $cap_pass && $cap_carga && $status){
        $stmt = $conn->prepare("INSERT INTO Trens (numero_serie, modeloTrem, data_fabricacao, capacidade_passageiros, capacidade_carga, status_operacional) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississ", $numero_serie, $modelo, $data_fab, $cap_pass, $cap_carga, $status);
        if($stmt->execute()){
            $msg = "Trem cadastrado com sucesso!";
        }else{
            $msg = "Erro ao cadastrar trem: " . $conn->error;
        }
        $stmt->close();
    }else{
        $msg = "Preencha todos os campos.";
    }
}


$rotas = [];
$result = $conn->query("SELECT idRota, nomeRota FROM Rotas ORDER BY nomeRota");
if($result){
    while($row = $result->fetch_assoc()){
        $rotas[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Trem</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Cadastrar Trem</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Cadastrar Novo Trem</h3>
        <?php if($msg): ?><p><?=$msg?></p><?php endif; ?>
        <input type="number" name="numero_serie" placeholder="Número de Série" required>
        <input type="text" name="modelo" placeholder="Modelo do Trem" required>
        <input type="date" name="data_fab" placeholder="Data de Fabricação" required>
        <input type="number" name="cap_pass" placeholder="Capacidade de Passageiros" required>
        <input type="text" name="cap_carga" placeholder="Capacidade de Carga" required>
        <select name="status" required>
            <option value="">Selecione Status Operacional</option>
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
            <option value="manutencao">Em Manutenção</option>
        </select>
        <select name="id_rota">
            <option value="">Selecione Rota (Opcional)</option>
            <?php foreach($rotas as $rota): ?>
                <option value="<?=$rota['idRota']?>"><?=$rota['nomeRota']?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="criar_trem" value="1">Cadastrar</button>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
