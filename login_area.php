<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include("./includes/header.inc.php");
?>

<div class="login_area">
  <?php
  echo "<h1>Login</h1><hr><br>";

/***
Login-Formular anzeigen
***/

  if (!isset($_SESSION["name"])) { //wenn noch kein Session Name gesetzt ist (und somit noch kein Login statt fand) soll die Login Maske angezeigt werden
    echo "<form action='' method='POST'>
        <input placeholder='Benutzername' name='username'>
        <input type='password' placeholder='Passwort' name='passwort'>
        <input type='Submit' value='Login' >
      </form>";

/***
Login-Daten prüfen
***/

    if ((isset($_POST["username"])) && (isset($_POST["passwort"]))) { //wenn Daten ins Loginformular eingegeben und versendet wurden, startet die Abfrage, ob diese richtig sind mit der Funktion "verify" aus der Datei pw_verify.inc.php
      include("./includes/pw_verify.inc.php");
      $pw_check = verify(
        "logindaten_neu",
        "benutzer",
        htmlentities($_POST["username"]),
        htmlentities($_POST["passwort"])
      );
      if ($pw_check[0] == true) { //der erste returnwert gibt true oder false wieder. Wenn die Eingabe korrekt war, dann:
        $_SESSION["name"] = $_POST["username"]; //den gesendeten Benutzernamen als Sessionnamen weiter verwenden
        $_SESSION["date"] = $pw_check[3]; //das Logindatum speichern
        $_SESSION["firstname"] = $pw_check[1];
        $_SESSION["lastname"] = $pw_check[2];

/***
zum Benutzer-Account weiterleiten oder Fehlermeldung anzeigen
***/

        include("./includes/dyn_Weiterleitung.inc.php");
        weiterleiten("user_area.php");
      } else {
        echo "Der eingegebene Username oder das Passwort war nicht korrekt."; //Fehlermeldung, wenn Passwort inkorrekt
      }
    }
  } else { //wenn Sessionname bei Seitenaufruf bereits vorhanden ist, dann direkt zum Benutzer-Account wechseln
    include("./includes/dyn_Weiterleitung.inc.php");
    weiterleiten("user_area.php");
  }

  echo   "<br>Noch keine Zugangsdaten? 
          <a href='register_area.php'>Zur Registrierung gehts hier entlang...</a></p>";
  ?>
</div>

<?php
//Footer einbinden
include("./includes/footer.inc.php");
?>