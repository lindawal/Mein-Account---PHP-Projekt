<?php
/* Session-Start oder Session-Wiederaufnahme */
session_start();

//Header einbinden
include("./includes/header.inc.php");

echo "<div><h1>Benutzerkonto anlegen</h1><hr><br>";

/***
Prüfen der eingegebenen Formulardaten
 - Ausgabe vor dem eigentlichen Formular, damit Variablen im Formular mit jeweils aktuellem Wert angezeigt werden
***/

//Variablen für die Eingabedaten und Fehlermeldungen definieren
$firstnameErr = $lastnameErr = $usernameErr = $passwortErr = "";
$firstname = $lastname = $username = $passwort = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {    //wenn das Formular abgeschickt wurde:
  //Eingabedaten bereinigen (Leerzeichen + Slashes entfernen, Sonderzeichen konvertieren)
  $firstname = convert_input($_POST["firstname"]);
  $lastname = convert_input($_POST["lastname"]);
  $username = convert_input($_POST["username"]);
  $passwort = convert_input($_POST["passwort"]);

  //im Vor-, Nach- und Usernamen erlaubte Zeichen: A-Z (mind. 1x Pflicht), ÜÄÖ (case insensitiv), Leerzeichen zwischen Doppelnamen und ,.-
  //Username kann außerdem Zahlen enthalten
  if (!preg_match('/^[a-z][a-zäöü ,.-]+$/i', $firstname)) { //Prüfung ob eingegebene Daten valide sind
    $firstnameErr = "Der Vorname darf nur Buchstaben (A - Z, Ü, Ä, Ö) und Sonderzeichen (,.-) enthalten."; //Fehlermeldung
  }
  if (!preg_match('/^[a-z][a-zäöü ,.-]+$/i', $lastname)) {
    $lastnameErr = "Der Nachname darf nur Buchstaben (A - Z, Ü, Ä, Ö) und Sonderzeichen (,.-) enthalten.";
  }
  if (!preg_match('/^[a-z][\da-zäöü .-_]{3,}$/i', $username)) {
    $usernameErr = "Der Username muss mindestens aus 4 Zeichen bestehen und darf nur Buchstaben (A - Z, Ü, Ä, Ö), Zahlen und Sonderzeichen (.-_) enthalten.";
  }
  if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!?+.*-])(?!.*\s).{6,15}/', $passwort)) {
    $passwortErr = "Das Passwort muss aus 6 - 15 Zeichen bestehen und folgendes enthalten: Sonderzeichen (!?+.*-), Zahl, Groß- und einen Kleinbuchstaben.";
  }
  
  //wenn keine Fehlermeldung vorhanden ist, werden die Daten an die Funktion registrieren() übergeben
  if ((empty($firstnameErr)) && (empty($lastnameErr)) && (empty($usernameErr)) && (empty($passwortErr))) { 
    include("./includes/neu_registrieren.inc.php");

    $new_reg = registrieren(
      $firstname,
      $lastname,
      $username,
      $passwort
    );

    $firstname = $lastname = $username = $passwort = ""; //Variablen-Werte löschen, damit das Formular sich leert

    echo "<br>Vielen Dank " . convert_input($_POST["firstname"]) . ", du bist jetzt registriert. <br> In <span id='counterdiv'></span> Sekunden wirst du zum Loginbereich weitergeleitet<br>";
    echo "<script> 
    setTimeout(function(){location.href='login_area.php'} , 10000);   
    let counter = 11;
    let Interval1 = setInterval(function () {
    counter = counter - 1;
    document.getElementById('counterdiv').innerHTML = counter}, 1000);        
      </script>"; //Javascript-WL zu User Area nach 10 Sekunden mit Countdown 

  } else {
    // Fehlermeldungen ausgeben:
    echo  "<p>" . $firstnameErr . "</p>" .
          "<p>" . $lastnameErr . "</p>" .
          "<p>" . $usernameErr . "</p>" .
          "<p>" . $passwortErr . "</p>";
  }
}

/***
Funktion zum Konvertieren der Eingabedaten
 ***/

function convert_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/***
Registrierungs-Formular anzeigen
- wird nur angezeigt, wenn noch kein Login erfolgt ist, sonst Weiterleitung zu User Area
- wenn bereits Daten gesendet wurden, aber nicht valide waren, werden diese im Formular angezeigt (Affenformular)
 ***/

if (!isset($_SESSION["name"])) {
  echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST'>
        <input placeholder='Vorname' name='firstname' value='" . $firstname . "' required='required'>
        <input placeholder='Nachname' name='lastname' value='" . $lastname . "' required='required'>
        <br>
        <input placeholder='Benutzername' name='username' value='" . $username . "' required='required'>
        <input type='password' placeholder='Passwort' name='passwort' required='required'>
        <input type='Submit' name='reg_button' value='registrieren'>
      </form>" .
    "<br> Du hast bereits Zugangsdaten? 
          <a href='login_area.php'>Zum Login gehts hier entlang...</a></p>";
} else {
  include("./includes/dyn_Weiterleitung.inc.php");
  weiterleiten("user_area.php");
}

?>

</div>

<?php
//Footer einbinden
include("./includes/footer.inc.php");
?>