<?PHP
//Startseite wenn User eingeloggt ist

if (isset($_SESSION["name"])) {

   //übersicht über die Nutzerdaten laden
   include_once("my-data.inc.php");
   
   //Übersicht über die Kontakte laden
   include_once("my-contacts.inc.php");

} else
   echo "<br><br><h3>Zugriff nicht erlaubt</h3>";

?>
</div>