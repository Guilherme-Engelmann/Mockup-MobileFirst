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


$result = $conn->query("SELECT * FROM Estacoes WHERE idEstacao = $id_estacao");
if(!$result || $result->num_rows === 0){
    header("Location: listar_estacoes.php");
    exit;
}
$estacao = $result->fetch_assoc();
$result->free();

$msg = "";
$msg_type = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar_estacao'])){
    $nome = trim($_POST['nome'] ?? "");
    $latitude = trim($_POST['latitude'] ?? "");
    $longitude = trim($_POST['longitude'] ?? "");
    $tipo = trim($_POST['tipo'] ?? "");

    if($nome && $latitude && $longitude && $tipo){
        
        if(!is_numeric($latitude) || $latitude < -90 || $latitude > 90){
            $msg = "Latitude deve estar entre -90 e 90 graus.";
            $msg_type = "error";
        }elseif(!is_numeric($longitude) || $longitude < -180 || $longitude > 180){
            $msg = "Longitude deve estar entre -180 e 180 graus.";
            $msg_type = "error";
        }else{
           
            $check_stmt = $conn->prepare("SELECT idEstacao FROM Estacoes WHERE nomeEstacao = ? AND idEstacao != ?");
            $check_stmt->bind_param("si", $nome, $id_estacao);
            $check_stmt->execute();
            $check_stmt->store_result();
            if($check_stmt->num_rows > 0){
                $msg = "Já existe uma estação cadastrada com este nome.";
                $msg_type = "error";
            }else{
                $stmt = $conn->prepare("UPDATE Estacoes SET nomeEstacao = ?, latitude = ?, longitude = ?, tipoEstacao = ? WHERE idEstacao = ?");
                $stmt->bind_param("sddsi", $nome, $latitude, $longitude, $tipo, $id_estacao);
                if($stmt->execute()){
                    header("Location: listar_estacoes.php?msg=estacao_editada");
                    exit;
                }else{
                    $msg = "Erro ao editar estação: " . $conn->error;
                    $msg_type = "error";
                }
                $stmt->close();
            }
            $check_stmt->close();
        }
    }else{
        $msg = "Preencha todos os campos.";
        $msg_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estação</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="listar_estacoes.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-edit header-icon"></i>
        <h2>Editar Estação</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Editar Estação</h3>
        <?php if($msg): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>
        <input type="text" name="nome" placeholder="Nome da Estação" value="<?=$estacao['nomeEstacao']?>" required>
        <input type="number" step="any" name="latitude" placeholder="Latitude" value="<?=$estacao['latitude']?>" required>
        <input type="number" step="any" name="longitude" placeholder="Longitude" value="<?=$estacao['longitude']?>" required>
        <select name="tipo" required>
            <option value="">Selecione o Tipo</option>
            <option value="terminal" <?=$estacao['tipoEstacao'] === 'terminal' ? 'selected' : ''?>>Terminal</option>
            <option value="intermediaria" <?=$estacao['tipoEstacao'] === 'intermediaria' ? 'selected' : ''?>>Intermediária</option>
            <option value="final" <?=$estacao['tipoEstacao'] === 'final' ? 'selected' : ''?>>Final</option>
        </select>
        <div class="form-buttons">
          <button type="submit" name="editar_estacao" value="1">Salvar Alterações</button>
          <button type="button" onclick="limparFormulario()">Limpar</button>
        </div>
      </form>
    </div>
  </div>
<script>
function limparFormulario() {
    document.querySelector('form').reset();
    
    const messages = document.querySelectorAll('.message');
    messages.forEach(msg => msg.remove());
}
</script>
</body>
</html>
