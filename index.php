<?php

//var_dump($_GET['controller'] );

//var_dump($_GET['action'] );

include_once("./controllers/". $_GET['controller'] . "_controller.php");

$objController = "Controller" . ucfirst($_GET['controller']) ;

//var_dump($objController);

$controllador = new $objController();


$fun =  ucfirst($_GET['action']);

print_r($controllador->$fun());