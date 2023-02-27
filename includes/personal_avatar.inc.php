<?php

/**
 * Namen und Kürzel anpassen für Login Bereich
 * Daten werden aus einer Datenbank mit Usern entnommen
 * @param string session_lastname = Nachname des Benutzers
 * @param string session_firstname = Vorname des Benutzer
 */


function personal_avatar($cur_lastname = "", $cur_firstname = "") //es darf auch ein Parameter leer bleiben = ""
{
  $lastname = $cur_lastname;
  $firstname = $cur_firstname;
  $shorty = substr($lastname, 0, 1)  . substr($firstname, 0, 1);
  //$shorty_first = substr($firstname, 0, 1); //Kürzel erstellen: ersten Buchstaben aus jedem Namensteil
  return array($lastname, $firstname, $shorty);
}
?>