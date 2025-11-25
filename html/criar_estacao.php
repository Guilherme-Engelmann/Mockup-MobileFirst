<?php
include "db.php";
session_start();

if(empty($_SESSION["user_pk"]) || ( $_SESSION["cargo"] !== "admin" && $_SESSION["cargo"] !== "adm" )){
    header("Location: index.php");
    exit;
}

$msg = "";
$msg_type = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['criar_estacao'])){
    $nome = trim($_POST['nome'] ?? "");
    $tipo = trim($_POST['tipo'] ?? "");

    if($nome && $tipo){
        // Verificar se estação já existe
        $check_stmt = $conn->prepare("SELECT idEstacao FROM Estacoes WHERE nomeEstacao = ?");
        $check_stmt->bind_param("s", $nome);
        $check_stmt->execute();
        $check_stmt->store_result();
        if($check_stmt->num_rows > 0){
            $msg = "Já existe uma estação cadastrada com este nome.";
            $msg_type = "error";
        }else{
            $stmt = $conn->prepare("INSERT INTO Estacoes (nomeEstacao, tipoEstacao) VALUES (?, ?)");
            $stmt->bind_param("ss", $nome, $tipo);
            if($stmt->execute()){
                $msg = "Estação cadastrada com sucesso!";
                $msg_type = "success";
            }else{
                $msg = "Erro ao cadastrar estação: " . $conn->error;
                $msg_type = "error";
            }
            $stmt->close();
        }
        $check_stmt->close();
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
        <?php if($msg): ?><p class="message <?=$msg_type?>"><?=$msg?></p><?php endif; ?>
        <input type="text" name="nome" placeholder="Nome da Estação" required>
        <select name="tipo" required>
            <option value="">Selecione o Tipo</option>
            <option value="terminal">Terminal</option>
            <option value="intermediaria">Intermediária</option>
            <option value="final">Final</option>
        </select>
        <div class="form-buttons">
          <button type="submit" name="criar_estacao" value="1">Cadastrar</button>
          <button type="button" onclick="limparFormulario()">Limpar</button>
        </div>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="admin_dashboard.php">Voltar</a></p>
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
