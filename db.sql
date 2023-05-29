CREATE DATABASE hw1;
use hw1;

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    password varchar(255) not null,
	nome varchar(255) not null,
    cognome varchar(255) not null,
	email varchar(255) not null unique,
    propic varchar(255)
) Engine = InnoDB;

SELECT * FROM USERS;
drop table users;

CREATE TABLE `preferiti` (
  `id` int(11) NOT NULL,
  `titolo` varchar(30) DEFAULT NULL,
  `immagine` varchar(200) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
    UNIQUE (id, titolo, immagine, tipo) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SELECT * FROM preferiti;
DROP TABLE PREFERITI;

CREATE TABLE `artista` (
  `ID` int(11) NOT NULL primary key,
  `nome` varchar(20) DEFAULT NULL,
  `profilo` varchar(500) NOT NULL,
  `descrizione` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SELECT * FROM ARTISTA;
drop table artista;

INSERT INTO `artista` (`ID`, `nome`, `profilo`, `descrizione`) VALUES
(1, 'Maneskin', 'https://i.scdn.co/image/ab6761610000e5eb734144a8667a0bab0a9b9481', 'I Maneskin sono una band rock italiana. Diventati famosi in tutto il mondo. '),
(2, 'Rose Villain', 'https://i.scdn.co/image/ab67616d0000b273888812bbfaa3731daaecee44', 'Rose Villain, pseudonimo di Rosa Luini, è una cantautrice rap italiana.'),
(3, 'Kailee Morgue', 'https://i.scdn.co/image/ab6761610000e5eb86e0fbee53d9e1aec4459ab8', 'Kailee Morgue è una cantautrice e musicista statunitense.'),
(4, 'Levante', 'https://i.scdn.co/image/ab6761610000e5eb4cca63ccd55e5b8ae7f72439', 'Levante, è una cantautrice italiana. Ha partecipato a Sanremo 2023'),
(5, 'Tananai', 'https://i.scdn.co/image/ab6761610000e5eb3367a54bcede278844e6c351', 'Tananai  è un cantautore e produttore discografico italiano.'),
(6, 'Dua Lipa', 'https://i.scdn.co/image/ab6761610000e5ebd42a27db3286b58553da8858', 'Dua Lipa è una cantante e cantautrice britannica di origini kosovare.'),
(7, 'Annalisa', 'https://i.scdn.co/image/ab6761610000e5eb58829778a596dfff366198f3', ' Annalisa ha consolidato il suo successo con una serie di singoli di pop.'),
(8, 'Imagine Dragons', 'https://i.scdn.co/image/ab6761610000e5eb920dc1f617550de8388f368e', 'Gli Imagine Dragons sono una band rock alternativa statunitense '),
(9, 'chiamamifaro', 'https://i.scdn.co/image/ab6761610000e5eb9e9cec14c8152ee8898b6531', 'Singoli: Pasta Rossa, Domenica con il supporto dei Pinguini Tattici Nucleari.');