<!-- Header Template -->

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PHP">
    <title>PHP Test</title>
    <link href="./css/admin-style.css" rel="stylesheet">
  </head>

  <body>
    <div id="wrapper">

      <div class="menubar">
        <h1>Mein Account</h1>
        <?PHP
if (isset($_SESSION["name"])) {
          /***
          Infos zum Login anzeigen
          ***/
          if (isset($_SESSION["z"])) // Zugriffszähler existiert
            $_SESSION["z"] = $_SESSION["z"] + 1;
          else
            $_SESSION["z"] = 1; //Zugriffszähler ist neu
          echo "<div> Anzahl Seitenaufrufe: " . $_SESSION["z"] . "<br>";

          //array mit regulären Ausdrücken zum Umstellen des mit Now() erzeugten Datums: 
          //(20)(zahl, 2-stellig)-(zahl, 1-2-stellig)-(zahl, 1-2-stellig)leerzeichen(zahl, 2-stellig):(zahl, 1-2-stellig):(zahl, 1-2-stellig)
          $date_regex = array(
            '/(20)(\d{2})-(\d{1,2})-(\d{1,2})\s(\d{2}):(\d{1,2}):(\d{1,2})/'
          );

          $date_replace = array('\4.\3.\1\2 \5:\6 Uhr'); //array mit Ersatzsymbolen/zeichen: Angabe der nummerierten Ausdrücke, zuerst der 4., dann der 3. etc. der letzte wird weg gelassen, statt dessen "Uhr" eingefügt
          echo "Login: " . preg_replace($date_regex, $date_replace, $_SESSION["date"]) .
          "</div>";


          /***
          Namen und Kürzel anpassen
          ***/

          include_once("./includes/personal_avatar.inc.php"); //Datei mit der Funktion zum Erstellen der Kürzel einbinden
          $pers_avatar = personal_avatar($_SESSION["firstname"], $_SESSION["lastname"]); //Parameter an die Funktion senden
          // die return Werte werden mithilfe des Index aus dem Array abgerufen
          echo "<div class='myname'><div class='avatar'>" . $pers_avatar[2] . "</div>" . $pers_avatar[0] . " " . $pers_avatar[1] .
            "<form action='logout.php'>
        <button type='submit' name='logout'>Logout</button>
        </form></div>";
}
?>
      </div>
      <div class="main-area">
      <?PHP
      if (isset($_SESSION["name"])) {
      echo "
        <div class='menu'>
          <a href='index.php'>
            <img src='./images/home.svg'>
            <p class='menu-text'>Start</p>
          </a>
          <a href='index.php?page=new_user'>
            <img src='./images/newuser.svg'>
            <p class='menu-text'>Neuer User</p>
          </a>
          <a href='index.php'>
            <img src='./images/kontakte.svg'>
            <p class='menu-text'>Alle User</p>
          </a>
          <a href='index.php?page=addcontact'>
            <img src='./images/fotos.svg'>
            <p class='menu-text'>Meine Fotos</p>
          </a>
        </div>";
      }
        ?>
      
     <!-- <a href="javascript:void(0);" class="menubutton" onclick="MobileMenu()"><img alt="Hamburger" src="images/hamburger.svg"></a> -->

        <main>