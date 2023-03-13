<?php

//bindet Hilfsfunktionen ein, die Weiterleitungen und Links dynamisch an die aktuelle URL anpassen 
include_once("./includes/dyn_Weiterleitung.inc.php");
//bindet die benötigten Klassen ein
include_once("./classes/user_edit.class.php");
include_once("./classes/formular.class.php");

//Laden des Templates mit der Übersicht der Daten des aktuell eingeloggten Users
include_once("my-data.inc.php");

//Bereich mit dem Formular zum Löschen der Daten
echo "<div class='user_area_card'><h2 class='user-section-header'>Nutzerdaten löschen</h2>";

//User Id aus dem unsichtbaren Formularfeld erfassen und zum Laden der Daten an das Objekt übergeben      
$user_id = $_POST["user_id"];
$cur_user = new User_Edit($user_id);

if (isset($_POST["del_user"])) {
   if ($cur_user->delete_data()) {
      echo "<h3>Der Account wurde gelöscht</h3><br>";
   } else {
      $edit_user_form = new Form($cur_user);
      echo "Fehler, der Account konnte nicht gelöscht werden<br><br>";
   }
}

//sofern der Button zum löschen noch nicht gedrückt wurde, soll das Formular mit den NUtzerdaten zur Kontrolle angezeigt werden
//ein verstecktes Feld mit der User ID ist mit jedem Button verbunden, so dass diese bei jeder Aktion übertragen wird
if (!isset($_POST["del_user"])) {

   $cur_user->load_data($user_id);
   $edit_user_form = new Form($cur_user);
   echo "Soll der Account wirklich gelöscht werden?<br>
   <form method='post' class='userdataform'>";
   //Formularfelder mit den Nutzerdatne
   $edit_user_form->input_disabled('firstname', 'lastname', 'username', 'mail');
   $edit_user_form->input_hidden_id();
   echo "<button type='submit' name='del_user' value='' class='change_user_Btn'>Account löschen</button></form>";
   //Abbrechen-Button
   echo "<form action='";
   echo linkTo(get_filename($_SERVER['PHP_SELF']), "?page=my_data");
   echo "' method='post' class='userdataform'>";
   $edit_user_form->input_hidden_id();
   echo "<button type='submit' name='cancel' value='' class='change_user_Btn'>abbrechen</button>";
   echo "</form>";
}


//zurück Button
$last_uri = get_last_url();
echo "<br><a href='"
   . $last_uri . "'>zurück</a>";

?>
</div>
</div>