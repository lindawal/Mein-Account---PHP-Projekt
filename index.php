<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include_once("./includes/header.inc.php");

include_once("./includes/dyn_Weiterleitung.inc.php"); //bindet Hilfsfunktionen ein, die Weiterleitungen und Links dynamisch an die aktuelle URL anpassen 


if (isset($_SESSION["name"])) { //prüfen, ob eine benannte Session vorhanden ist

  if (isset($_GET['page'])) {
    if (($_GET['page'] == 'login') || ($_GET['page'] == 'signup')) {
      weiterleiten("index.php"); //dynamische Weiterleitung
    }
  }
  if ($_SESSION["admin"] == true) {
    weiterleiten("admin.php");
  } else
    weiterleiten("user.php");

} else {
  /***
  Wenn noch kein Login statt fand, dann Weiterleitung zur Login-Seite
  ***/
  if (!isset($_GET['page'])) {
    weiterleiten("index.php?page=login");
  }
  if (isset($_GET['page'])) {
    if ($_GET['page'] == 'login') {
      include_once("./includes/login.inc.php");
    }
    if ($_GET['page'] == 'password_reset') {
      include_once("./includes/change_pw.inc.php");
    }
    if ($_GET['page'] == 'signup') {
      include_once("./includes/signup.inc.php");
    }
  }
}
?>

<?php
//Footer einbinden
include_once("./includes/footer.inc.php");
?>