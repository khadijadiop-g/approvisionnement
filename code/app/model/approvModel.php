<?php

function getReception():array{
    $appros =[];
    $pdo = deconnecteDB();
    $sql= "SELECT a.id, a.ref_bl,f.nom ,SUM(l.prix_achatreell*l.qt_appro) AS montantfacture, SUM(l.prix_achatreell*l.qt_recu) AS montantreel,
CASE 
WHEN SUM(l.prix_achatreell*l.qt_appro) = SUM(l.prix_achatreell*l.qt_recu) 
THEN 'CONCORDE'
WHEN SUM(l.prix_achatreell*l.qt_recu) = 0
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
GROUP BY a.id,a.ref_bl,f.nom;";

$appros = query($pdo,$sql,false);
return $appros;
}

function getAppros():array{

$approvs =[];
    $pdo = deconnecteDB();
    $sql= "SELECT a.id,a.ref_bl,to_char(a.date_appro,'DD-MM-YYYY') AS date_app,s.nom AS noms,f.nom AS nomf,SUM(l.prix_achatreell*l.qt_appro) AS montant,
COUNT(l.id) AS nbr_id,CASE
WHEN s.nom = 'EN COURS'
THEN 'non-payee'
ELSE 'payee'
END AS clascol
FROM appros a INNER JOIN statuts s ON s.id = a.id_statut 
INNER JOIN fournis f ON f.id = a.id_fourni 
INNER JOIN ligne_appro l ON a.id = l.id_appro 
GROUP BY a.id,a.ref_bl,date_app,s.nom,f.nom";

$approvs = query($pdo,$sql,false);


$sql1="SELECT a.libelle,l.qt_appro,l.prix_achatreell,(l.qt_appro*l.prix_achatreell) AS sous_total
FROM ligne_appro l INNER JOIN articles a ON l.id_article = a.id WHERE l.id_appro = :id";

foreach($approvs as &$approv){

$approv['ligne'] = executeQuery($pdo,$sql1,['id'=>$approv['id']],false);

}
    

   return $approvs; 
}
