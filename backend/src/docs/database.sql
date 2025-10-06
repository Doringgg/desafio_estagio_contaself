CREATE DATABASE IF NOT EXISTS escola;
USE escola;

-- Criar tabela cursos
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(70) NOT NULL UNIQUE
);

-- Criar tabela alunos
CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    idade INT,
    curso_id INT,
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);

INSERT INTO cursos (nome) VALUES 
('Engenharia de Software'),
('Ciência da Computação'),
('Administração'),
('Medicina');

INSERT INTO alunos (nome, idade, curso_id) VALUES 
('João Silva', 20, 1),
('Maria Santos', 22, 2),
('Pedro Oliveira', 19, 1),
('Ana Costa', 21, 3),
('Carlos Lima', 23, 2);