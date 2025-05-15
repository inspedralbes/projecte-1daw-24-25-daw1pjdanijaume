SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS incidencies
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

GRANT ALL PRIVILEGES ON incidencies.* TO 'usuari'@'%';
FLUSH PRIVILEGES;

USE incidencies;


CREATE TABLE Incidencies (
    ID_Incidencia INT(11) PRIMARY KEY AUTO_INCREMENT,
    Departament ENUM('Contabilitat', 'Administració', 'Producció', 'Manteniment', 'Informàtica', 'Suport Tècnic', 'Marketing', 'Atenció al client') COLLATE utf8mb4_general_ci NOT NULL,
    Data_Inici DATETIME NOT NULL DEFAULT NOW(),
    Descripcio TEXT COLLATE utf8mb4_general_ci NOT NULL,
    Prioritat ENUM('Alta', 'Mitja', 'Baixa', 'No assignada') COLLATE utf8mb4_general_ci DEFAULT 'No assignada',
    Tipologia VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    Resolta TINYINT(1) DEFAULT 0,
    ID_Tecnic INT(11) DEFAULT NULL
);

CREATE TABLE Tecnics (
    ID_Tecnic INT(11) PRIMARY KEY AUTO_INCREMENT,
    Nom_Tecnic VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL
);

CREATE TABLE Actuacions (
    ID_Actuacio INT(11) PRIMARY KEY AUTO_INCREMENT,
    ID_Incidencia INT(11) NOT NULL,
    Data_Actuacio DATETIME NOT NULL DEFAULT NOW(),
    Descripcio TEXT COLLATE utf8mb4_general_ci NOT NULL,
    Temps INT(11) NOT NULL,
    VisibleUsuari TINYINT(1) DEFAULT 1,
    ID_Tecnic INT(11) DEFAULT NULL,
    FOREIGN KEY (ID_Incidencia) REFERENCES Incidencies(ID_Incidencia),
    FOREIGN KEY (ID_Tecnic) REFERENCES Tecnics(ID_Tecnic)
);

INSERT INTO Tecnics (Nom_Tecnic) VALUES ('Juan'), ('Manolo'), ('Pedro'), ('Miguel'), ('Lucas'), ('Antonio'), ('Luis'), ('Pau');

