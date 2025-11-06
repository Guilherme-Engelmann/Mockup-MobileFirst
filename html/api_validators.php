<?php


function validar_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11) {
        return false;
    }
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}


function validar_telefone($telefone) {
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    return strlen($telefone) >= 10 && strlen($telefone) <= 11;
}


function validar_cep($cep) {
    $cep = preg_replace('/[^0-9]/', '', $cep);
    if (strlen($cep) != 8) {
        return ['valid' => false, 'message' => 'CEP deve ter 8 dígitos'];
    }

    $url = "https://viacep.com.br/ws/$cep/json/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code != 200) {
        return ['valid' => false, 'message' => 'Erro na API ViaCEP (HTTP ' . $http_code . ')'];
    }

    $data = json_decode($response, true);
    if (isset($data['erro']) && $data['erro'] === true) {
        return ['valid' => false, 'message' => 'CEP não encontrado'];
    }

    if (!isset($data['cep'])) {
        return ['valid' => false, 'message' => 'Resposta inválida da API'];
    }

    return ['valid' => true, 'data' => $data];
}


function validar_endereco($endereco) {
    return strlen(trim($endereco)) > 5; 
}


function log_auditoria($conn, $user_pk, $action, $status, $details = '') {
    $stmt = $conn->prepare("INSERT INTO Auditoria (user_pk, action, status, details) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_pk, $action, $status, $details);
    $stmt->execute();
    $stmt->close();
}

?>
