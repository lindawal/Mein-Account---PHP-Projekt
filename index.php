<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include("./includes/header.inc.php");
?>

<script>
   //beim Klick des Resetbuttons soll die Seite ohne die Search- & Sort-Parameter neu geladen werden
  function resetPage() {
    let urlObj = new URL(window.location.href); //URL holen
    urlObj.search = ''; //Parameter löschen
    let cleanUrl = urlObj.toString(); //URL in STring umwandeln
    location.replace(cleanUrl);
  }
</script>
<?php
include_once("./includes/dyn_Weiterleitung.inc.php");


if (isset($_SESSION["name"])) { //prüfen, ob eine benannte Session vorhanden ist
 if (isset($_GET['page'])) {
    if ($_GET['page'] == 'login_area') {
      weiterleiten("index.php");
    }
   }

/***
  Begrüßung
 ***/

  echo "Hallo " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . ",<br>hier siehst du deine persönlichen Inhalte:";


  //wenn der Parameter page gesendet wurde und auf "new_user" gesetzt ist, soll die Datei zum User Anlegen eingebunden werden
  if (isset($_GET['page'])) {
    if ($_GET['page'] == 'new_user')
      include_once("./new_user.php");

    //wenn der Button mit dem Namen change gesendet wurde, soll die Datei zum Ändern der Userdaten eingebunden werden
    if ($_GET['page'] == 'change_user') {
      include_once("./includes/change_user.inc.php");

      // if (isset($_POST["safe_changes"])) {
// include("./includes/change_user_db.inc.php");
// }
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
    weiterleiten("index.php?page=login_area");
  }
  if (isset($_GET['page'])) {
    if ($_GET['page'] == 'login_area') {
      include("./includes/login_area.inc.php");
    }
    if ($_GET['page'] == 'register_area') {
      include("./includes/register_area.inc.php");
    }
  }

}
?>

<?php
//Footer einbinden
include("./includes/footer.inc.php");
?>