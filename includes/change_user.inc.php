<?php

include_once("./includes/dyn_Weiterleitung.inc.php");
include_once("./includes/class_user.php");

echo "<div class='user-section-header'><h2>Nutzerdaten ändern</h2></div>";

$id = $_POST["id"];
$cur_user = new User($id);
$cur_user_view = new View($id);

if (isset($_POST["safe_changes"])) {
   if (
      $cur_user->change_data(
         $_POST["fn"],
         $_POST["ln"],
         $_POST["un"],
         $_POST["em"]
      )
   ) {
      echo "<h3>Nutzerdaten geändert</h3><br><br>";

      $cur_user_view->load_data();
      $cur_user_view->show_as_formular();
   } else
      echo "<h3>Fehler, Nutzerdaten konnten nicht geändert werden<h3><br><br>";
}
if (isset($_POST["confirm_del_user"])) {
   $cur_user_view->load_data();
   $cur_user_view->show_as_table();

}
if (isset($_POST["del_user"])) {
   if ($cur_user->delete_data()) {
      echo "Der Account wurde gelöscht<br><br>";
   } else
      echo "Fehler, der Account konnte nicht gelöscht werden<br><br>";
}

if ((isset($_POST["change"])) || (isset($_POST["cancel"]))) {
   $cur_user_view->load_data();
   $cur_user_view->show_as_formular();
}


//zurück Button
echo "<br><a href='";
linkTo("index.php");
echo "'>zurück</a>";



?>