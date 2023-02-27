<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include("./includes/header.inc.php");


echo "<h1>Benutzerkonto</h1><hr><br>" .
  "<div class='pers_area'>";



if (isset($_SESSION["name"])) { //prüfen, ob eine benannte Session vorhanden ist
/***
  Begrüßung
 ***/      

  echo  "Hallo " . $_SESSION["firstname"] .  " " .  $_SESSION["lastname"] .  ",<br>hier siehst du deine persönlichen Inhalte:";


 

  } else {

   /***
  Wenn noch kein Login statt fand, dann Weiterleitung zur Login-Seite
  ***/
    
    include("./includes/dyn_Weiterleitung.inc.php");
    weiterleiten("login_area.php");
  }
  ?>

<?php
//Footer einbinden
include("./includes/footer.inc.php");
?>