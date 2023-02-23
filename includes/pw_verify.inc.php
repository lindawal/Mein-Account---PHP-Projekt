<?php

/**
 * Aufbau einer Verbiindung zur Datenbank
 *
 * 
 * @param string $dbname = Datenbankname
 * @param string $tabname = Tabellenname
 * @param string $name_eingabe = Username
 * @param string $passwort_eingabe = Passwort
 */



function verify(
   $dbname,
   $tabname,
   $name_eingabe,
   $passwort_eingabe
) //Parameter werden von login.php übermittelt
{
   $firstname_db = $lastname_db = $login_date_db = ""; //Variablen definieren, da sonst Fehlermeldung wenn Login fehlschlägt und diese nicht übermittelt werden

   /*OOP
   - new mysqli erzeugt ein neues Objekt der vordefinierten Klasse mysqli
   - die Klasse stellt einen Konstruktor zur Verfügung (Referenz auf das erzeugte Objekt)
   - diese Referenz wird in der Variable $con gespeichert
   @vorangestellt (Silence-Operator) unterdrückt Fehlermeldungen, um diese vor potenziellen Angreifern zu verbergen

   prepare ist eine Methode der Klasse mysqli, $ps steht für das statement, welches zurückgegeben wird
   -das Objekt hat dann die Klasse mysqli_stmt dieser Klasse stehen wiederum bestimmte Methoden zur Verfügung

   */

   $con = @new mysqli("", "root", "", $dbname); //baut eine neue Verbindung zum MySQL-Server auf ("hostname -> 0 entspricht localhost", "MySQL-Benutzername", "Passwort", "gewünschte Datenbank")

   $ps = $con->prepare( //Einleitung der SQL-Anweisung
      //SELECT: Spaltenname "username", "passwort"
      //FROM: Tabellenname "$tabname"
      //WHERE: Zeilenname(filtern), Wert wird aus Sicherheitsgründen durch Unbekannte ersetzt, daher "=?" 
      "SELECT username, passwort FROM $tabname WHERE username=?"
   );
   $ps->bind_param("s", $name_eingabe); //verknüpft Variablen als Parameter an eine vorbereitete Anweisung
   //"s" steht für string
   //$name_eingabe wurde aus pw_hash übermittelt (eingegeber Benutzername)
   $ps->execute(); //führt die Anweisung aus
   $ps->bind_result($name_db, $passwort_db); //verknüpft die Variablen name und passwort aus der Datenbank an vorbereitete Anweisung zur Speicherung des Ergebnisses

   $ps->store_result(); //Speichert das Ergebnis in einem internen Puffer
   if ($ps->num_rows > 0) //Abfrage, ob die Datenbank Daten enthält
   {
      $ps->fetch(); //Ruft die Ergebnisse aus dem Puffer ab
      if (password_verify($passwort_eingabe, $passwort_db)) //Überprüft, ob das Passwort und der Hash zusammenpassen, gibt true oder false wieder
      {
         $ergebnis = true;

         //bei erfolgreichem Login wird das Datum und Anzahl der Logins gespeichert
         $con->query("UPDATE benutzer SET login_date = NOW(), anzahl_logins = anzahl_logins+1 WHERE username='$name_db'");

         //die Nutzerdaten Name und Login-Datum werden ausgelesen und für den Nutzerbereich übermittelt
         $time_log = $con->prepare("SELECT firstname, lastname, login_date FROM $tabname WHERE username=?");
         $time_log->bind_param("s", $name_eingabe);
         $time_log->execute();
         $time_log->bind_result($firstname_db, $lastname_db, $login_date_db);
         $time_log->store_result();
         $time_log->fetch();
         //$time_log->execute();
         // $ps->get_result($login_date_db);
         //$con->query("UPDATE benutzer SET anzahl_logins = anzahl_logins+1 WHERE username='$name_db'");
      } else
         $ergebnis = false;
   } else
      $ergebnis = false;



   $ps->close(); //schließt die aktuelle Anweisung/ Datenbank, Speicherressourcen werden frei gegeben
   $con->close();
   return array($ergebnis, $firstname_db, $lastname_db, $login_date_db);
}
?>