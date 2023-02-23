<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include("./includes/header.inc.php");


echo "<h1>Benutzerkonto</h1><hr><br>" .
  "<div class='pers_area'>";



if (isset($_SESSION["name"])) { //prüfen, ob eine benannte Session vorhanden ist

/***
  Infos zum Login anzeigen
 ***/
  if (isset($_SESSION["z"]))   // Zugriffszähler existiert
    $_SESSION["z"] = $_SESSION["z"] + 1;
  else
    $_SESSION["z"] = 1;       //Zugriffszähler ist neu
  echo "<div> Anzahl Seitenaufrufe: " . $_SESSION["z"] . "<br>";
  
  //array mit regulären Ausdrücken zum Umstellen des mit Now() erzeugten Datums: 
  //(20)(zahl, 2-stellig)-(zahl, 1-2-stellig)-(zahl, 1-2-stellig)leerzeichen(zahl, 2-stellig):(zahl, 1-2-stellig):(zahl, 1-2-stellig)
  $date_regex = array(
    '/(20)(\d{2})-(\d{1,2})-(\d{1,2})\s(\d{2}):(\d{1,2}):(\d{1,2})/'
  );
 
  $date_replace = array('\4.\3.\1\2 \5:\6 Uhr'); //array mit Ersatzsymbolen/zeichen: Angabe der nummerierten Ausdrücke, zuerst der 4., dann der 3. etc. der letzte wird weg gelassen, statt dessen "Uhr" eingefügt
  echo "Login: " . preg_replace($date_regex, $date_replace, $_SESSION["date"]);
  echo "<br>Login: " . $_SESSION["date"] . "</div>";


/***
  Namen und Kürzel anpassen
 ***/

include("./includes/personal_avatar.inc.php"); //Datei mit der Funktion zum Erstellen der Kürzel einbinden
  $pers_avatar = personal_avatar($_SESSION["firstname"], $_SESSION["lastname"]); //Parameter an die Funktion senden
  // die return Werte werden mithilfe des Index aus dem Array abgerufen
  echo  "<div><div class='avatar'>" . $pers_avatar[2] . "</div>" . $pers_avatar[0] . " " .  $pers_avatar[1] . 
        "<form action='logout.php'>
        <button type='submit' name='logout'>Logout</button>
        </form></div>".
        "</div><hr>";
        
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