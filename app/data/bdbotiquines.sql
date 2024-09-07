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
    #
    nom_etd VARCHAR(40) NOT NULL
);

CREATE TABLE administrador (
    pk_id_adm INT AUTO_INCREMENT PRIMARY KEY,
    #
    nom_adm VARCHAR(150) NOT NULL,
    ape_adm VARCHAR(150) NOT NULL,
    usu_adm VARCHAR(50) NOT NULL,
    ema_adm VARCHAR(150) NOT NULL,
    pass_adm VARCHAR(200) NOT NULL,
    #
    fk_etd_adm INT DEFAULT 1 NOT NULL,
    #
    CONSTRAINT admEtd FOREIGN KEY(fk_etd_adm) REFERENCES estado(pk_id_etd)
);

CREATE TABLE categoria (
    pk_id_ctg INT AUTO_INCREMENT PRIMARY KEY,
    #
    nom_ctg VARCHAR(250) NOT NULL,
    img_ctg VARCHAR(150),
    des_ctg TEXT,
    #
    fk_etd_ctg INT DEFAULT 1 NOT NULL,
    #
    CONSTRAINT ctgEtd FOREIGN KEY(fk_etd_ctg) REFERENCES estado(pk_id_etd)
);

CREATE TABLE producto (
    pk_id_prd INT AUTO_INCREMENT PRIMARY KEY,
    #
    dCrt_prd DATE NOT NULL,
    nom_prd VARCHAR(200) NOT NULL,
    img_prd TEXT,
    des_prd TEXT,
    #
    fk_ctg_prd INT DEFAULT 1 NOT NULL,
    fk_etd_prd INT DEFAULT 1 NOT NULL,
    #
    CONSTRAINT prdCtg FOREIGN KEY(fk_ctg_prd) REFERENCES categoria(pk_id_ctg),
    CONSTRAINT prdEtd FOREIGN KEY(fk_etd_prd) REFERENCES estado(pk_id_etd)
);

/* ######################### DATOS #########################*/
INSERT INTO estado
(nom_etd)
VALUES
('Activo'),('Inactivo'),('Papelera'),
('Eliminado');

INSERT INTO administrador (
    nom_adm, ape_adm, usu_adm,
    ema_adm, pass_adm
) VALUES (
    'Carlos Eduardo', 'Orozco Alba', '@Orozco2005',
    'carlosorzcoalba@gmail.com', '$2y$10$J4yZ3daiYRB6RPcRfJhkaulCEsnbloy02oOaMCGIAVUPcb3yYfJT2'
), (
    'Fabian Aruri', 'Chala Mendoza', '@Archy',
    'arurichala07@gmail.com', 'NULL'
);

INSERT INTO categoria
(nom_ctg)
VALUES
('Sin especificar'),
('Sección - 1'),
('Sección - 2');