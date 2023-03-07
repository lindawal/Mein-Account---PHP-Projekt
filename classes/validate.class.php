<?PHP
include_once("./classes/user.class.php");
class Validate extends User
{
  function __construct($firstname="", $lastname="", $username="", $mail="", $password="")
  {
    $this->firstname = $this->convert_input($firstname);
    $this->lastname = $this->convert_input($lastname);
    $this->username = $this->convert_input($username);
    $this->mail = $this->convert_input($mail);
    $this->password = $this->convert_input($password);
  }

  function validate_data()
  {
    //im Vor-, Nach- und Usernamen erlaubte Zeichen: A-Z (mind. 1x Pflicht), ÜÄÖ (case insensitiv), Leerzeichen zwischen Doppelnamen und ,.-
    $pattern_name = '/^[a-z][a-zäöü ,.-]+$/i';
    $pattern_username = '/^[a-z][\da-zäöü ._-]{3,}$/i'; //Username kann außerdem Zahlen enthalten
    $pattern_mail = '/[.]/';
    $pattern_password = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!?+.*-])(?!.*\s).{6,15}/';

    $firstnameErr = $lastnameErr = $usernameErr = $mailErr = $passwordErr = "";

    if (!preg_match($pattern_name, $this->firstname)) { //Prüfung ob eingegebene Daten valide sind
      $firstnameErr = "Der Vorname darf nur Buchstaben (A - Z, Ü, Ä, Ö) und Sonderzeichen (,.-) enthalten."; //Fehlermeldung
    }
    if (!preg_match($pattern_name, $this->lastname)) {
      $lastnameErr = "Der Nachname darf nur Buchstaben (A - Z, Ü, Ä, Ö) und Sonderzeichen (,.-) enthalten.";
    } 
    if (!preg_match($pattern_username, $this->username)) {
      $usernameErr = "Der Username muss mindestens aus 4 Zeichen bestehen und darf nur Buchstaben (A - Z, Ü, Ä, Ö), Zahlen und Sonderzeichen (.-_) enthalten.";
    }
    if (!preg_match($pattern_mail, $this->mail)) {
      $mailErr = "Keine gültige E-Mail-Adresse.";
    }
    if (!empty($this->password)){
    if (!preg_match($pattern_password, $this->password)) {
      $passwordErr = "Das Passwort muss aus 6 - 15 Zeichen bestehen und folgendes enthalten: Sonderzeichen (!?+.*-), Zahl, Groß- und einen Kleinbuchstaben.";
    }
    }
    return array($firstnameErr, $lastnameErr, $usernameErr, $mailErr, $passwordErr);
  }
  /***
  Konvertieren der Eingabedaten
  ***/
  function convert_input($data)
  {
    $data = trim($data); //Leerzeichen entfernen
    $data = stripslashes($data); //Slashes entfernen
    $data = htmlspecialchars($data); //Sonderzeichen konvertieren
    return $data;
  }
}

class new_user extends new_member{

  public $user_tab = "user";

  function signup()
  {
    $mysqli = new mysqli("", "root"); //baut eine neue Verbindung zum MySQL-Server auf
    $sql = "CREATE DATABASE IF NOT EXISTS $this->dbname"; //prüft ob DB bereits vorhanden ist, wenn nicht, dann neu erstellen
    $mysqli->query($sql); //mit query, da noch keine Nutzer-Daten übertragen werden
    $mysqli->select_db("$this->dbname");

    $sql = "CREATE TABLE IF NOT EXISTS $this->user_tab"
      . " (id INT(11) NOT NULL AUTO_INCREMENT,"
      . " user_id INT(10) NOT NULL,"
      . " firstname VARCHAR(50) NOT NULL,"
      . " lastname VARCHAR(50) NOT NULL,"
      . " username VARCHAR(50) NOT NULL,"
      . " mail VARCHAR(50) NOT NULL,"
      . " PRIMARY KEY (id)"
      . " ) ENGINE=InnoDB DEFAULT CHARSET=UTF8";
    $mysqli->query($sql); //legt die Spalten: id, firstname, lastname, username, mail, login_date, count_logins an

    $sql = "INSERT INTO $this->user_tab (firstname, lastname, username, mail)" //Eintragung der Daten vorbereiten
      . " VALUES(?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(
      "ssss",
      //gesnedeten Daten binden
      $this->firstname,
      $this->lastname,
      $this->username,
      $this->mail
    );
    $stmt->execute(); //Daten eintragen

    $stmt->close();
    $mysqli->close();

    $this->firstname = $this->lastname = $this->username = $this->mail = $this->password = "";
  }

  function form()
  {
    echo "<form action='" . htmlspecialchars($_SERVER['REQUEST_URI']) . "' method='POST'><input placeholder='Vorname' name='firstname' value='" . $this->firstname . "' required='required'>
        <input placeholder='Nachname' name='lastname' value='" . $this->lastname . "' required='required'>
        <input placeholder='Benutzername' name='username' value='" . $this->username . "' required='required'>
        <input type='email' placeholder='E-Mail' name='mail' value='" . $this->mail . "' required='required'>
        <input type='Submit' name='reg_button' value='hinzufügen'>
      </form>";
  }

}

class new_password extends new_member
{
  function change_pw()
  {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $pw = password_hash($this->password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare(
      "UPDATE $this->login_tab SET password = ? WHERE username = ?"
    );
    $stmt->bind_param(
      "ss",
      $pw,
      $this->username,
    );
    $stmt->execute();

    $stmt->close();
    $mysqli->close();


  }
}
?>

