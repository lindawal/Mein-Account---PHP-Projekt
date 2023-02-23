<?php
/***
Prüfen der eingegebenen Formulardaten
 - Ausgabe vor dem eigentlichen Formular, damit Variablen im Formular mit jeweils aktuellem Wert angezeigt werden
 ***/

//Variablen für die Eingabedaten und Fehlermeldungen definieren
$firstnameErr = $lastnameErr = $usernameErr = $mailErr = "";
$firstname = $lastname = $username = $mail = "";

//if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["new_user"])) 
if ($_SERVER["REQUEST_METHOD"] == "POST") {    //wenn das Formular abgeschickt wurde:

  //Eingabedaten bereinigen (Leerzeichen + Slashes entfernen, Sonderzeichen konvertieren)
  $firstname = convert_input($_POST["firstname"]);
  $lastname = convert_input($_POST["lastname"]);
  $username = convert_input($_POST["username"]);
  $mail = convert_input($_POST["mail"]);

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
  if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]+$/', $mail)) {
    $mailErr = "Keine gültige E-Mail-Adresse";
  }

  //wenn keine Fehlermeldung vorhanden ist, werden die Daten an die Funktion registrieren() übergeben
  if ((empty($firstnameErr)) && (empty($lastnameErr)) && (empty($usernameErr)) && (empty($mailErr))) {
    include("./includes/new_user_registrieren.inc.php");

    $new_reg = registrieren(
      $firstname,
      $lastname,
      $username,
      $mail
    );

    $firstname = $lastname = $username = $mail = ""; //Variablen-Werte löschen, damit das Formular sich leert

    echo "<br>Der User " . convert_input($_POST["firstname"]) . " " . convert_input($_POST["lastname"]) . ", wurde erfolgreich angelegt.";
  } else {
    // Fehlermeldungen ausgeben:
    echo  "<p>" . $firstnameErr . "</p>" .
      "<p>" . $lastnameErr . "</p>" .
      "<p>" . $usernameErr . "</p>" .
      "<p>" . $mailErr . "</p>";
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


echo "<form action='http://localhost/linda/php/index.php?page=new_user' method='POST'><input placeholder='Vorname' name='firstname' value='" . $firstname . "' required='required'>
        <input placeholder='Nachname' name='lastname' value='" . $lastname . "' required='required'>
        <input placeholder='Benutzername' name='username' value='" . $username . "' required='required'>
        <input type='email' placeholder='E-Mail' name='mail' value='" . $mail . "' required='required'>
        <input type='Submit' name='reg_button' value='hinzufügen'>
      </form>";
          
          //echo $_SERVER['HTTP_REFERER'];
           echo "<button type='button' name='back' class='sort_button'><a href='";
   linkTo("index.php");
   echo "'>zurück</a></button><br>";

?>