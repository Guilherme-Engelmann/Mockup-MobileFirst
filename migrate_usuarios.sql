-- Migration script to align Usuarios table schema
-- Run this after backing up your database if it has important data

USE tracktrain;

-- Rename fields to match standardized schema
ALTER TABLE Usuarios CHANGE COLUMN username nomeUsuario VARCHAR(50) NOT NULL UNIQUE;
ALTER TABLE Usuarios CHANGE COLUMN senha Senha VARCHAR(255) NOT NULL;
ALTER TABLE Usuarios CHANGE COLUMN cargo tipoUsuario VARCHAR(20) NOT NULL;
ALTER TABLE Usuarios CHANGE COLUMN ultimo_login ultimoLogin DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Add index on nomeUsuario if not exists
CREATE INDEX IF NOT EXISTS idx_nomeUsuario ON Usuarios(nomeUsuario);
