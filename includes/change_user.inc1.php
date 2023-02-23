<?php

include_once("./includes/dyn_Weiterleitung.inc.php");
include_once("./includes/class_user.php");

echo "<h2>Nutzerdaten ändern</h2><hr><br>";

$cur_user = new User();

if (isset($_POST["safe_changes"])) {
  if( $cur_user->change_data(
      $_POST["id"],
      $_POST["fn"],
      $_POST["ln"],
      $_POST["un"],
      $_POST["em"]
   ))
   {
      echo "<h3>Nutzerdaten geändert</h3><br><br>";
      $id = $cur_user->id;
      
      $cur_user->data($id);
      $cur_user->show();
   } else
      echo "<h3>Fehler, Nutzerdaten konnten nicht geändert werden<h3><br><br>";
}
if (isset($_POST["del_user"])) {
   if (
      $cur_user->delete_data($_POST["id"])
   ) {
      echo "Der Account wurde gelöscht<br><br>";
   } else
      echo "Fehler, Account konnte nicht gelöscht werden<br><br>";
}

if (isset($_POST["change"])) {

   $id = intval($_POST["change"]);

   $cur_user = new User();
   $cur_user->data($id);
   $cur_user->show();
}


//zurück Button
echo "<button type='button' name='back' class='sort_button'><a href='";
linkTo("db_tabelle_filtern.php");
echo "'>zurück</a></button><br>";



?>