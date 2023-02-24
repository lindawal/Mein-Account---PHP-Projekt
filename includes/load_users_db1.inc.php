<?php
//Header einbinden
include("./includes/header.inc.php");
?>

<script>
  //beim Klick der Radiobuttons zum Sortieren der Suchergebnisse soll sofort die Neusortierung ausgelöst werden
  function validateRadio() {
    document.getElementById('myForm').submit();
  };
  //beim Klick des Resetbuttons soll die Seite ohne die Search- & Sort-Parameter neu geladen werden
  function resetPage() {
    let urlObj = new URL(window.location.href);
    urlObj.search = '';
    let cleanUrl = urlObj.toString();
    location.replace(cleanUrl);
  }
</script>



<?php
include_once("./includes/dyn_Weiterleitung.inc.php");

//wenn der Parameter page gesendet wurde und auf "new_user" gesetzt ist, soll die Datei zum User Anlegen eingebunden werden

//wenn der Button mit dem Namen change gesendet wurde, soll die Datei zum Ändern der Userdaten eingebunden werden
if (isset($_GET['page'])) {
  if ($_GET['page'] == 'new_user')
    include("./new_user.php");


  if ($_GET['page'] == 'change_user') {
    include("./includes/change_user.inc.php");

    //   if (isset($_POST["safe_changes"])) {
// include("./includes/change_user_db.inc.php");
// }
  }
}
//Standartmäßig sollen die Übersicht über alle Nutzer und die Filteroptionen angezeigt werden
if (!isset($_GET['page'])) {
  //Button um neuen User anzulegen
  echo "<button type='submit' name='new_user'><a href='";
  linkTo("index.php?page=new_user");
  echo "'>Neuen Nutzer anlegen</a></button><hr>";

  /**  ANCHOR Filteroptionen
   ***/

  $search_input = ""; //Suchparameter standartmäßig auf leeren String setzen
  if (isset($_GET["search"])) { //wenn Suchparameter gesendet wurde diesen umwandeln
    $search_input = htmlentities($_GET["search"]);
  }

  $searchArea_input = "lastname"; //Suchbereich Default-Wert
  if (isset($_GET["searchArea"])) {
    $searchArea_input = $_GET["searchArea"];
  }

  $sort = "lastname"; //Sortierung Default-Wert
  if (isset($_GET["sort"])) {
    $sort = $_GET["sort"];
  }

  //Formular zum Angeben der Suchparameter
  echo "<form action='index.php' method='get' class='myForm'>
      <input type='radio' name='searchArea' value='lastname'> Nachname
      <input type='radio' name='searchArea' value='firstname'> Vorname
      <input type='radio' name='searchArea' value='username'> Username
      <input type='radio' name='searchArea' value='mail'> E-Mail<br>
      Suche: <input name='search' value='" . $search_input . "'>
      <input type='submit' class='sort_button'>
      <input type='button' onClick='resetPage();' value='reset' class='sort_button'>
      <hr>";

      // Selectfelder für die Sortierung
      // Wenn diese angeklickt werden, wird die Änderung mit Hilfe eines Javascript onchange Events sofort ausgelöst
      // die aktive Option wird mit Hilfe einer If-Anweisung auf "selected" gesetzt
  echo "<label for='sort'>Sortierung:</label>
      <select id='sort' name='sort' onchange='this.form.submit()'>
      <option value='firstname'";
        if ($sort == "firstname") {
        echo " selected";
        }
      echo ">Vorname </option>

      <option value='lastname'";
        if ($sort == "lastname") {
        echo " selected";
        }
      echo ">Nachname </option>
        
      <option value='username'";
        if ($sort == "username") {
        echo " selected";
        }
      echo ">Username</option>
  
      <option value='mail'";    
        if ($sort == "mail") {
          echo " selected";
        }
      echo ">E-Mail</option>
      </select>
      </form>
      
  <div class='all-users'>
  ";

  //Datei einbinden um Daten aus der Datenbank zu laden ->
//als Variablen werden die Suchparameter gesendet
  include("./includes/load_users_db.inc.php");
  load_users_db(
    "logindaten_neu",
    "user",
    $searchArea_input,
    $sort,
    $search_input
  );
}
?>


<?php
//Footer einbinden
include("./includes/footer.inc.php");
?>