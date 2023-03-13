<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include_once("./includes/header.inc.php");

include_once("./includes/dyn_Weiterleitung.inc.php"); //bindet Hilfsfunktionen ein, die Weiterleitungen und Links dynamisch an die aktuelle URL anpassen 


if (isset($_SESSION["name"])) { //prüfen, ob eine benannte Session vorhanden ist
  if ($_SESSION["admin"] == true) {
    //Begrüßung

    echo "Hallo " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . "!<br>";

    //wenn der Parameter page gesendet wurde und auf "new_user" gesetzt ist, soll die Datei zum User Anlegen eingebunden werden
    if (isset($_GET['page'])) {
      if ($_GET['page'] == 'new_user')
        include_once("./includes/admin_new_user.inc.php");

      //wenn der Button mit dem Namen change gesendet wurde, soll die Datei zum Ändern der Userdaten eingebunden werden
      if ($_GET['page'] == 'change_user') {
        if (isset($_POST["change"])) {
          safe_filter($_SERVER['HTTP_REFERER']);
        }
        include_once("./includes/admin_edit_user.inc.php");

      }
      if ($_GET['page'] == 'delete_user') {
        if (isset($_POST["confirm_del_user"])) {
        }
        include_once("./includes/admin_delete_user.inc.php");

      }
      if ($_GET['page'] == 'my_data') {
        if (isset($_POST["change"])) {
        }
        include_once("./includes/edit_user.inc.php");

      }
      if ($_GET['page'] == 'delete_my_account') {
        if (isset($_POST["confirm_del_user"])) {
        }
        include_once("./includes/delete_user.inc.php");

      }
    }
    //Standartmäßig sollen die Übersicht über alle Nutzer und die Filteroptionen angezeigt werden
    if (!isset($_GET['page'])) {
      include_once("./includes/admin_interface.inc.php");
    }
  } else
    weiterleiten("user.php");

} else {
  /***
  Wenn noch kein Login statt fand, dann Weiterleitung zur Login-Seite
  ***/
  //if (!isset($_GET['page'])) {
  weiterleiten("index.php?page=login");
}
?>

<?php
//Footer einbinden
include_once("./includes/footer.inc.php");
?>