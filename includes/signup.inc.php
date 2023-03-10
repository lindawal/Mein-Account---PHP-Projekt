<div>
  <h2>Benutzerkonto anlegen</h2>
  <hr><br>
  <div class='login_area'>
  <div class='login_card'>

    <?php
    include_once("./classes/new_member.class.php");
    include_once("./classes/formular.class.php");

    //KLasse User_Edit bereits zu beginn laden, damit diese an die Klasse Form übergeben werden kann
    $new_member = new new_member();

    if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn das Formular abgeschickt wurde:
    
    //gesendete Daten nun an den Constructor übergeben
      $new_member->__construct($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["mail"], $_POST["password"]);

      //Prüfen der eingegebenen Formulardaten
      $validate_Err = $new_member->validate_data();
      $exist_username_Err = $new_member->username_exist();
      $exist_mail_Err = $new_member->mail_exist();

      $Err_Info = $exist_mail_Err;
      $Err_Info .= $exist_username_Err;
      $Err_Info .= $validate_Err['firstname'];
      $Err_Info .= $validate_Err['lastname'];
      $Err_Info .= $validate_Err['username'];
      $Err_Info .= $validate_Err['mail'];
      $Err_Info .= $validate_Err['password'];

      //wenn keine Fehlermeldung vorhanden ist, werden die Daten an die Funktion signup() übergeben
      if (empty($Err_Info)) {

        $new_member->signup();

        echo "<br>Vielen Dank " . $_POST["firstname"] . ", du bist jetzt registriert. <br> In <span id='counterdiv'>10</span> Sekunden wirst du zum Loginbereich weitergeleitet<br>";
        echo "<script> 
    setTimeout(function(){location.href='index.php'} , 10000);   
    let counter = 10;
    let Interval1 = setInterval(function () {
    if (counter > 0)
    counter = counter - 1;
    document.getElementById('counterdiv').innerHTML = counter}, 1000);        
      </script>"; //Javascript-WL zu User Area nach 10 Sekunden mit Countdown 
    
      } else {
        // Fehlermeldungen ausgeben:
        echo "<div class='errorbox'>" . $Err_Info . "</div>";
      }
    }

    /***
    Registrierungs-Formular anzeigen
    - wenn bereits Daten gesendet wurden, aber nicht valide waren, werden diese im Formular angezeigt (Affenformular)
    ***/

    echo "<form action='" . htmlspecialchars($_SERVER['REQUEST_URI']) . "' method='POST' class='userdataform'>";
   
    $signup_form = new Form($new_member);
    $signup_form->input_fields('firstname', 'lastname', 'username');
    $signup_form->input_mail();
    $signup_form->input_password();
    echo "<p></p><input type='Submit' name='reg_button' value='registrieren'>" .
      "</form>"
      . "<br> Du hast bereits Zugangsdaten? 
<a href='index.php?page=login'>Zum Login gehts hier entlang...</a>";

    ?>
  </div>
</div>
</div>