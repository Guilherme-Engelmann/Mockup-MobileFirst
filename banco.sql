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

CREATE TABLE Trem (
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
    FOREIGN KEY (idTrem) REFERENCES Trem(idTrem),
    FOREIGN KEY (idRota) REFERENCES Rota(idRota)
);

