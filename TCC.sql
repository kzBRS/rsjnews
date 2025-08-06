CREATE DATABASE IF NOT EXISTS RSJNews;
USE RSJNews;

CREATE TABLE IF NOT EXISTS User (
    ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    usuario VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nascimento DATE NOT NULL,
    nome_completo VARCHAR(255) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    sobrenome VARCHAR(255) NOT NULL,
    bio TEXT,
    localizacao VARCHAR(255),
    trabalho VARCHAR(255),
    formacao VARCHAR(255),
    website VARCHAR(255),
    avatar_path VARCHAR(255),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Post (
    ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    conteudo varchar (255),
    imagem_path VARCHAR(255),
    data_publicacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    curtidas INT DEFAULT 0,
    comentarios INT DEFAULT 0,
    compartilhamentos INT DEFAULT 0,
    visualizacoes INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES User(ID)
);

CREATE TABLE IF NOT EXISTS Seguidores (
    ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    seguidor_id INT NOT NULL,
    seguido_id INT NOT NULL,
    data_seguimento DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seguidor_id) REFERENCES User(ID),
    FOREIGN KEY (seguido_id) REFERENCES User(ID)
);

CREATE TABLE IF NOT EXISTS Curtida (
    ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    data_curtida DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(ID),
    FOREIGN KEY (post_id) REFERENCES Post(ID)
);

CREATE TABLE IF NOT EXISTS Comentario (
    ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    conteudo TEXT NOT NULL,
    data_comentario DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(ID),
    FOREIGN KEY (post_id) REFERENCES Post(ID)
);

CREATE TABLE IF NOT EXISTS Interesses (
    ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    Nome VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Gostos_User (
    user_id INT NOT NULL,
    interesse_id INT NOT NULL,
    valor INT DEFAULT 1,
    PRIMARY KEY (user_id, interesse_id),
    FOREIGN KEY (user_id) REFERENCES User(ID),
    FOREIGN KEY (interesse_id) REFERENCES Interesses(ID)
);

CREATE TABLE IF NOT EXISTS Post_Interesses (
    post_id INT NOT NULL,
    interesse_id INT NOT NULL,
    PRIMARY KEY (post_id, interesse_id),
    FOREIGN KEY (post_id) REFERENCES Post(ID),
    FOREIGN KEY (interesse_id) REFERENCES Interesses(ID)
);

SELECT * FROM Post;
SELECT * FROM User;
SELECT * FROM Interesses;
SELECT * FROM Gostos_User;
INSERT INTO Post (conteudo) VALUE ("SER GAY");
INSERT INTO Interesses (Nome) VALUES ('economia'), ('politica'), ('educacao'), ('esportes'), ('jogos'), ('musica'), ('saude'), ('internacional');
DROP DATABASE RSJNews;