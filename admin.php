<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include("./includes/header.inc.php");

include_once("./includes/dyn_Weiterleitung.inc.php");


if (isset($_SESSION["name"])) { //prüfen, ob eine benannte Session vorhanden ist

  //Begrüßung

  echo "Hallo " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . ",<br>hier siehst du deine persönlichen Inhalte:";
  // echo "<br><br>Host: " . $_SERVER['HTTP_HOST'] . "<br>"
  //   . "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>"
  //   . "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>"
  //  . "Query String: " . $_SERVER['QUERY_STRING'] . "<br>"
  //  . "referer: " . $_SERVER['HTTP_REFERER'] . "<br>"
  //  . "Self " . $_SERVER['PHP_SELF'] . "<br>";
  //define("last_uri", $_SERVER['SCRIPT_NAME']);
  //$uri = rtrim($_SERVER['HTTP_REFERER']);
 // $page = rtrim(dirname($_SERVER['SCRIPT_NAME']), $uri);
  //echo "last_uri: " . last_uri . "<br><br>";
  

  //wenn der Parameter page gesendet wurde und auf "new_user" gesetzt ist, soll die Datei zum User Anlegen eingebunden werden
  if (isset($_GET['page'])) {
    if ($_GET['page'] == 'new_user')
      include_once("./includes/new_user.inc.php");

    //wenn der Button mit dem Namen change gesendet wurde, soll die Datei zum Ändern der Userdaten eingebunden werden
    if ($_GET['page'] == 'change_user') {
    if (isset($_POST["change"])) {
    //include_once("./includes/suchparameter.php");
        safe_filter($_SERVER['HTTP_REFERER']);
    }
      include_once("./includes/change_user.inc.php");
        
    }
  }
  //Standartmäßig sollen die Übersicht über alle Nutzer und die Filteroptionen angezeigt werden
   if (!isset($_GET['page'])) {
     include_once("./includes/admin_interface.inc.php");
   }
} else {
  /***
  Wenn noch kein Login statt fand, dann Weiterleitung zur Login-Seite
  ***/
  if (!isset($_GET['page'])) {
    weiterleiten("index.php?page=login");
  }
}
?>

<?php
//Footer einbinden
include("./includes/footer.inc.php");
?>