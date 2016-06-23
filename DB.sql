CREATE DATABASE kolekcija DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE kolekcija;

CREATE TABLE zanr (
	id INT (10) NOT NULL AUTO_INCREMENT,
	naziv VARCHAR (20) NOT NULL,
	PRIMARY KEY (id)
)ENGINE InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE filmovi (
	id INT NOT NULL AUTO_INCREMENT,
	naslov VARCHAR (50) NOT NULL,
    id_zanr INT NOT NULL,
    godina INT (4) NOT NULL,
    trajanje INT (5) NOT NULL,
    slika LONGBLOB NOT NULL,
	PRIMARY KEY (id),
    FOREIGN KEY (id_zanr)
		REFERENCES zanr(id)
)ENGINE InnoDB DEFAULT CHARSET=utf8;

INSERT INTO zanr (id, naziv)
VALUES
	(1,'Avantura'),
	(2,'Akcija'),
	(3,'Komedija'),
	(4,'Horror'),
	(5,'Triller');


