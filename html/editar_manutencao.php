<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
$manutencao = null;

if($id){
    $stmt = $conn->prepare("SELECT * FROM Manutencoes WHERE idManutencoes = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $manutencao = $result->fetch_assoc();
    $stmt->close();
}

if(!$manutencao){
    header("Location: manutencao.php");
    exit;
}

$msg = "";
$msg_type = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar_manutencao'])){
    $id_trem = intval($_POST['id_trem'] ?? 0);
    $tipo = trim($_POST['tipo'] ?? "");
    $descricao = trim($_POST['descricao'] ?? "");
    $data_agendada = trim($_POST['data_agendada'] ?? "");
    $data_conclusao = trim($_POST['data_conclusao'] ?? "");
    $custo = floatval($_POST['custo'] ?? 0);
    $status = trim($_POST['status'] ?? "");

    if($id_trem && $tipo && $descricao && $data_agendada && $custo >= 0 && $status){
        // Validar data - não permitir datas passadas
        $data_agendada_obj = new DateTime($data_agendada);
        $hoje = new DateTime();
        $hoje->setTime(0, 0, 0);

        if($data_agendada_obj < $hoje){
            $msg = "A data agendada não pode ser no passado.";
            $msg_type = "error";
        }else{
            $stmt = $conn->prepare("UPDATE Manutencoes SET idTrem = ?, tipoManutencoes = ?, descricaoManutencoes = ?, data_agendada = ?, data_conclusao = ?, statusManutencoes = ?, custoManutencoes = ? WHERE idManutencoes = ?");
            $stmt->bind_param("isssssdi", $id_trem, $tipo, $descricao, $data_agendada, $data_conclusao, $status, $custo, $id);
            if($stmt->execute()){
                $msg = "Manutenção atualizada com sucesso!";
                $msg_type = "success";
                // Recarregar dados
                $stmt = $conn->prepare("SELECT * FROM Manutencoes WHERE idManutencoes = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $manutencao = $result->fetch_assoc();
                $stmt->close();
            }else{
                $msg = "Erro ao atualizar manutenção: " . $conn->error;
                $msg_type = "error";
            }
            $stmt->close();
        }
    }else{
        $msg = "Preencha todos os campos corretamente.";
        $msg_type = "error";
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
    <title>Editar Manutenção</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="manutencao.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Editar Manutenção</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Editar Manutenção</h3>
        <?php if($msg): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>
        <select name="id_trem" required>
            <option value="">Selecione o Trem</option>
            <?php foreach($trens as $trem): ?>
                <option value="<?=$trem['idTrem']?>" <?=$trem['idTrem'] == $manutencao['idTrem'] ? 'selected' : ''?>><?=$trem['numero_serie']?> - <?=$trem['modeloTrem']?></option>
            <?php endforeach; ?>
        </select>
        <select name="tipo" required>
            <option value="">Selecione o Tipo</option>
            <option value="preventiva" <?=$manutencao['tipoManutencoes'] == 'preventiva' ? 'selected' : ''?>>Preventiva</option>
            <option value="corretiva" <?=$manutencao['tipoManutencoes'] == 'corretiva' ? 'selected' : ''?>>Corretiva</option>
            <option value="emergencial" <?=$manutencao['tipoManutencoes'] == 'emergencial' ? 'selected' : ''?>>Emergencial</option>
        </select>
        <input type="text" name="descricao" placeholder="Descrição da Manutenção" value="<?=$manutencao['descricaoManutencoes']?>" required>
        <input type="date" name="data_agendada" value="<?=$manutencao['data_agendada']?>" required>
        <input type="date" name="data_conclusao" value="<?=$manutencao['data_conclusao'] ?? ''?>">
        <input type="number" step="0.01" name="custo" placeholder="Custo (R$)" value="<?=$manutencao['custoManutencoes']?>" required>
        <select name="status" required>
            <option value="">Selecione Status</option>
            <option value="agendada" <?=$manutencao['statusManutencoes'] == 'agendada' ? 'selected' : ''?>>Agendada</option>
            <option value="em_andamento" <?=$manutencao['statusManutencoes'] == 'em_andamento' ? 'selected' : ''?>>Em Andamento</option>
            <option value="concluida" <?=$manutencao['statusManutencoes'] == 'concluida' ? 'selected' : ''?>>Concluída</option>
            <option value="cancelada" <?=$manutencao['statusManutencoes'] == 'cancelada' ? 'selected' : ''?>>Cancelada</option>
        </select>
        <div class="form-buttons">
          <button type="submit" name="editar_manutencao" value="1">Atualizar</button>
          <button type="button" onclick="limparFormulario()">Limpar</button>
        </div>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="manutencao.php">Voltar</a></p>
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
