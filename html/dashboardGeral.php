<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_pk'])) {
    header("Location: index.php");
    exit;
}

$user_pk = $_SESSION['user_pk'];
$stmt = $mysqli->prepare("SELECT nome, funcao, linha, velocidade, codigo_barra FROM Usuarios WHERE pk = ?");
$stmt->bind_param("i", $user_pk);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mockup Trem</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="phone-content">
      <div class="header">
        <i id="backBtn" class="fas fa-arrow-left back-icon"></i>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Dash Board Geral</h2>
        </div>
      </div>

    <div class="container">
        <div class="mapa">
            <img src="../imagens/mapa-rota.png" alt="Mapa da Linha">
        </div>

        <div class="info">
            <div class="linha">
                <img src="../imagens/controle-linhas.png" alt="Ícone Trem">
                <span><?php echo htmlspecialchars($user['linha']); ?></span>
            </div>
            <div class="velocidade">
                <img src="../imagens/velocimetro.jpg" alt="Ícone Velocidade">
                <span><?php echo htmlspecialchars($user['velocidade']); ?> Km/h</span>
            </div>
        </div>

        <div class="cartao">
            <p class="nome"><?php echo htmlspecialchars($user['nome']); ?><br><span><?php echo htmlspecialchars($user['funcao']); ?></span></p>
            <div class="codigo-barra">
                <img src="../imagens/cracha.png" alt="Código de Barras">
                <p><?php echo htmlspecialchars($user['codigo_barra']); ?></p>
            </div>
        </div>

        <div class="grafico">
            <img src="../imagens/horários-pico.png" alt="Horários de Pico">
        </div>
    </div>
    <script>
    document.getElementById('logoutBtn').addEventListener('click', () => {
      window.location.href = "logout.php";
    });
  </script>
</body>
</html>
