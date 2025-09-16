CREATE DATABASE tracktrain;

USE tracktrain;


CREATE TABLE Manutencoes (
    idManutencoes INT AUTO_INCREMENT PRIMARY KEY,
    idTrem INT NOT NULL,
    tipoManutencoes VARCHAR(50) NOT NULL,
    descricaoManutencoes VARCHAR(255) NOT NULL,
    data_agendada DATE NOT NULL,
    data_conclusao DATE NOT NULL,
    statusManutencoes VARCHAR(50) NOT NULL,
    custoManutencoes DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idTrem) REFERENCES Trem(idTrem)
);

CREATE TABLE Trens (
    idTrem INT AUTO_INCREMENT PRIMARY KEY,
    numero_serie INT NOT NULL,
    modeloTrem VARCHAR(75) NOT NULL,
    data_fabricacao DATE NOT NULL,
    capacidade_passageiros INT NOT NULL,
    capacidade_carga  VARCHAR(120) NOT NULL,
    status_operacional  VARCHAR(50) NOT NULL
);

CREATE TABLE Viagens (
    idViagem INT AUTO_INCREMENT PRIMARY KEY,
    idTrem INT NOT NULL,
    idRota INT NOT NULL,
    horario_partida_previsto TIME NOT NULL,
    horario_chegada_previsto TIME NOT NULL,
    horario_partida_real TIME NOT NULL,
    horario_chegada_real TIME NOT NULL,
    statusViagens VARCHAR(50) NOT NULL,
    FOREIGN KEY (idTrem) REFERENCES Trens(idTrem),
    FOREIGN KEY (idRota) REFERENCES Rotas(idRota)
);

CREATE TABLE Alertas (
    idAlerta INT AUTO_INCREMENT PRIMARY KEY,
    IdViagem INT NOT NULL,
    tipoAlerta VARCHAR(50) NOT NULL,
    severidadeAlerta VARCHAR(50) NOT NULL,
    descricaoAlerta VARCHAR(225) NOT NULL,
    tempoAlerta DATETIME NOT NULL,
    statusResolucao VARCHAR(50) NOT NULL,
    FOREIGN KEY (idViagem) REFERENCES Viagens(idViagem)
);

CREATE TABLE Rotas (
    idRota INT AUTO_INCREMENT PRIMARY KEY,
    estacaoDestino INT NOT NULL,
    estacaoOrigem INT NOT NULL,
    nomeRota VARCHAR(120) NOT NULL UNIQUE,
    distanciatotal FLOAT(10,2) NOT NULL,
    tempomedidaPercuso TIME NOT NULL
    FOREIGN KEY (estacaoDestino) REFERENCES Estacoes(idEstacao)
    FOREIGN KEY (estacaoOrigem) REFERENCES Estacoes(idEstacao);
);

CREATE TABLE Estacoes (
    idEstacao INT AUTO_INCREMENT PRIMARY KEY,
    nomeEstacao VARCHAR(120) NOT NULL UNIQUE,
    latitude DECIMAL(10,2) NOT NULL,
    longitude DECIMAL(10,2) NOT NULL,
    tipoEstacao VARCHAR(50) NOT NULL
);

CREATE TABLE Segmentos (
    idSegmento INT AUTO_INCREMENT PRIMARY KEY,
    idRota INT NOT NULL,
    estacaoInicio INT NOT NULL,
    estacaoFim INT NOT NULL,
    comprimento REAL(10,2) NOT NULL,
    velocidadeMaxima INT NOT NULL
);

