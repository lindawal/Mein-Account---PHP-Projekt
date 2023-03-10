<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include("./includes/header.inc.php");

include_once("./includes/dyn_Weiterleitung.inc.php");


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
      include("./includes/login.inc.php");
    }
    if ($_GET['page'] == 'password_reset') {
      include("./includes/change_pw.inc.php");
    }
    if ($_GET['page'] == 'signup') {
      include("./includes/signup.inc.php");
    }
  }
}
?>

<?php
//Footer einbinden
include("./includes/footer.inc.php");
?>