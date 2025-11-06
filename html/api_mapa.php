<?php
header('Content-Type: application/json');

// Simulação de dados de rota
$rota = [
    'linha' => '031',
    'data' => '28/03/2025',
    'mapa_img' => '../imagens/mapa-rota.png',
    'estacoes' => [
        [
            'hora' => '10:30',
            'acao' => 'Saída da estação X'
        ],
        [
            'hora' => '10:50',
            'acao' => 'Chegada na estação Y'
        ]
    ]
];

echo json_encode($rota);
