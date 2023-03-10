<?php

include_once("./includes/dyn_Weiterleitung.inc.php");
include_once("./classes/user_edit.class.php");
include_once("./classes/formular.class.php");


include_once("my-data.inc.php");

//Bereich zum Ändern der User Daten
echo "<div class='user_area_card'><h2 class='user-section-header'>Nutzerdaten ändern</h2>";

//KLasse User_Edit laden und user ID übergeben
$user_id = $_SESSION["user_id"];
$cur_user = new User_Edit($user_id);

if (isset($_POST["safe_changes"])) {

   //konvertieren der Formulardaten      
   $cur_user->convert_data(
      $_POST["firstname"],
      $_POST["lastname"],
      $_POST["username"],
      $_POST["mail"],
      $_POST["password"]
   );

   //Prüfen der eingegebenen Formulardaten
   $validate_Err = $cur_user->validate_data();

   $Err_Info = $validate_Err['firstname'];
   $Err_Info .= $validate_Err['lastname'];
   $Err_Info .= $validate_Err['username'];
   $Err_Info .= $validate_Err['mail'];
   $Err_Info .= $validate_Err['password'];


   //wenn keine Fehlermeldung vorhanden ist, werden die Daten an die Funktion change_data() übergeben
   if (empty($Err_Info)) {
      if (
         $cur_user->change_data()
      ) { //Änderung erfolgreich
         $user_data = $cur_user->get_data();
         $_SESSION["name"] = $user_data["user"];
         $_SESSION["firstname"] = $user_data["first"];
         $_SESSION["lastname"] = $user_data["last"];

         echo "<h3>Nutzerdaten geändert</h3><br><br>";

      } else //Änderung nicht erfolgreich
         echo "<div class='errorbox'><h3>Fehler, Nutzerdaten konnten nicht geändert werden<h3><br><br></div>";
   } else {
      // Fehlermeldungen ausgeben:
      echo "<div class='errorbox'>" . $Err_Info . "</div>";
   }
}

//Formular zum Ändern der Daten anzeigen




echo "<form method='post' class='userdataform'>";
$cur_user->load_data($user_id);
$edit_user_form = new Form($cur_user);
$edit_user_form->input_fields('firstname', 'lastname', 'username');
$edit_user_form->input_mail();
$edit_user_form->input_password();
$edit_user_form->input_hidden_id();
echo "<input type='submit' name='safe_changes' value='speichern' class='change_user_Btn'>
    <input type='reset' class='change_user_Btn'>
    </form>
    <form action='";
echo linkTo(get_filename($_SERVER['PHP_SELF']), "?page=delete_my_account");
echo "' method='post' class='userdataform'>
            <input type='submit' name='confirm_del_user' value='Account löschen' class='change_user_Btn'>";
$edit_user_form->input_hidden_id();
echo "</form>";

//zurück Button
//include_once("./includes/suchparameter.php");
$last_uri = get_last_url();
echo "<br><a href='"
   . $last_uri . "'>zurück</a>";

?>

</div>