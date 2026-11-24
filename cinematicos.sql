SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET NAMES utf8;
create database cinematicos;
USE cinematicos;

CREATE TABLE IF NOT EXISTS filmes (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titulo varchar(140) NOT NULL,
  autores varchar(150) NOT NULL,
  data_lancamento_oficial date NOT NULL,
  estudio varchar(100) NOT NULL,
  valor_ingresso DECIMAL(10, 2) NOT NULL,
  sinopse varchar(400) NOT NULL,
  categoria varchar(100) NOT NULL,
  faixa_etaria int not null,
  capa varchar(200) not null
);

CREATE TABLE usuarios(
    id int AUTO_INCREMENT not null PRIMARY KEY,
    nome varchar(50) not null,
    user varchar(50) not null,
    nivel TEXT not null,
    password varchar(300) not null,
    foto varchar(50)
);

CREATE TABLE IF NOT EXISTS clientes (
    id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nome varchar(100) NOT NULL,
    email varchar(120) NOT NULL,
    telefone varchar(20) NOT NULL,
    data_nascimento date NOT NULL,
    cidade varchar(80) NOT NULL
);

insert into filmes (titulo, autores, data_lancamento_oficial, estudio, valor_ingresso, sinopse, categoria, faixa_etaria, capa)
values ('Umamusume: Pretty Derby - Beginning of a New Era', 'Ken Yamamoto', '2024-5-24', 'CygamesPictures', 57.00, 
'Jungle Pocket, uma jovem umamusume, sonha em se tornar a melhor corredora. Mas, na pista, não há espaço para dúvidas: talento, rivalidade e determinação se enfrentam a cada corrida.
Com uma animação de alto nível e emoções à flor da pele, aqui não vence apenas a mais rápida… mas aquela que nunca desiste.
Não é apenas uma estreia… é o começo de um fenômeno.
Velocidade, música, rivalidade e coração.', 
'Esporte, Drama esportivo', 10,'UmamusumeBNE.jpg')