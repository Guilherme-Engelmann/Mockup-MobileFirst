CREATE DATABASE IF NOT EXISTS tracktrain;
USE tracktrain;


CREATE TABLE Estacoes (
    idEstacao INT AUTO_INCREMENT PRIMARY KEY,
    nomeEstacao VARCHAR(120) NOT NULL UNIQUE,
    latitude DECIMAL(10,2) NOT NULL,
    longitude DECIMAL(10,2) NOT NULL,
    tipoEstacao VARCHAR(50) NOT NULL
);


CREATE TABLE Rotas (
    idRota INT AUTO_INCREMENT PRIMARY KEY,
    estacaoDestino INT NOT NULL,
    estacaoOrigem INT NOT NULL,
    nomeRota VARCHAR(120) NOT NULL UNIQUE,
    distanciaTotal FLOAT(10,2) NOT NULL,
    tempoMedioPercurso TIME NOT NULL,
    FOREIGN KEY (estacaoDestino) REFERENCES Estacoes(idEstacao),
    FOREIGN KEY (estacaoOrigem) REFERENCES Estacoes(idEstacao)
);


CREATE TABLE Trens (
    idTrem INT AUTO_INCREMENT PRIMARY KEY,
    numero_serie INT NOT NULL,
    modeloTrem VARCHAR(75) NOT NULL,
    data_fabricacao DATE NOT NULL,
    capacidade_passageiros INT NOT NULL,
    capacidade_carga VARCHAR(120) NOT NULL,
    status_operacional VARCHAR(50) NOT NULL
);


CREATE TABLE Viagens (
    idViagem INT AUTO_INCREMENT PRIMARY KEY,
    idTrem INT NOT NULL,
    idRota INT NOT NULL,
    horario_partida_previsto TIME NOT NULL,
    horario_chegada_previsto TIME NOT NULL,
    horario_partida_real TIME NULL,
    horario_chegada_real TIME NULL,
    statusViagens VARCHAR(50) NOT NULL,
    FOREIGN KEY (idTrem) REFERENCES Trens(idTrem),
    FOREIGN KEY (idRota) REFERENCES Rotas(idRota)
);


CREATE TABLE Alertas (
    idAlerta INT AUTO_INCREMENT PRIMARY KEY,
    idViagem INT NOT NULL,
    tipoAlerta VARCHAR(50) NOT NULL,
    severidadeAlerta VARCHAR(50) NOT NULL,
    descricaoAlerta VARCHAR(225) NOT NULL,
    tempoAlerta DATETIME NOT NULL,
    statusResolucao VARCHAR(50) NOT NULL,
    FOREIGN KEY (idViagem) REFERENCES Viagens(idViagem)
);


CREATE TABLE Manutencoes (
    idManutencoes INT AUTO_INCREMENT PRIMARY KEY,
    idTrem INT NOT NULL,
    tipoManutencoes VARCHAR(50) NOT NULL,
    descricaoManutencoes VARCHAR(255) NOT NULL,
    data_agendada DATE NOT NULL,
    data_conclusao DATE NULL,
    statusManutencoes VARCHAR(50) NOT NULL,
    custoManutencoes DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idTrem) REFERENCES Trens(idTrem)
);


CREATE TABLE Segmentos (
    idSegmento INT AUTO_INCREMENT PRIMARY KEY,
    idRota INT NOT NULL,
    estacaoInicio INT NOT NULL,
    estacaoFim INT NOT NULL,
    comprimento DECIMAL(10,2) NOT NULL,
    velocidadeMaxima INT NOT NULL,
    FOREIGN KEY (idRota) REFERENCES Rotas(idRota),
    FOREIGN KEY (estacaoInicio) REFERENCES Estacoes(idEstacao),
    FOREIGN KEY (estacaoFim) REFERENCES Estacoes(idEstacao)
);


CREATE TABLE Sensores (
    idSensor INT AUTO_INCREMENT PRIMARY KEY,
    tipoSensor VARCHAR(50) NOT NULL,
    localizacao VARCHAR(120) NOT NULL,
    tipoLocalizacao VARCHAR(50) NOT NULL,
    unidadeMedida VARCHAR(100) NOT NULL,
    frequenciaLeitura INT NOT NULL
);


CREATE TABLE Leituras (
    idLeitura INT AUTO_INCREMENT PRIMARY KEY,
    idSensor INT NOT NULL,
    valor INT NOT NULL,
    tempoLeitura DATETIME NOT NULL,
    statusAnomalia INT NOT NULL,
    FOREIGN KEY (idSensor) REFERENCES Sensores(idSensor)
);

CREATE TABLE Usuarios (
    pk INT AUTO_INCREMENT PRIMARY KEY,
    nomeUsuario VARCHAR(50) NOT NULL UNIQUE,
    Senha VARCHAR(255) NOT NULL,
    tipoUsuario VARCHAR(20) NOT NULL,
    nome VARCHAR(255),
    funcao VARCHAR(100),
    linha INT,
    velocidade INT,
    codigo_barra VARCHAR(20),
    email VARCHAR(100) NULL UNIQUE,
    ultimo_login DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Usuarios (nomeUsuario, Senha, tipoUsuario, nome, funcao, linha, velocidade, codigo_barra) VALUES ('admin', '$2y$10$examplehashedpassword', 'admin', 'Administrador', 'Administrador', NULL, NULL, NULL);
INSERT INTO Usuarios (nomeUsuario, Senha, tipoUsuario, nome, funcao, linha, velocidade, codigo_barra) VALUES ('funcionario', '$2y$10$examplehashedpassword2', 'funcionario', 'Sergio Conceição', 'Maquinista', 157, 60, '0123456789');

CREATE INDEX idx_email ON Usuarios(email);
=======
    cargo VARCHAR(20) NOT NULL,
    email VARCHAR(100) NULL UNIQUE,
    ultimo_login DATETIME DEFAULT CURRENT_TIMESTAMP


CREATE INDEX idx_email ON Usuarios(email);
>>>>>>> 2182640c2474daf5757047b327bfdb7db2692c35
