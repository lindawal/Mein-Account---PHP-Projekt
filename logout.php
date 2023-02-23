<?php   
session_start(); //die vorhandene Session aufrufen
session_destroy(); //die Session löschen
$_SESSION = array(); //vorhandene Daten aus dem Session Array überschreiben, indem ein leeres Array erstellt wird

//zur Login Seite zurückkehren
include("./includes/dyn_Weiterleitung.inc.php");
weiterleiten("login_area.php");
?>