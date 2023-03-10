<?php

echo "<div class='user_area_card'><h2 class='user-section-header'>Meine Daten</h2>";
        /***
          Infos zum Login anzeigen
          ***/ include_once("./classes/view.class.php");
          $cur_user_view = new View();
          $avatar = $cur_user_view->avatar($_SESSION["firstname"], $_SESSION["lastname"]);
  echo "<div class='myaccount'><div><div class='avatar'>" . $avatar . "</div> " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . "</div>";

          if (isset($_SESSION["z"])) // Zugriffszähler existiert
            $_SESSION["z"] = $_SESSION["z"] + 1;
          else
            $_SESSION["z"] = 1; //Zugriffszähler ist neu
          echo "<div> Anzahl Seitenaufrufe: " . $_SESSION["z"] . "<br>";

         
          //Datum formatieren
          $get_login_date = $cur_user_view->format_date($_SESSION["date"]);
          echo "Login: " . $get_login_date .
            "<br>";
          //Namen und Avatar anzeigen
          
  echo "</div>" .
    "<div><form action='logout.php'>
        <button type='submit' name='logout' class='user_area_button'>Logout</button>
        </form></div></div></div>";


?>