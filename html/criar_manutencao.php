d<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || $_SESSION["cargo"] !== "admin"){
    header("Location: index.php");
    exit;
}

$msg = "";
$msg_type = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['criar_manutencao'])){
    $id_trem = intval($_POST['id_trem'] ?? 0);
    $tipo = trim($_POST['tipo'] ?? "");
    $descricao = trim($_POST['descricao'] ?? "");
    $data_agendada = trim($_POST['data_agendada'] ?? "");
    $custo = floatval($_POST['custo'] ?? 0);
    $status = trim($_POST['status'] ?? "");

    if($id_trem && $tipo && $descricao && $data_agendada && $custo >= 0 && $status){
        // Validar data - não permitir datas passadas
        $data_agendada_obj = new DateTime($data_agendada);
        $hoje = new DateTime();
        $hoje->setTime(0, 0, 0); // Zerar horário para comparar apenas datas

        if($data_agendada_obj < $hoje){
            $msg = "A data agendada não pode ser no passado.";
            $msg_type = "error";
        }else{
            $stmt = $conn->prepare("INSERT INTO Manutencoes (idTrem, tipoManutencoes, descricaoManutencoes, data_agendada, statusManutencoes, custoManutencoes) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssd", $id_trem, $tipo, $descricao, $data_agendada, $status, $custo);
            if($stmt->execute()){
                $msg = "Manutenção cadastrada com sucesso!";
                $msg_type = "success";
            }else{
                $msg = "Erro ao cadastrar manutenção: " . $conn->error;
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
      <form method="post" style="width:100%;max-width:500px;margin:0 auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h3>Cadastrar Nova Manutenção</h3>
        <?php if($msg): ?><p class="message <?=$msg_type?>" style="padding: 10px; margin: 10px 0; border-radius: 5px; <?=$msg_type=='success'?'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;':'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'?>"><?=$msg?></p><?php endif; ?>
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
        <input type="date" name="data_agendada" placeholder="Data Agendada" required min="<?=date('Y-m-d')?>">
        <input type="number" step="0.01" name="custo" placeholder="Custo (R$)" required>
        <select name="status" required>
            <option value="">Selecione Status</option>
            <option value="agendada">Agendada</option>
            <option value="em_andamento">Em Andamento</option>
            <option value="concluida">Concluída</option>
            <option value="cancelada">Cancelada</option>
        </select>
        <div class="form-buttons">
          <button type="submit" name="criar_manutencao" value="1">Cadastrar</button>
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
