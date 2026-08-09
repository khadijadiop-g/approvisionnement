

CREATE TABLE statuts(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50) UNIQUE,
    CONSTRAINT chk_satut CHECK(nom IN ('EN COURS','RECEPTIONNER'))
);

CREATE TABLE fournis(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) UNIQUE,
    telephone VARCHAR(50) UNIQUE,
    adresse VARCHAR(100)
);

CREATE TABLE appros(
    id SERIAL PRIMARY KEY,
    ref_bl VARCHAR(50) UNIQUE,
    date_appro DATE DEFAULT CURRENT_DATE,
    id_statut INTEGER,
    id_fourni INTEGER,
    FOREIGN KEY (id_statut) REFERENCES statuts(id),
    FOREIGN KEY (id_fourni) REFERENCES fournis(id)
);

CREATE TABLE articles(
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100),
    prix_achat NUMERIC(12,2),
    stock INT,
    id_fourni INTEGER,
    FOREIGN KEY (id_fourni) REFERENCES fournis(id)
);

CREATE TABLE ligne_appro(
    id SERIAL PRIMARY KEY,
    prix_achatreell NUMERIC(12,2),
    qt_recu INT,
    qt_appro INT,
    id_article INTEGER,
    id_appro INTEGER,
    FOREIGN KEY (id_article) REFERENCES articles(id),
    FOREIGN KEY (id_appro) REFERENCES appros(id)
);

INSERT INTO statuts (nom) VALUES
('EN COURS'),
('RECEPTIONNER');

INSERT INTO fournis (nom, telephone, adresse) VALUES
('Comptoir Céréalier Sénégalais (CCS)', '338601010', 'Port de Dakar, Hangar 4'),  
('Grossiste Diop & Frères',             '338602020', 'Marché Sandaga, Dakar'),    
('SODIA',                                '338603030', 'Zone industrielle, Dakar'),
('AFRIMAT',                              '338604040', 'Km 5, Rufisque'),          
('SENEQUIP',                             '338605050', 'Rue 12, Thiès'),           
('Boulangerie Sarr & Fils',              '338606060', 'Médina, Dakar'),           
('Quincaillerie Moderne',                '338607070', 'Colobane, Dakar'),         
('Import-Export Fall',                   '338608080', 'Zone Franche, Dakar');     
INSERT INTO articles (libelle, prix_achat, stock, id_fourni) VALUES
('Sac de riz 50kg',          21000.00, 200, 1), 
('Sac de riz 25kg',          11000.00,  90, 1), 
('Bidon d''huile 5L',         3200.00,   5, 2), 
('Carton de savon',           8500.00,   4, 2), 
('Huile de palme 1L',         1800.00,   0, 2), 
('Lait en poudre 1kg',        3800.00,   3, 2), 
('Fer à béton 12mm',          6200.00,  80, 4), 
('Ciment 50kg',               4500.00, 150, 3), 
('Carreaux 40x40',            3200.00, 200, 4), 
('Peinture 5L',               15000.00, 40, 5), 
('Farine de blé 25kg',        12500.00, 60, 6), 
('Sucre en poudre 1kg',       650.00,  300, 6), 
('Vis assorties (boîte)',     2500.00, 150, 7), 
('Marteau',                   4000.00,  25, 7), 
('Perceuse électrique',       35000.00, 10, 7), 
('Tissu Wax (rouleau)',       18000.00, 20, 8), 
('Chaussures import (paire)', 9500.00,  45, 8); 

INSERT INTO appros (ref_bl, date_appro, id_statut, id_fourni) VALUES
('BL-CCS-098', '2026-08-01', 2, 1),  
('BL-CCS-099', '2026-08-03', 2, 1),  
('BL-DIP-012', '2026-08-05', 2, 2),  
('BL-DIP-013', '2026-08-04', 1, 2), 
('BL-SOD-003', '2026-08-06', 1, 3), 
('BL-AFR-001', '2026-07-10', 2, 4),  
('BL-SEN-045', '2026-07-15', 2, 5),  
('BL-SEN-046', '2026-08-06', 1, 5),  
('BL-SAR-007', '2026-07-20', 2, 6),  
('BL-QM-021',  '2026-07-25', 1, 7),  
('BL-IEF-014', '2026-08-02', 2, 8);  

INSERT INTO ligne_appro (prix_achatreell, qt_recu, qt_appro, id_article, id_appro) VALUES
(21000.00, 200, 200, 1, 1),
(11000.00,  90,  90, 2, 2),
(3200.00,  100, 100, 3, 3),
(8500.00,   30,  30, 4, 3),
(1800.00,  111, 111, 5, 3),
(3800.00,    0,  50, 6, 4),
(4500.00,    0, 100, 7, 5),
(6000.00,   80,  80, 8, 6),
(3100.00,  200, 200, 9, 6),
(15500.00,  40,  40, 10, 7),
(12500.00,  60,  60, 11, 9),
(650.00,   300, 300, 12, 9),
(2500.00,    0, 150, 13, 10),
(4000.00,    0,  25, 14, 10),
(35000.00,   0,  10, 15, 10),
(18000.00,  20,  20, 16, 11),
(9500.00,   45,  45, 17, 11);

INSERT INTO ligne_appro (prix_achatreell, qt_recu, qt_appro, id_article, id_appro) VALUES
(21000.00, 120, 200, 1, 4);

SELECT a.id, a.ref_bl,f.nom ,SUM(l.prix_achatreell*l.qt_appro) AS montantfacture, SUM(l.prix_achatreell*l.qt_recu) AS montantreel,
CASE 
WHEN SUM(l.prix_achatreell*l.qt_appro) = SUM(l.prix_achatreell*l.qt_recu) 
THEN 'CONCORDE'
WHEN SUM(l.prix_achatreell*l.qt_recu) = 0
THEN 'EN_ATTENTE'
ELSE concat('ÉCART',(SUM(l.prix_achatreell*l.qt_recu)-SUM(l.prix_achatreell*l.qt_appro)))
END AS diagnos ,CASE
WHEN SUM(l.prix_achatreell*l.qt_appro) = SUM(l.prix_achatreell*l.qt_recu)
THEN 'success'
WHEN SUM(l.prix_achatreell*l.qt_recu) = 0
THEN 'warnig'
ELSE 'dander'
END AS color 
FROM appros a INNER JOIN ligne_appro l ON a.id = l.id_appro INNER JOIN fournis f ON f.id = a.id_fourni
GROUP BY a.id,a.ref_bl,f.nom;

ALTER TABLE articles ADD COLUMN seuil INT DEFAULT 6;

SELECT * FROM articles;

SELECT a.id,a.libelle,a.stock,f.nom,a.seuil, CASE 
    WHEN  a.stock <=3
    THEN 'danger' 
    ELSE  'warnig'
END AS stockcol
FROM articles a INNER JOIN fournis f ON f.id = a.id_fourni WHERE  a.stock <= a.seuil;

UPDATE articles SET libelle = 'Bidon Huile' WHERE id = 3;
UPDATE articles SET id_fourni =5 WHERE id = 6;
UPDATE articles SET id_fourni =3 WHERE id = 5;

SELECT a.id,a.ref_bl,to_char(a.date_appro,'DD-MM-YYYY') AS date_app,s.nom AS noms,f.nom AS nomf,SUM(l.prix_achatreell*l.qt_appro) AS montant,
COUNT(l.id) AS nbr_id,CASE
WHEN s.nom = 'EN COURS'
THEN 'non-payee'
ELSE 'payee'
END AS clascol
FROM appros a INNER JOIN statuts s ON s.id = a.id_statut 
INNER JOIN fournis f ON f.id = a.id_fourni 
INNER JOIN ligne_appro l ON a.id = l.id_appro 
GROUP BY a.id,a.ref_bl,date_app,s.nom,f.nom;

SELECT a.libelle,l.qt_appro,l.prix_achatreell,(l.qt_appro*l.prix_achatreell) AS sous_total
FROM ligne_appro l INNER JOIN articles a ON l.id_article = a.id WHERE l.id_appro = 1;

SELECT a.libelle,a.id AS id2,l.id AS id1,l.qt_appro,l.prix_achatreell,(l.qt_appro*l.prix_achatreell) AS sous_total
FROM ligne_appro l INNER JOIN articles a ON l.id_article = a.id WHERE l.id_appro = 4
;

SELECT a.id, a.ref_bl,f.nom ,SUM(l.prix_achatreell*l.qt_appro) AS montantfacture, SUM(l.prix_achatreell*l.qt_recu) AS montantreel,
CASE 
WHEN SUM(l.prix_achatreell*l.qt_appro) = SUM(l.prix_achatreell*l.qt_recu) 
THEN 'CONCORDE'
WHEN l.qt_recu = 0
THEN 'EN_ATTENTE'
ELSE concat('ÉCART',(SUM(l.prix_achatreell*l.qt_recu)-SUM(l.prix_achatreell*l.qt_appro)))
END AS diagnos,CASE
WHEN SUM(l.prix_achatreell*l.qt_appro) = SUM(l.prix_achatreell*l.qt_recu)
THEN 'success'
WHEN SUM(l.prix_achatreell*l.qt_recu) = 0
THEN 'warning'
ELSE 'danger'
END AS color 
FROM appros a INNER JOIN ligne_appro l ON a.id = l.id_appro INNER JOIN fournis f ON f.id = a.id_fourni
GROUP BY a.id,a.ref_bl,f.nom,l.qt_recu;

BEGIN TRANSACTION;

UPDATE ligne_appro SET qt_recu = :qt_recu  WHERE id = :idligne;

UPDATE articles SET stock += :qt_recu  WHERE id = :idarticle;

UPDATE appros SET id_statut = 2 WHERE id = :id_appro;

COMMIT;
