<!-- Header Template -->

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PHP">
  <title>PHP Projekt: Mein Account</title>
  <link href="./css/account-style.css" rel="stylesheet">

  <link rel="icon" type="image/svg+xml" href="favicon.svg" sizes="any">
  <link rel="icon" href="/favicon.png" type="image/png">
  <!-- favicon.ico im Stammverzeichnis, aber nicht verlinkt -->

</head>

<body>
  <div id="wrapper">

    <div class="menubar">
      <a href='index.php'>
        <div class='Logo'>MA</div>
      </a>
      <h1>Mein Account</h1>
      <div class='myname'>
        <div>

          <?PHP

          if (isset($_SESSION["name"])) {

            //bindet die benötigte Klasse ein
            include_once("./classes/view.class.php");
            $cur_user_view = new View();

            if ($_SESSION["admin"] == false) {

              //Namen und Avatar anzeigen
              $avatar = $cur_user_view->get_avatar_symbol($_SESSION["firstname"], $_SESSION["lastname"]);
              echo $avatar;
              echo "</div><div><form action='logout.php'>
                <button type='submit' name='logout'>Logout</button>
                </form>";
            }

            if ($_SESSION["admin"] == true) {

              //Zugriffszähler anzeigen
              if (isset($_SESSION["z"])) // Zugriffszähler existiert
                $_SESSION["z"] = $_SESSION["z"] + 1;
              else
                $_SESSION["z"] = 1; //Zugriffszähler ist neu
              echo "<div class='myname'><div> Anzahl Seitenaufrufe: " . $_SESSION["z"] . "<br>";

              //Datum formatieren
              $get_login_date = $cur_user_view->format_date($_SESSION["date"]);
              echo "Login: " . $get_login_date .
                "<br>";
              //Namen und Avatar anzeigen
              $avatar = $cur_user_view->get_avatar_symbol($_SESSION["firstname"], $_SESSION["lastname"]);
              echo $avatar;
              echo "</div>" .
                "<div><form action='logout.php'>
               <button type='submit' name='logout' class='header_button'>Logout</button>
               </form></div></div>";
            }
          }
          ?>

        </div>
      </div>
    </div>
    <div class="main-area">

      <?PHP

      if (isset($_SESSION["name"])) {
        //Admin-Menü
        if ($_SESSION["admin"] == true) {
          echo "
        <div class='menu'>
          <a href='admin.php'>
            <img src='./images/home.svg' alt='home'>
            <p class='menu-text'>Start</p>
          </a>
          <a href='admin.php?page=new_user'>
            <img src='./images/newuser.svg' alt='neuer Nutzer'>
            <p class='menu-text'>Neuer User</p>
          </a>
          <a href='admin.php'>
            <img src='./images/kontakte.svg' alt='kontakte'>
            <p class='menu-text'>Alle User</p>
          </a>
          <a href='admin.php?page=my_data'>
            <img src='./images/account_circle.svg' alt='Mein Account'>
            <p class='menu-text'>Mein Account</p>
          </a>
        </div>";
        }
        //User-Menü
        if ($_SESSION["admin"] == false) {
          echo "
        <div class='menu'>
          <a href='user.php'>
            <img src='./images/home.svg' alt='home'>
            <p class='menu-text'>Start</p>
          </a>
          <a href='user.php?page=my_data'>
            <img src='./images/account_circle.svg' alt='Mein Account'>
            <p class='menu-text'>Mein Account</p>
          </a>
          <a href='user.php?page=my_contacts'>
            <img src='./images/contacts.svg' alt='Meine Kontakte'>
            <p class='menu-text'>Meine Kontakte</p>
          </a>
          <a href='user.php?page=settings'>
            <img src='./images/settings.svg' alt='Einstellungen'>
            <p class='menu-text'>Einstellungen</p>
          </a>
        </div>";
        }
      }
      ?>

      <main>