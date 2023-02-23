<?php

/**
 * Bei Neuregistrierung über ein entsprechendes Formular werden Daten des Nutzers gespeichert 
 *
 * Ablauf:
 * 1. Datenbank und Tabelle erstellen, wenn noch nicht vorhanden
 * 2. Felder erstellen: id, firstname, lastname, username, mail, login_date, anzahl_logins
 * 3. Daten aus übermitteltem Formular eintragen: firstname, lastname, username
 * 4. übermitteltes mail hashen
 * 
 * @param string lastname = Nachname des Benutzers
 * @param string firstname = Vorname des Benutzer
 * @param string username = Username
 * @param string mail = E-Mail
 */


function registrieren(
  $firstname_input,
  $lastname_input,
  $username_input,
  $mail_input
) //Parameter werden von new_user.inc.php übermittelt
{
   $con = new mysqli("", "root"); //baut eine neue Verbindung zum MySQL-Server auf
   $sql = "CREATE DATABASE IF NOT EXISTS logindaten_neu"; //prüft ob DB bereits vorhanden ist, wenn nicht, dann neu erstellen
   $con->query($sql); //mit query, da noch keine Nutzer-Daten übertragen werden
   $con->select_db("logindaten_neu");
   
   $sql = "CREATE TABLE IF NOT EXISTS user"
      . " (id INT(11) NOT NULL AUTO_INCREMENT,"
      . " firstname VARCHAR(50) NOT NULL,"
      . " lastname VARCHAR(50) NOT NULL,"
      . " username VARCHAR(50) NOT NULL,"
      . " mail VARCHAR(50) NOT NULL,"
      . " login_date VARCHAR(50) NOT NULL,"
      . " anzahl_logins VARCHAR(50) NOT NULL,"
      . " PRIMARY KEY (id)"
      . " ) ENGINE=InnoDB DEFAULT CHARSET=UTF8";
   $con->query($sql); //legt die Spalten: id, firstname, lastname, username, mail, login_date, anzahl_logins an
   
   $sql = "INSERT INTO user (firstname, lastname, username, mail)" //Eintragung der Daten vorbereiten
       . " VALUES(?, ?, ?, ?)";

   $ps = $con->prepare($sql);
   $ps->bind_param("ssss",             //gesnedeten Daten binden
      $firstname_input,
      $lastname_input,
      $username_input,
      $mail_input);
   $ps->execute();                     //Daten eintragen

   $ps->close();
   $con->close();
}
?>
