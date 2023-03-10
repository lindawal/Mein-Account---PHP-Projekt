<?php

include_once("./includes/dyn_Weiterleitung.inc.php");
include_once("./classes/user_edit.class.php");
include_once("./classes/formular.class.php");

echo "<div class='user_card'><h2 class='user-section-header'>Nutzerdaten löschen</h2>";

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
   echo "<div class='errorbox'>Soll der Account wirklich gelöscht werden?</div><br><br>
   <form method='post' class='userdataform'>";
   $edit_user_form->input_disabled('firstname', 'lastname', 'username', 'mail');
   $edit_user_form->input_hidden_id();
   echo "<p></p><button type='submit' name='del_user' value='' class='change_user_Btn'>Account löschen</button></form>";
   echo "<form action='";
   echo linkTo("admin.php", "?page=change_user");
   echo "' method='post' class='userdataform'>";
   echo "<p></p><button type='submit' name='cancel' value='' class='change_user_Btn'>abbrechen</button>";
   $edit_user_form->input_hidden_id();
}
echo "</form>";

//zurück Button
$last_uri = get_last_url();
echo "<br><a href='"
   . $last_uri . "'>zurück</a>";

?>
</div>