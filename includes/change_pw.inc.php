<h2>Passwort zurücksetzen</h2>
<hr>
<br>
<div class='login_area'>
  <div class='login_card'>

    <?php
    include_once("./classes/user_edit.class.php");

$reset_user_pw = new User_Edit();

if ($_SERVER["REQUEST_METHOD"] == "POST") { //wenn das Formular abgeschickt wurde:
    
      //konvertieren der Formulardaten  
      $reset_user_pw->convert_data(
      "", "", $_POST["username"], "", $_POST["password"]);

      //Prüfen der eingegebenen Formulardaten
      $validate_Err = $reset_user_pw->validate_data();

      $Err_Info = $validate_Err['password']; 

       if (empty($Err_Info)) {
       $reset_user_pw->change_pw();

//     $reset_pw->__construct("","",$_POST["username"], "", $_POST["password"]);
// $validate_Err = $reset_pw->validate_data();
// if ((empty($validate_Err[2])) && (empty($validate_Err[4]))) {

     // $reset_pw->change_pw();

      echo "<h3>Passwort geändert</h3><br><br>In <span id='counterdiv'>10</span> Sekunden wirst du zum Loginbereich weitergeleitet<br>";
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

    ?>

    <!-- Formular anzeigen -->
    <form action='' method='POST'>
      <input placeholder='Benutzername' name='username'>
      <input type='password' placeholder='neues Passwort' name='password'>
      <input type='Submit' value='Bestätigen'>
    </form>

    <br>Noch keine Zugangsdaten?
    <a href='
<?PHP echo linkTo("index.php", "?page=signup"); ?>
'>Zur Registrierung gehts hier entlang...</a>
  </div>