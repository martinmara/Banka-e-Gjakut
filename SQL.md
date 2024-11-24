CREATE DATABASE IF NOT EXISTS banka_e_gjakut;


USE banka_e_gjakut;


CREATE TABLE donatore (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emer VARCHAR(100) NOT NULL,
    mbiemer VARCHAR(100) NOT NULL,
    numer_telefoni VARCHAR(15) NOT NULL,
    grupi_gjakut VARCHAR(3) NOT NULL
) ENGINE=InnoDB;


CREATE TABLE pacient (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emer VARCHAR(100) NOT NULL,
    mbiemer VARCHAR(100) NOT NULL,
    numer_telefoni VARCHAR(15) NOT NULL,
    grupi_gjakut VARCHAR(3) NOT NULL,
    sasia_e_nevojshme INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE marrje_gjak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_donator INT NOT NULL,
    id_pacient INT NOT NULL,
    sasia_marre INT NOT NULL,
    FOREIGN KEY (id_donator) REFERENCES donatore(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_pacient) REFERENCES pacient(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE banka_gjakut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emer VARCHAR(100) NOT NULL,
    vendodhje VARCHAR(255) NOT NULL,
    numer_telefoni VARCHAR(15) NOT NULL,
    sasia_pacienteve INT NOT NULL
) ENGINE=InnoDB;