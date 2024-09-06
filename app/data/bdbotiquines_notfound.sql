-- Active: 1688681294104@@127.0.0.1@3306@bdbotiquines
/* ######################### DATABASE ######################### */
CREATE DATABASE bdbotiquines;

USE bdbotiquines;

-- DROP DATABASE bdbotiquines;

/* ######################### Información #########################
Letra || Ejemplo || Tipo
pk_ => pk_Ejm_Ejm // Primary Key
fk_ => fk_Ejm_Ejm // Foreign Key
d => dEjm_Ejm // Fecha
c => cEjm_Ejm // Color
t => tEjm_Ejm // Tipo de elemento
s => sEjm_Ejm // Documento

/* ######################### Tablas #########################*/
CREATE TABLE estado (
    pk_id_etd INT AUTO_INCREMENT PRIMARY KEY,

    nom_etd VARCHAR(40) NOT NULL
);

CREATE TABLE tipo_genero (
    pk_id_tGnr INT AUTO_INCREMENT PRIMARY KEY,

    nom_tGnr VARCHAR(40) NOT NULL,

    fk_etd_tGnr INT DEFAULT 1 NOT NULL,

    CONSTRAINT tGnrEtd FOREIGN KEY(fk_etd_tGnr) REFERENCES estado(pk_id_etd)
);

CREATE TABLE administrador (
    pk_id_adm INT AUTO_INCREMENT PRIMARY KEY,

    nom_adm VARCHAR(150) NOT NULL,
    ape_adm VARCHAR(150) NOT NULL,
    usu_adm VARCHAR(50) NOT NULL,
    doc_adm VARCHAR(12) NOT NULL,
    ema_adm VARCHAR(150) NOT NULL,
    pass_adm VARCHAR(200) NOT NULL,
    cel_adm VARCHAR(15) NOT NULL,

    fk_tGnr_adm INT NOT NULL,
    fk_etd_adm INT DEFAULT 1 NOT NULL,

    CONSTRAINT admTGnr FOREIGN KEY(fk_tGnr_adm) REFERENCES tipo_genero(pk_id_tGnr),
    CONSTRAINT admEtd FOREIGN KEY(fk_etd_adm) REFERENCES estado(pk_id_etd)
);

CREATE TABLE tipo_producto (
    pk_id_tPrd INT AUTO_INCREMENT PRIMARY KEY,

    nom_tPrd VARCHAR(250) NOT NULL,
    des_tPrd TEXT,

    fk_etd_tPrd INT DEFAULT 1 NOT NULL,

    CONSTRAINT tPrdEtd FOREIGN KEY(fk_etd_tPrd) REFERENCES estado(pk_id_etd)
);

CREATE TABLE seccion (
    pk_id_sec INT AUTO_INCREMENT PRIMARY KEY,

    nom_sec VARCHAR(250) NOT NULL,
    des_sec TEXT,

    fk_etd_sec INT DEFAULT 1 NOT NULL,

    CONSTRAINT secEtd FOREIGN KEY(fk_etd_sec) REFERENCES estado(pk_id_etd)
);

CREATE TABLE producto (
    pk_id_prd INT AUTO_INCREMENT PRIMARY KEY,

    dCrt_prd DATE NOT NULL,
    nom_prd VARCHAR(200) NOT NULL,
    img_prd TEXT,
    des_prd TEXT,

    fk_tPrd_prd INT DEFAULT 1 NOT NULL,
    fk_sec_prd INT DEFAULT 1 NOT NULL,
    fk_etd_prd INT DEFAULT 1 NOT NULL,

    CONSTRAINT prdTPrd FOREIGN KEY(fk_tPrd_prd) REFERENCES tipo_producto(pk_id_tPrd),
    CONSTRAINT prdSec FOREIGN KEY(fk_sec_prd) REFERENCES seccion(pk_id_sec),
    CONSTRAINT prdEtd FOREIGN KEY(fk_etd_prd) REFERENCES estado(pk_id_etd)
);

/* ######################### DATOS #########################*/
INSERT INTO estado
(nom_etd)
VALUES
('Activo'),('Inactivo'),('Papelera'),
('Eliminado');

INSERT INTO tipo_genero
(nom_tGnr)
VALUES
('Masculino'),('Femenino'),('Otro');

INSERT INTO administrador (
    nom_adm, ape_adm, usu_adm,
    doc_adm, ema_adm, pass_adm,
    cel_adm, fk_tgnr_adm
) VALUES (
    'CARLOS EDUARDO', 'OROZCO ALBA', '@Orozco2005',
    '1028660884', 'carlosorzcoalba@gmail.com', '$2y$10$J4yZ3daiYRB6RPcRfJhkaulCEsnbloy02oOaMCGIAVUPcb3yYfJT2',
    '3229229875', 1
), (
    'FABIAN ARURI', 'CHALA MENDOZA', '@Archy',
    '1028048758', 'arurichala07@gmail.com', 'NULL',
    '3246641445', 1
);

INSERT INTO tipo_producto
(nom_tPrd)
VALUES
('Sin especificar'),
('Producto 1'),
('Producto 2');

INSERT INTO seccion
(nom_sec, fk_tPrd_sec)
VALUES
('Sin especificar', NULL),
('Sección 1', 2);