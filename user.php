<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include("./includes/header.inc.php");

include_once("./includes/dyn_Weiterleitung.inc.php");


if (isset($_SESSION["name"])) { //prüfen, ob eine benannte Session vorhanden ist
  if ($_SESSION["admin"] == false) {

    //Begrüßung
    echo "Hallo " . $_SESSION["firstname"] . "!<br>";

    if (isset($_GET['page'])) {

      if ($_GET['page'] == 'my_data') {
        include_once("./includes/edit_user.inc.php");
      }

      if ($_GET['page'] == 'delete_my_acount') {
        include_once("./includes/delete_user.inc.php");
      }

      if ($_GET['page'] == 'my_contacts') {
        include_once("./includes/my-contacts.inc.php");

      }
    }
    //Standartmäßig sollen die Übersicht über alle Nutzer und die Filteroptionen angezeigt werden
    if (!isset($_GET['page'])) {
      include_once("./includes/user_interface.inc.php");
    }
  } else
    weiterleiten("admin.php");
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
include("./includes/footer.inc.php");
?>