CREATE DATABASE ferrovia;

USE ferrovia;

CREATE TABLE PerfilUsuario (
    idPerfil INT AUTO_INCREMENT PRIMARY KEY,
    nomePerfil VARCHAR(50) NOT NULL
);

CREATE TABLE Usuario (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    tipoUsuario VARCHAR(50),
    idPerfil INT,
    FOREIGN KEY (idPerfil) REFERENCES PerfilUsuario(idPerfil)
);

CREATE TABLE Trem (
    idTrem INT AUTO_INCREMENT PRIMARY KEY,
    identificacao VARCHAR(50) NOT NULL,
    modelo VARCHAR(50),
    capacidade INT
);

CREATE TABLE DadoSensor (
    idDado INT AUTO_INCREMENT PRIMARY KEY,
    idTrem INT,
    tipoSensor VARCHAR(50),
    valorSensor FLOAT,
    dataHora DATETIME,
    FOREIGN KEY (idTrem) REFERENCES Trem(idTrem)
);

CREATE TABLE Rota (
    idRota INT AUTO_INCREMENT PRIMARY KEY,
    nomeRota VARCHAR(100),
    demandaHistorica INT,
    demandaAtual INT
);

CREATE TABLE Segmento (
    idSegmento INT AUTO_INCREMENT PRIMARY KEY,
    idRota INT,
    idEstacaoInicio INT,
    idEstacaoFim INT,
    ordem INT,
    FOREIGN KEY (idRota) REFERENCES Rota(idRota)
);
