<?php

function getArticleRupture(){
    $articles =[];
    $pdo = deconnecteDB();
    $sql= "SELECT a.id, a.libelle,a.stock,f.nom,a.seuil, CASE 
    WHEN  a.stock <=3
    THEN 'danger' 
    ELSE  'warning'
END AS stockcol
FROM articles a INNER JOIN fournis f ON f.id = a.id_fourni WHERE  a.stock <= a.seuil ORDER BY a.stock DESC";

$articles = query($pdo,$sql,false);
return $articles;
}

