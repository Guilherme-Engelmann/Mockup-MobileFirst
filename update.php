<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ferrovia";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUsuario = $_POST['idUsuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipoUsuario = $_POST['tipoUsuario'];
    $idPerfil = $_POST['idPerfil'];

   
    if (empty($idUsuario) || empty($nome) || empty($email)) {
        echo "Preencha todos os campos obrigatórios!";
    } else {
       
        $sql = "UPDATE Usuario SET nome = ?, email = ?, tipoUsuario = ?, idPerfil = ? WHERE idUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $nome, $email, $tipoUsuario, $idPerfil, $idUsuario);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Usuário atualizado com sucesso!";
            } else {
                echo "Usuário não encontrado ou nenhum dado alterado!";
            }
        } else {
            echo "Erro ao atualizar usuário: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>


<form method="POST">
    <label>ID do Usuário:</label>
    <input type="number" name="idUsuario" required>
    <br>
    <label>Nome:</label>
    <input type="text" name="nome" required>
    <br>
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Tipo de Usuário:</label>
    <input type="text" name="tipoUsuario">
    <br>
    <label>ID do Perfil:</label>
    <input type="number" name="idPerfil">
    <br>
    <button type="submit">Atualizar Usuário</button>
</form>