<?php

echo "<div class='user_area_card'><h2 class='user-section-header'>Meine Daten</h2>";

//bindet die benötigte Klasse ein
include_once("./classes/view.class.php");
$cur_user_view = new View();

//Namen und Avatar anzeigen
echo "<div class='myaccount'>";
$avatar = $cur_user_view->get_avatar_symbol($_SESSION["firstname"], $_SESSION["lastname"]);
echo $avatar;

if (isset($_SESSION["z"])) // Zugriffszähler existiert
  $_SESSION["z"] = $_SESSION["z"] + 1;
else
  $_SESSION["z"] = 1; //Zugriffszähler ist neu
echo "<div> Anzahl Seitenaufrufe: " . $_SESSION["z"] . "<br>";


//Datum formatieren
$get_login_date = $cur_user_view->format_date($_SESSION["date"]);
echo "Login: " . $get_login_date .
  "<br>";


echo "</div>" .
  "<div><form action='logout.php'>
        <button type='submit' name='logout' class='user_area_button'>Logout</button>
        </form></div></div></div>";

?>