<?php

$search_input = ""; //Suchparameter standartmäßig auf leeren String setzen
if (isset($_GET["search"])) { //wenn Suchparameter gesendet wurde diesen umwandeln
  $search_input = htmlentities($_GET["search"]);
}

$search_area = "lastname"; //Suchbereich Default-Wert
if (isset($_GET["search_area"])) {
  $search_area = $_GET["search_area"];
}

$sort = "lastname"; //Sortierung Default-Wert
if (isset($_GET["sort"])) {
  $sort = $_GET["sort"];
}

//Formular zum Angeben der Suchparameter
echo "<div class='user_area_card'>
<h2 class='user-section-header'>Meine Kontakte</h2>
<div class='user_card_legend'>
<form action='user.php' method='get' class='myForm'>";
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
    </form>";

//Datei einbinden um Daten aus der Datenbank zu laden ->
//als Variablen werden die Suchparameter gesendet
include_once("./classes/all_users.class.php");
include_once("./classes/view.class.php");
$users_contacts = new All_Users_Data();
$users_contacts->load_contact_data($_SESSION["user_id"], $sort);
echo $users_contacts->data_length . " Ergebnisse</div>" .
  "<div class='all-users'>";

$contacts_view = new All_Users_View($users_contacts);

$contacts_view->contacts_as_grid();


?>