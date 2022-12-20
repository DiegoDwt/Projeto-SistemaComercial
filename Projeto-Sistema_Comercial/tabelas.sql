--
-- Estrutura das tabelas
--

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

select * from users;

CREATE TABLE cliente (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  cpf varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  endereco varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  telefone varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  email varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  sexo varchar(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

select * from cliente;


CREATE TABLE fornecedor (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  cnpj varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  descricao varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  endereco varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  telefone varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  email varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

select * from fornecedor;

