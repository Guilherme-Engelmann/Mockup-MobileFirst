<?php
session_start();
include 'db.php';
include 'api_validators.php';

if (!isset($_SESSION['user_pk'])) {
    header("Location: index.php");
    exit;
}

$user_pk = $_SESSION['user_pk'];
$msg = "";

// Fetch current user data
$stmt = $conn->prepare("SELECT nome, email, telefone, cpf, endereco, cep FROM Usuarios WHERE pk = ?");
$stmt->bind_param("i", $user_pk);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cep = $_POST['cep'] ?? '';

    $errors = [];

    // Validate telefone
    if (!validar_telefone($telefone)) {
        $errors[] = "Telefone inválido.";
    }

    // Validate email (basic)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }

    // Validate CPF
    if (!validar_cpf($cpf)) {
        $errors[] = "CPF inválido.";
    }

    // Validate endereco
    if (!validar_endereco($endereco)) {
        $errors[] = "Endereço muito curto.";
    }

    // Validate CEP
    $cep_validation = validar_cep($cep);
    if (!$cep_validation['valid']) {
        $errors[] = $cep_validation['message'];
    }

    if (empty($errors)) {
        // Update database
        $stmt = $conn->prepare("UPDATE Usuarios SET telefone = ?, email = ?, cpf = ?, endereco = ?, cep = ? WHERE pk = ?");
        $stmt->bind_param("sssssi", $telefone, $email, $cpf, $endereco, $cep, $user_pk);
        if ($stmt->execute()) {
            $msg = "Dados atualizados com sucesso!";
            log_auditoria($conn, $user_pk, 'update_dados', 'ok', 'Dados pessoais atualizados');
            // Refresh user data
            $user['telefone'] = $telefone;
            $user['email'] = $email;
            $user['cpf'] = $cpf;
            $user['endereco'] = $endereco;
            $user['cep'] = $cep;
        } else {
            $msg = "Erro ao atualizar dados.";
            log_auditoria($conn, $user_pk, 'update_dados', 'error', 'Erro ao atualizar dados: ' . $conn->error);
        }
        $stmt->close();
    } else {
        $msg = implode("<br>", $errors);
        log_auditoria($conn, $user_pk, 'update_dados', 'error', 'Erros de validação: ' . $msg);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Meus Dados - Mockup Celular</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="phone-content">
      <div class="header">
        <a href="dashboard3.php"><i class="fas fa-arrow-left back-icon"></i></a>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Meus dados</h2>
        </div>
      </div>

      <div class="content">
        <div class="tabs">
          <a href="#">Informações gerais</a>
        </div>

        <?php if ($msg): ?>
            <div class="message" style="color: red; margin-bottom: 10px;"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="contact-card">
            <div class="icon">
              <i class="fas fa-id-card"></i>
            </div>
            <div class="input-group">
              <label for="telefone">Telefone</label>
              <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($user['telefone'] ?? ''); ?>" placeholder="Digite seu telefone" required />
            </div>
            <div class="input-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" placeholder="Digite seu email" required />
            </div>
            <div class="input-group">
              <label for="cpf">CPF</label>
              <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($user['cpf'] ?? ''); ?>" placeholder="Digite seu CPF" required />
            </div>
            <div class="input-group">
              <label for="endereco">Endereço</label>
              <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($user['endereco'] ?? ''); ?>" placeholder="Digite seu Endereço" required />
            </div>
            <div class="input-group">
              <label for="cep">CEP</label>
              <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($user['cep'] ?? ''); ?>" placeholder="Digite seu CEP" required />
            </div>
            <button type="submit" style="margin-top: 20px; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Salvar</button>
          </div>
        </form>
      </div>
    </div>

   <script>
    document.getElementById('backBtn').addEventListener('click', () => {
      window.location.href = "dashboard3.php";
    });
  </script>
</body>
</html>