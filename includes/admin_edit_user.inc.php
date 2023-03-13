<?php

//bindet Hilfsfunktionen ein, die Weiterleitungen und Links dynamisch an die aktuelle URL anpassen 
include_once("./includes/dyn_Weiterleitung.inc.php");
//bindet die benötigten Klassen ein
include_once("./classes/user_edit.class.php");
include_once("./classes/formular.class.php");

echo "<div class='user_card'><h2 class='user-section-header'>Nutzerdaten ändern</h2>";

//User Id aus dem unsichtbaren Formularfeld erfassen und zum Laden der Daten an das Objekt $cur_user übergeben   
$user_id = $_POST["user_id"];
$cur_user = new User_Edit($user_id);

if (isset($_POST["safe_changes"])) {

   //konvertieren der Formulardaten      
   $cur_user->convert_data(
      $_POST["firstname"],
      $_POST["lastname"],
      $_POST["username"],
      $_POST["mail"]
   );

   //Prüfen der eingegebenen Formulardaten
   $validate_Err = $cur_user->validate_data();

   $Err_Info = $validate_Err['firstname'];
   $Err_Info .= $validate_Err['lastname'];
   $Err_Info .= $validate_Err['username'];
   $Err_Info .= $validate_Err['mail'];

   //wenn keine Fehlermeldung vorhanden ist, werden die Daten an die Funktion change_data() übergeben
   if (empty($Err_Info)) {
      if (
         $cur_user->change_data()
      ) { //Änderung erfolgreich
         echo "<h3>Nutzerdaten geändert</h3><br><br>";

      } else //Änderung nicht erfolgreich
         echo "<h3>Fehler, Nutzerdaten konnten nicht geändert werden<h3><br><br>";
   } else {
      // Fehlermeldungen ausgeben:
      echo "<div class='errorbox'>" . $Err_Info . "</div>";
   }
}

//Formular mit den Nutzerdaten zur Kontrolle anzeigen
$cur_user->load_data($user_id);
$edit_user_form = new Form($cur_user);

echo "<form method='post' class='userdataform'>";
//Formularfelder mit den Nutzerdaten
$edit_user_form->input_fields('firstname', 'lastname', 'username');
$edit_user_form->input_mail();
//ein verstecktes Feld mit der User ID ist mit jedem Button verbunden, so dass diese bei jeder Aktion übertragen wird
$edit_user_form->input_hidden_id();
//Bestätigungsbutton
echo "<input type='submit' name='safe_changes' value='speichern' class='change_user_Btn'>
    <input type='reset' class='change_user_Btn'>
    </form>";
//Abbrechen-Button
echo "<form action='";
echo linkTo("admin.php", "?page=delete_user");
echo "' method='post' class='userdataform'>
            <input type='submit' name='confirm_del_user' value='Account löschen' class='change_user_Btn'>";
$edit_user_form->input_hidden_id();
echo "</form>";

//zurück Button
$last_uri = get_last_url();
echo "<br><a href='"
   . $last_uri . "'>zurück</a>";

?>

</div>