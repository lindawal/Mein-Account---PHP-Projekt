<?php

include_once("./includes/dyn_Weiterleitung.inc.php");
include_once("./classes/user_edit.class.php");
include_once("./classes/formular.class.php");
echo "<div class='user_area_card'><h2 class='user-section-header'>Meine Daten</h2>";
/***
Infos zum Login anzeigen
***/include_once("./classes/view.class.php");
$cur_user_view = new View();
$avatar = $cur_user_view->avatar($_SESSION["firstname"], $_SESSION["lastname"]);
echo "<div class='myaccount'><div><div class='avatar'>" . $avatar . "</div> " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . "</div>";

if (isset($_SESSION["z"])) // Zugriffszähler existiert
   $_SESSION["z"] = $_SESSION["z"] + 1;
else
   $_SESSION["z"] = 1; //Zugriffszähler ist neu
echo "<div> Anzahl Seitenaufrufe: " . $_SESSION["z"] . "<br>";


//Datum formatieren
$get_login_date = $cur_user_view->format_date($_SESSION["date"]);
echo "Login: " . $get_login_date .
   "<br>";
//Namen und Avatar anzeigen

echo "</div>" .
   "<div><form action='logout.php'>
        <button type='submit' name='logout'>Logout</button>
        </form></div></div></div>";

//Box zum Löschen der User Daten        

echo "<div class='user_area_card'><h2 class='user-section-header'>Nutzerdaten löschen</h2>";

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

if (!isset($_POST["del_user"])) {

   $cur_user->load_data($user_id);
   $edit_user_form = new Form($cur_user);
   echo "Soll der Account wirklich gelöscht werden?<br>
   <form method='post' class='userdataform'>";
   $edit_user_form->input_disabled('firstname', 'lastname', 'username', 'mail');
   $edit_user_form->input_hidden_id();
   echo "<button type='submit' name='del_user' value='' class='change_user_Btn'>Account löschen</button></form>";
   echo "<form action='";
   echo linkTo(get_filename($_SERVER['PHP_SELF']), "?page=my_data");
   echo "' method='post' class='userdataform'>";
   echo "<button type='submit' name='cancel' value='' class='change_user_Btn'>abbrechen</button>";
   $edit_user_form->input_hidden_id();
}
echo "</form>";

//zurück Button
$last_uri = get_last_url();
echo "<br><a href='"
   . $last_uri . "'>zurück</a>";

?>
</div>
</div>