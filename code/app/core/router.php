<?php
require_once dirname(__DIR__)."/controller/controller.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
switch($uri){
    case '/':
        listerView();
        break;
         case '/saveAppro':
            saveAppro();
        break;
    default :
    break;
}