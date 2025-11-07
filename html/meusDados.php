<?php
session_start();
include 'db.php';

if (isset($conn) && $conn instanceof mysqli && !isset($mysqli)) {
    $mysqli = $conn;
}
if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    $mysqli = new mysqli('localhost', 'root', '', '2025_atividades_guilherme');
    if ($mysqli->connect_errno) {
        die('Erro: conexão com o banco de dados não estabelecida.');
    }
}
include 'api_validators.php';

if (!isset($_SESSION['user_pk'])) {
    header("Location: index.php");
    exit;
}

$user_pk = $_SESSION['user_pk'];
$msg = "";
$user = [
    'email' => '',
    'telefone' => '',
    'cpf' => '',
    'endereco' => '',
    'cep' => ''
];

$stmt = $mysqli->prepare("SELECT email, telefone, cpf, endereco, cep FROM Usuarios WHERE pk = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_pk);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
    $stmt->close();
} else {
    die('Erro ao preparar consulta de dados do usuário: ' . $mysqli->error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cep = $_POST['cep'] ?? '';

    $errors = [];

    if (!validar_telefone($telefone)) {
        $errors[] = "Telefone inválido.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }
    if (!validar_cpf($cpf)) {
        $errors[] = "CPF inválido.";
    }
    if (!validar_endereco($endereco)) {
        $errors[] = "Endereço muito curto.";
    }
    $cep_validation = validar_cep($cep);
    if (!$cep_validation['valid']) {
        $errors[] = $cep_validation['message'];
    }

    if (empty($errors)) {
        $check_stmt = $mysqli->prepare("SELECT pk FROM Usuarios WHERE (email = ? OR cpf = ?) AND pk != ?");
        if ($check_stmt) {
            $check_stmt->bind_param("ssi", $email, $cpf, $user_pk);
            $check_stmt->execute();
            $check_stmt->store_result();
            if ($check_stmt->num_rows > 0) {
                $msg = "E-mail ou CPF já cadastrado em outro usuário.";
            } else {
                $stmt = $mysqli->prepare("UPDATE Usuarios SET telefone = ?, email = ?, cpf = ?, endereco = ?, cep = ? WHERE pk = ?");
                if ($stmt) {
                    $stmt->bind_param("sssssi", $telefone, $email, $cpf, $endereco, $cep, $user_pk);
                    if ($stmt->execute()) {
                        $msg = "Dados atualizados com sucesso!";
                        log_auditoria($mysqli, $user_pk, 'update_dados', 'ok', 'Dados pessoais atualizados');
                        $user['telefone'] = $telefone;
                        $user['email'] = $email;
                        $user['cpf'] = $cpf;
                        $user['endereco'] = $endereco;
                        $user['cep'] = $cep;
                    } else {
                        $msg = "Erro ao atualizar dados.";
                        log_auditoria($mysqli, $user_pk, 'update_dados', 'error', 'Erro ao atualizar dados: ' . $mysqli->error);
                    }
                    $stmt->close();
                } else {
                    $msg = "Erro ao preparar atualização.";
                }
            }
            $check_stmt->close();
        } else {
            $msg = "Erro ao preparar verificação de e-mail/CPF.";
        }
    } else {
        $msg = implode("<br>", $errors);
        log_auditoria($mysqli, $user_pk, 'update_dados', 'error', 'Erros de validação: ' . $msg);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Meus Dados - Mockup Celular</title>
  <link rel="stylesheet" href="../css/meusdados.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="dashboard3.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Meus dados</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h3>Atualize seus dados</h3>
        <?php if($msg): ?> <p><?= $msg ?></p> <?php endif; ?>
        <input type="text" name="telefone" placeholder="Telefone" value="<?= htmlspecialchars($user['telefone'] ?? '') ?>">
        <input type="text" name="email" placeholder="E-mail" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
        <input type="text" name="cpf" placeholder="CPF" value="<?= htmlspecialchars($user['cpf'] ?? '') ?>">
        <input type="text" name="endereco" placeholder="Endereço" value="<?= htmlspecialchars($user['endereco'] ?? '') ?>">
        <input type="text" name="cep" id="cep" placeholder="CEP" value="<?= htmlspecialchars($user['cep'] ?? '') ?>">
        <button type="submit">Salvar</button>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="dashboard3.php">Voltar</a></p>
    </div>
  </div>
  <script>
    document.getElementById('cep').addEventListener('blur', function() {
      var cep = this.value.replace(/\D/g, '');
      if (cep.length === 8) {
        fetch('https://viacep.com.br/ws/' + cep + '/json/')
          .then(response => response.json())
          .then(data => {
            if (!data.erro) {
              document.querySelector('input[name="endereco"]').value = data.logradouro + (data.bairro ? ', ' + data.bairro : '') + (data.localidade ? ' - ' + data.localidade : '') + (data.uf ? '/' + data.uf : '');
            }
          });
      }
    });
  </script>
</body>
</html>