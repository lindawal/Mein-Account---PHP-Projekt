<?PHP

//der Nutzer wird sofort auf eine andere Seite weiter geleitet z.B. nach dem Logout, oder wenn im eingeloggten Zustand die Login-Seite versehentlich aufgerufen wird
function weiterleiten($myPage){ //als Parameter wird die spezifische Seite mit gesendet
$host  = $_SERVER['HTTP_HOST']; //Host z.B. localhost
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); //Unterordner z.B: /linda/php
header("Location: http://$host$uri/$myPage"); 
}

//der Name der aktuellen Datei wird ermittelt, damit ein Link funktioniert, egal, ob er z.B. von der admin.php oder der user.php aus aufgerufen wird
function get_filename($path){ //Pfad: ($_SERVER['PHP_SELF'])
  $file = basename($path);    //der Dateiname wird aus dem Pfad ausgelesen
  return $file;               //Dateinamen zurück geben
}

//Verlinkungen innerhalb des Dokumentes, z.B. Zurück-Buttons
function linkTo($myPage, $myParam){
$host  = $_SERVER['HTTP_HOST']; //Host z.B. localhost
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); //Unterordner z.B: /projekte/php
echo "http://$host$uri/$myPage$myParam"; 
}


/*wenn im Adminbereich bestimmte Filter ausgewählt sind und dann zum Ändern die Seite edit.user aufgerufen wird, 
sollen die Filterparameter gespeichert werden und beim Aufruf des Zurück-Buttons wieder verwendet werden*/
function safe_filter($uri)
{
  $safe_url = fopen("lastURL.txt", "w"); //neues Text Dokument erstellen
  fwrite($safe_url, $uri);              //Uri im Dokument speichern
  fclose($safe_url);                    //Dokument schließen
}

//letzte URL aus dem zuvor gespeicherten Dokument auslesen
function get_last_url()
{
  $file = "lastURL.txt";
  $get_url = fopen($file, "r");             //öffnen des Text-Dokumnetes 
  $url = fread($get_url, filesize($file));  //Auslesen der url
  fclose($get_url);                         //Dokument schließen

  return $url;
}
?>