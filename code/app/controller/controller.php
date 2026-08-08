<?php
require_once dirname(__DIR__)."/model/approvModel.php";
require_once dirname(__DIR__)."/model/articleModel.php";
require_once dirname(__DIR__)."/model/fournissModel.php";


function listerView(){
    $appros=getReception();
    $articles = getArticleRupture();
    $approvs = getAppros();
    renderView("approvisionnement.html.php",['appros'=>$appros,'articles'=>$articles,'approvs'=>$approvs]);

}


function renderView(string $file,array $datas=[]){
  extract($datas);
    require_once dirname(__DIR__). "/view/$file";

}