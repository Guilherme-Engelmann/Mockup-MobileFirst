<?php
include "db.php";


echo "=== TESTE DO SISTEMA ===\n\n";


if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
echo "✅ Conexão com banco OK\n";


$stmt = $conn->prepare("INSERT INTO Estacoes (nomeEstacao, latitude, longitude, tipoEstacao) VALUES (?, ?, ?, ?)");
$nome = "Estação Teste";
$lat = -26.304408;
$lng = -48.848022;
$tipo = "terminal";
$stmt->bind_param("sdds", $nome, $lat, $lng, $tipo);
if ($stmt->execute()) {
    echo "✅ Inserção de estação OK\n";
    $estacao_id = $conn->insert_id;
} else {
    echo "❌ Erro na inserção de estação: " . $conn->error . "\n";
    exit;
}
$stmt->close();


$stmt = $conn->prepare("INSERT INTO Trens (numero_serie, modeloTrem, data_fabricacao, capacidade_passageiros, capacidade_carga, status_operacional) VALUES (?, ?, ?, ?, ?, ?)");
$serie = 999;
$modelo = "Trem Teste";
$data = "2023-01-01";
$cap_pass = 100;
$cap_carga = "50t";
$status = "ativo";
$stmt->bind_param("ississ", $serie, $modelo, $data, $cap_pass, $cap_carga, $status);
if ($stmt->execute()) {
    echo "✅ Inserção de trem OK\n";
    $trem_id = $conn->insert_id;
} else {
    echo "❌ Erro na inserção de trem: " . $conn->error . "\n";
}
$stmt->close();


$stmt = $conn->prepare("INSERT INTO Rotas (estacaoOrigem, estacaoDestino, nomeRota, distanciaTotal, tempoMedioPercurso) VALUES (?, ?, ?, ?, ?)");
$origem = $estacao_id;
$destino = $estacao_id; 
$nome_rota = "Rota Teste";
$dist = 10.5;
$tempo = "00:30:00";
$stmt->bind_param("iisds", $origem, $destino, $nome_rota, $dist, $tempo);
if ($stmt->execute()) {
    echo "✅ Inserção de rota OK\n";
} else {
    echo "❌ Erro na inserção de rota: " . $conn->error . "\n";
}
$stmt->close();


echo "\n=== CONSULTAS ===\n";


$result = $conn->query("SELECT COUNT(*) as total FROM Estacoes");
if ($result) {
    $row = $result->fetch_assoc();
    echo "✅ Total de estações: " . $row['total'] . "\n";
    $result->free();
}


$result = $conn->query("SELECT COUNT(*) as total FROM Trens");
if ($result) {
    $row = $result->fetch_assoc();
    echo "✅ Total de trens: " . $row['total'] . "\n";
    $result->free();
}


$result = $conn->query("SELECT COUNT(*) as total FROM Rotas");
if ($result) {
    $row = $result->fetch_assoc();
    echo "✅ Total de rotas: " . $row['total'] . "\n";
    $result->free();
}


$result = $conn->query("SELECT r.nomeRota, e1.nomeEstacao as origem, e2.nomeEstacao as destino FROM Rotas r JOIN Estacoes e1 ON r.estacaoOrigem = e1.idEstacao JOIN Estacoes e2 ON r.estacaoDestino = e2.idEstacao LIMIT 5");
if ($result) {
    echo "\n✅ Rotas encontradas:\n";
    while ($row = $result->fetch_assoc()) {
        echo "  - " . $row['nomeRota'] . ": " . $row['origem'] . " → " . $row['destino'] . "\n";
    }
    $result->free();
}

echo "\n=== TESTE CONCLUÍDO ===\n";
$conn->close();
?>
