<h2>Login</h2>
<hr>
<div class='login_area'>

  <div class='login_card'>

    <?php
    //Login-Daten prüfen
    
    if ((isset($_POST["username"])) && (isset($_POST["password"]))) { //wenn Daten ins Loginformular eingegeben und versendet wurden, startet die Abfrage, ob diese richtig sind mit der Funktion "verify" aus der Class login class_login.php
      //bindet die benötigte Klasse ein
      include_once("./classes/login.class.php");
      $login = new login($_POST["username"], $_POST["password"]);
      if (
        $login->verify()
      ) { //Wenn die Eingabe korrekt war, dann die Daten in der Session speichern
        $cur_session = $login->get_data();
        $_SESSION["name"] = $cur_session["user"];
        $_SESSION["user_id"] = $cur_session["user_id"];
        $_SESSION["firstname"] = $cur_session["first"];
        $_SESSION["lastname"] = $cur_session["last"];
        $_SESSION["date"] = $cur_session["date"];
        $_SESSION["admin"] = $cur_session["admin_rights"];

        if ($_SESSION["admin"] == true)
          // zum Benutzer-Account weiterleiten oder Fehlermeldung anzeigen
          weiterleiten("admin.php");
        if ($_SESSION["admin"] == false)
          // zum Benutzer-Account weiterleiten oder Fehlermeldung anzeigen
          weiterleiten("user.php");
      } else {
        echo "Der eingegebene Username oder das Passwort war nicht korrekt."; //Fehlermeldung, wenn Passwort inkorrekt
      }
    }

    ?>

    <!-- Login-Formular anzeigen -->
    <form action='' method='POST' class='userdataform'>
      <input placeholder='Benutzername' name='username'>
      <input type='password' placeholder='Passwort' name='password'>
      <input type='Submit' value='Login'>
    </form>

    <a href='
    <?PHP echo linkTo("index.php", "?page=password_reset"); ?>
    '>Passwort vergessen?</a></p>

    <br>Noch keine Zugangsdaten?
    <a href='
    <?PHP echo linkTo("index.php", "?page=signup"); ?>
    '>Zur Registrierung gehts hier entlang...</a>
  </div>