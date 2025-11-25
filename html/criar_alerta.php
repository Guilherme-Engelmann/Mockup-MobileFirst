<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || ($_SESSION["cargo"] !== "admin" && $_SESSION["cargo"] !== "adm")){
    header("Location: index.php");
    exit;
}

$msg = "";
$msg_type = "";

// Buscar trens e rotas para dropdown
$trens = [];
$rotas = [];
$resTrens = $conn->query("SELECT idTrem, numero_serie FROM Trens ORDER BY numero_serie");
if($resTrens){
    while($row = $resTrens->fetch_assoc()){
        $trens[] = $row;
    }
    $resTrens->free();
}
$resRotas = $conn->query("SELECT idRota, nomeRota FROM Rotas ORDER BY nomeRota");
if($resRotas){
    while($row = $resRotas->fetch_assoc()){
        $rotas[] = $row;
    }
    $resRotas->free();
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['criar_alerta'])){
    $idTrem = intval($_POST['idTrem'] ?? 0);
    $idRota = intval($_POST['idRota'] ?? 0);
    $tipoAlerta = trim($_POST['tipoAlerta'] ?? "");
    $severidadeAlerta = trim($_POST['severidadeAlerta'] ?? "");
    $descricaoAlerta = trim($_POST['descricaoAlerta'] ?? "");
    $statusResolucao = trim($_POST['statusResolucao'] ?? "pendente");
    $tempoAlerta = date('Y-m-d H:i:s');

    if($idTrem && $idRota && $tipoAlerta && $severidadeAlerta && $descricaoAlerta){
        // Buscar uma viagem correspondente (opcional, se existir)
        $idViagem = 0;
        $resViagem = $conn->query("SELECT idViagem FROM Viagens WHERE idTrem = $idTrem AND idRota = $idRota ORDER BY idViagem DESC LIMIT 1");
        if($resViagem && $row = $resViagem->fetch_assoc()){
            $idViagem = $row['idViagem'];
        }
        if($idViagem){
            $stmt = $conn->prepare("INSERT INTO Alertas (idViagem, tipoAlerta, severidadeAlerta, descricaoAlerta, statusResolucao, tempoAlerta) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $idViagem, $tipoAlerta, $severidadeAlerta, $descricaoAlerta, $statusResolucao, $tempoAlerta);
        } else {
            // Se não houver viagem, insere com idViagem nulo
            $stmt = $conn->prepare("INSERT INTO Alertas (idViagem, tipoAlerta, severidadeAlerta, descricaoAlerta, statusResolucao, tempoAlerta) VALUES (NULL, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $tipoAlerta, $severidadeAlerta, $descricaoAlerta, $statusResolucao, $tempoAlerta);
        }
        if($stmt->execute()){
            $msg = "Alerta cadastrado com sucesso!";
            $msg_type = "success";
        }else{
            $msg = "Erro ao cadastrar alerta: " . $conn->error;
            $msg_type = "error";
        }
        $stmt->close();
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
    <title>Cadastrar Alerta/Notificação</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="alertas.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-bell header-icon"></i>
        <h2>Cadastrar Alerta/Notificação</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Novo Alerta/Notificação</h3>
        <?php if($msg): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>
        <label for="idTrem">Trem:</label>
        <select name="idTrem" id="idTrem" required>
            <option value="">Selecione o Trem</option>
            <?php foreach($trens as $trem): ?>
                <option value="<?=$trem['idTrem']?>">Série <?=$trem['numero_serie']?></option>
            <?php endforeach; ?>
        </select>
        <label for="idRota">Rota:</label>
        <select name="idRota" id="idRota" required>
            <option value="">Selecione a Rota</option>
            <?php foreach($rotas as $rota): ?>
                <option value="<?=$rota['idRota']?>"><?=$rota['nomeRota']?></option>
            <?php endforeach; ?>
        </select>
        <label for="tipoAlerta">Tipo de Alerta:</label>
        <input type="text" name="tipoAlerta" id="tipoAlerta" required placeholder="Ex: Falha, Atraso, etc">
        <label for="severidadeAlerta">Severidade:</label>
        <select name="severidadeAlerta" id="severidadeAlerta" required>
            <option value="">Selecione</option>
            <option value="baixa">Baixa</option>
            <option value="media">Média</option>
            <option value="alta">Alta</option>
        </select>
        <label for="descricaoAlerta">Descrição:</label>
        <textarea name="descricaoAlerta" id="descricaoAlerta" required placeholder="Descreva o alerta/notificação"></textarea>
        <div class="form-buttons">
          <button type="submit" name="criar_alerta" value="1">Cadastrar</button>
          <button type="button" onclick="limparFormulario()">Limpar</button>
        </div>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="alertas.php">Voltar</a></p>
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
