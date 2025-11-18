<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$msg = "";
$msg_type = "";
$id_rota = intval($_GET['id'] ?? 0);

if(!$id_rota){
    header("Location: listar_rotas.php");
    exit;
}

// Buscar dados da rota
$rota = null;
$result = $conn->query("SELECT * FROM Rotas WHERE idRota = $id_rota");
if($result && $result->num_rows > 0){
    $rota = $result->fetch_assoc();
    $result->free();
}else{
    header("Location: listar_rotas.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar_rota'])){
    $origem = intval($_POST['origem'] ?? 0);
    $destino = intval($_POST['destino'] ?? 0);
    $nome = trim($_POST['nome'] ?? "");
    $distancia = floatval($_POST['distancia'] ?? 0);
    $tempo = trim($_POST['tempo'] ?? "");

    if($origem && $destino && $nome && $distancia && $tempo){
        if($origem === $destino){
            $msg = "A estação de origem deve ser diferente da estação de destino.";
            $msg_type = "error";
        }else{
            // Verificar se rota já existe (exceto a atual)
            $check_stmt = $conn->prepare("SELECT idRota FROM Rotas WHERE estacaoOrigem = ? AND estacaoDestino = ? AND idRota != ?");
            $check_stmt->bind_param("iii", $origem, $destino, $id_rota);
            $check_stmt->execute();
            $check_stmt->store_result();
            if($check_stmt->num_rows > 0){
                $msg = "Já existe uma rota cadastrada entre essas estações.";
                $msg_type = "error";
            }else{
                $stmt = $conn->prepare("UPDATE Rotas SET estacaoDestino = ?, estacaoOrigem = ?, nomeRota = ?, distanciaTotal = ?, tempoMedioPercurso = ? WHERE idRota = ?");
                $stmt->bind_param("iisdsi", $destino, $origem, $nome, $distancia, $tempo, $id_rota);
                if($stmt->execute()){
                    $msg = "Rota atualizada com sucesso!";
                    $msg_type = "success";
                    // Recarregar dados
                    $result = $conn->query("SELECT * FROM Rotas WHERE idRota = $id_rota");
                    if($result && $result->num_rows > 0){
                        $rota = $result->fetch_assoc();
                        $result->free();
                    }
                }else{
                    $msg = "Erro ao atualizar rota: " . $conn->error;
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
    <title>Editar Rota</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="listar_rotas.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Editar Rota</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Editar Rota</h3>
        <?php if($msg): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>
        <select name="origem" required>
            <option value="">Selecione Estação de Origem</option>
            <?php foreach($estacoes as $estacao): ?>
                <option value="<?=$estacao['idEstacao']?>" <?=$rota['estacaoOrigem'] == $estacao['idEstacao'] ? 'selected' : ''?>><?=$estacao['nomeEstacao']?></option>
            <?php endforeach; ?>
        </select>
        <select name="destino" required>
            <option value="">Selecione Estação de Destino</option>
            <?php foreach($estacoes as $estacao): ?>
                <option value="<?=$estacao['idEstacao']?>" <?=$rota['estacaoDestino'] == $estacao['idEstacao'] ? 'selected' : ''?>><?=$estacao['nomeEstacao']?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="nome" placeholder="Nome da Rota" value="<?=$rota['nomeRota']?>" required>
        <input type="number" step="any" name="distancia" placeholder="Distância Total (km)" value="<?=$rota['distanciaTotal']?>" required>
        <input type="time" name="tempo" placeholder="Tempo Médio (HH:MM:SS)" value="<?=$rota['tempoMedioPercurso']?>" required>
        <div class="form-buttons">
          <button type="submit" name="editar_rota" value="1">Atualizar</button>
          <button type="button" onclick="limparFormulario()">Limpar</button>
        </div>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="listar_rotas.php">Voltar</a></p>
    </div>
  </div>
<script>
function limparFormulario() {
    document.querySelector('form').reset();
    // Limpar mensagens de erro/sucesso
    const messages = document.querySelectorAll('.message');
    messages.forEach(msg => msg.remove());
}
</script>
</body>
</html>
