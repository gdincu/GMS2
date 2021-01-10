--
-- Database: `gms`
--
DROP DATABASE IF EXISTS GMS;
CREATE DATABASE GMS;
USE GMS;
SET time_zone = "+02:00";

CREATE TABLE client (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nume VARCHAR(30) NOT NULL,
	prenume VARCHAR(30) NOT NULL,
	nrtelefon VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	adresa  VARCHAR(50),
	observatii VARCHAR(100),
	date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE auto_list (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	marca  VARCHAR(50) NOT NULL,
	model VARCHAR(50) NOT NULL
);

CREATE TABLE masina (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_auto INT(11) UNSIGNED NOT NULL,
	nrinmatriculare VARCHAR(30) NOT NULL,
	motor VARCHAR(50),
	vin  VARCHAR(50),
	detalii   VARCHAR(50),
	avariat varchar(250) NOT NULL,
	acesorii VARCHAR(250),
	km  varchar(10),
	observatii VARCHAR(100),
	receptionat varchar(100) NOT NULL DEFAULT 'Nu',
	datareceptie datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	FOREIGN KEY (id_auto) REFERENCES auto_list(id)
);

CREATE TABLE clientmasina (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idclient INT(11) UNSIGNED,
	idmasina INT(11) UNSIGNED,
	FOREIGN KEY (idclient) REFERENCES client(id),
	FOREIGN KEY (idmasina) REFERENCES masina(id)
);

CREATE TABLE factura (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idclient INT(11) UNSIGNED NOT NULL,
	idmasina INT(11) UNSIGNED NOT NULL,
	cost_manopera FLOAT(50) NOT NULL,
	cost_piese FLOAT(50) NOT NULL,
	cost_total FLOAT(50) NOT NULL,
	observatii VARCHAR(100),
	date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	FOREIGN KEY (idclient) REFERENCES client(id),
	FOREIGN KEY (idmasina) REFERENCES masina(id)
);

CREATE TABLE reparatii (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nume VARCHAR(100) NOT NULL,
	idmasina INT(11) UNSIGNED,
	durata TIME,
	pret FLOAT(50) NOT NULL
);

CREATE TABLE piese (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nume VARCHAR(100) NOT NULL,
	producator  VARCHAR(100) NOT NULL,
	idmasina INT(11) UNSIGNED,
	costachizitie FLOAT(50) UNSIGNED NOT NULL,
	costvanzare FLOAT(50) UNSIGNED NOT NULL,
	cantitate FLOAT(50) UNSIGNED NOT NULL,
	observatii VARCHAR(250)
);

CREATE TABLE facturapiese (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idfactura INT(11) UNSIGNED NOT NULL,
	idpiesa INT(11) UNSIGNED NOT NULL,
	cantitate INT(11) UNSIGNED NOT NULL,
	cost FLOAT(30) UNSIGNED NOT NULL,
	FOREIGN KEY (idfactura) REFERENCES factura(id),
	FOREIGN KEY (idpiesa) REFERENCES piese(id)
);

CREATE TABLE facturareparatii (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idfactura INT(11) UNSIGNED NOT NULL,
	idreparatie INT(11) UNSIGNED NOT NULL,
	cantitatereparatie INT(11) UNSIGNED NOT NULL,
	cost FLOAT(30) UNSIGNED NOT NULL,
	FOREIGN KEY (idfactura) REFERENCES factura(id),
	FOREIGN KEY (idreparatie) REFERENCES reparatii(id)
);

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) UNSIGNED NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(150) COLLATE utf8_romanian_ci NOT NULL,
  `image` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- username unique
ALTER TABLE `gms`.`user` ADD UNIQUE `username` (`username`) USING BTREE;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `password`) VALUES
(1, 'Vasile', 'Vasilica', 'AAA', 'dcdb704109a454784b81229d2b05f368692e758bfa33cb61d04c1b93791b0273'),
(2, 'BBB', 'BBB', 'BBB', 'dcdb704109a454784b81229d2b05f368692e758bfa33cb61d04c1b93791b0273'),
(3, 'FFF', 'FFF', 'FFFFF', '25fc92a14a79502fe359ec1416bf80d711f0ae507f2723441e444e05b93e3d58'),
(4, 'Vasile', 'Vasilica', 'KKKKK', '25fc92a14a79502fe359ec1416bf80d711f0ae507f2723441e444e05b93e3d58');

-- --------------------------------------------------------