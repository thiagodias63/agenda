CREATE TABLE servicos(
	id_servico INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(60) NULL,
	PRIMARY KEY(id_servico)
);

CREATE TABLE responsavel(
	id_responsavel INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(60) NULL,
	telefone VARCHAR(15) NULL,
	email VARCHAR(30) NULL,
	PRIMARY KEY(id_responsavel)
);

CREATE TABLE cliente(
	id_cliente INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(60) NULL,
	endereco VARCHAR(120) NULL,
	id_responsavel INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_cliente),
	FOREIGN KEY(id_responsavel) REFERENCES responsavel (id_responsavel)
);

CREATE TABLE funcionarios(
	id_funcionario INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(60) NULL,
	PRIMARY KEY(id_funcionario)
);

CREATE TABLE `events` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  color varchar(7) DEFAULT NULL,
  start datetime NOT NULL,
  id_cliente INT UNSIGNED NOT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY(id_cliente) REFERENCES cliente (id_cliente)
);
--title varchar(255) NOT NULL, foi removido, será a soma dos serviços com o nome do condominio

CREATE TABLE servicos_ss(
	id_lista_servico INT UNSIGNED AUTO_INCREMENT NOT NULL,
	id_servico INT UNSIGNED NOT NULL,
	id_agendamento INT UNSIGNED NOT NULL,
	preco_servico INT UNSIGNED NULL,
	status VARCHAR(30) NULL,
	PRIMARY KEY(id_lista_servico),
	FOREIGN KEY(id_servico) REFERENCES servicos (id_servico),
	FOREIGN KEY(id_agendamento) REFERENCES events (id)
);

CREATE TABLE funcionarios_ss(
	id_lista_funcionarios INT UNSIGNED AUTO_INCREMENT NOT NULL,
	id_funcionario INT UNSIGNED NOT NULL,
	id_agendamento INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_lista_funcionarios),
	FOREIGN KEY(id_funcionario) REFERENCES funcionarios (id_funcionario),
	FOREIGN KEY(id_agendamento) REFERENCES events (id)
);
