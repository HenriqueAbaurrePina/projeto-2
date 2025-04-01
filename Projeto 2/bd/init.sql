CREATE DATABASE IF NOT EXISTS usuarios_db;

USE usuarios_db;

CREATE TABLE IF NOT EXISTS usuarios (
    ID int NOT NULL AUTO_INCREMENT,
    nome varchar(255),
    email varchar(255),
    PRIMARY KEY (ID)
);