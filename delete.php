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

   
    if (empty($idUsuario)) {
        echo "Preencha o ID do usuário!";
    } else {
       
        $sql = "DELETE FROM Usuario WHERE idUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Usuário deletado com sucesso!";
            } else {
                echo "Usuário não encontrado!";
            }
        } else {
            echo "Erro ao deletar usuário: " . $conn->error;
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
    <button type="submit">Deletar Usuário</button>
</form>