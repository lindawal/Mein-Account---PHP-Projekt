<?php

include_once("./classes/new_member.class.php");

echo "<div class='user_card'><h2 class='user-section-header'>Neuen Nutzer anlegen</h2>";

$new_user = new New_Member();

if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn das Formular abgeschickt wurde:

  $new_user->__construct($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["mail"], $_POST["password"]);

  //Prüfen der eingegebenen Formulardaten
  $validate_Err = $new_user->validate_data();
  $exist_username_Err = $new_user->username_exist();
  $exist_mail_Err = $new_user->mail_exist();

  $Err_Info = $exist_mail_Err;
  $Err_Info .= $exist_username_Err;
  $Err_Info .= $validate_Err['firstname'];
  $Err_Info .= $validate_Err['lastname'];
  $Err_Info .= $validate_Err['username'];
  $Err_Info .= $validate_Err['mail'];
  $Err_Info .= $validate_Err['password'];
  
  //wenn keine Fehlermeldung vorhanden ist, werden die Daten an die Funktion registrieren() übergeben

  //if ((empty($validate_Err[0])) && (empty($validate_Err[1])) && (empty($validate_Err[2])) && (empty($validate_Err[3])) && (empty($validate_Err[4])) && (empty($username_Err))) {
  if (empty($Err_Info)){

    $new_user->signup();

    echo "<br>Das Mitglied <span>" . $_POST["firstname"] . " " . $_POST["lastname"] . "</span> wurde erfolgreich angelegt.";
  } else {
    // Fehlermeldungen ausgeben:
    echo  "<div class='errorbox'>" . $Err_Info . "</div>";
  }

}

//Formular anzeigen
echo "<form action='" . htmlspecialchars($_SERVER['REQUEST_URI']) . "' method='POST' class='userdataform'>";
include_once("./classes/formular.class.php");
$form = new Form($new_user);
$form->input_fields('firstname', 'lastname', 'username' );
$form->input_mail();
$form->input_password();
echo    "<p></p><input type='Submit' name='reg_button' value='hinzufügen'>
      </form>";


?>

<a href=' <?PHP
linkTo("admin.php", ""); ?> '>zurück</a><br>
</div>