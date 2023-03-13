<?PHP

/*
 *   Laden der Daten für den Bereich 
 *   Startseite: Registrierung
 *   Admin: neuen User anlegen
 */

 //bindet die benötigte Klasse ein
include_once("./classes/user_data.class.php");

class New_Member extends User_Data
{
  //Eingabedaten werden übermittelt und zum Schutz vor Injektions konvertiert
  function __construct($firstname = "", $lastname = "", $username = "", $mail = "", $password = "")
  {
    $this->firstname = $this->convert_input($firstname);
    $this->lastname = $this->convert_input($lastname);
    $this->username = $this->convert_input($username);
    $this->mail = $this->convert_input($mail);
    $this->password = $this->convert_input($password);
  }

  //prüfen, ob der gewünschte Nutzername bereits existiert
  function username_exist()
  {
    $Error = "";

    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $stmt = $mysqli->prepare("SELECT username FROM $this->user_tab WHERE $this->user_tab.username=?");
    $stmt->bind_param("s", $this->username);
    $stmt->execute();
    if ($stmt->fetch() > 0)
      $Error = "Der Nutzername ist bereits vergeben.<br>";

    $stmt->close();
    $mysqli->close();

    return $Error;
  }

  //prüfen, ob zur E-Mail-Adresse bereits ein Account existiert
  function mail_exist()
  {
    $Error = "";

    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $stmt = $mysqli->prepare("SELECT mail FROM $this->user_tab WHERE $this->user_tab.mail=?");
    $stmt->bind_param("s", $this->mail);
    $stmt->execute();
    if ($stmt->fetch() > 0)
      $Error = "Mit dieser E-Mail Adresse wurde bereits ein Account registriert.<br>";

    $stmt->close();
    $mysqli->close();
    return $Error;
  }

  //bei der Registrierung soll eine fortlaufende individuelle User-Id vergeben werden
  private function set_new_user_id()
  {
    //die aktuell höchste User-Id wird ermittelt
    $mysqli = @new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $result = $mysqli->query("SELECT MAX(user_id) as max_id FROM $this->user_tab");
    $cur_id = $result->fetch_assoc();
    $mysqli->close();
    //höchste ID um 1 erhöhen
    $new_user_id = $cur_id["max_id"] + 1;
    return $new_user_id;
  }

  //die Daten werden registriert
  function signup()
  {
    $user_id = $this->set_new_user_id();

    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD); //baut eine neue Verbindung zum MySQL-Server auf
    $sql = "CREATE DATABASE IF NOT EXISTS " . MYSQL_DATABASE; //prüft ob DB bereits vorhanden ist, wenn nicht, dann neu erstellen
    $mysqli->query($sql); //mit query, da noch keine Nutzer-Daten übertragen werden
    $mysqli->select_db(MYSQL_DATABASE);
    //legt die Tabellen-Spalten an
    $sql = "CREATE TABLE IF NOT EXISTS $this->user_tab"
      . " (id INT(11) NOT NULL AUTO_INCREMENT,"
      . " user_id INT(10) NOT NULL,"
      . " firstname VARCHAR(50) NOT NULL,"
      . " lastname VARCHAR(50) NOT NULL,"
      . " username VARCHAR(50) NOT NULL,"
      . " mail VARCHAR(100) NOT NULL,"
      . " admin INT(11) NULL DEFAULT NULL,"
      . " PRIMARY KEY (id)"
      . " ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;";
    $sql .= "CREATE TABLE IF NOT EXISTS $this->login_tab"
      . " (id INT(11) NOT NULL AUTO_INCREMENT,"
      . " user_id INT(10) NOT NULL,"
      . " username VARCHAR(50) NOT NULL,"
      . " password VARCHAR(250) NOT NULL,"
      . " login_date VARCHAR(50) NOT NULL,"
      . " count_logins VARCHAR(50) NOT NULL,"
      . " PRIMARY KEY (id)"
      . " ) ENGINE=InnoDB DEFAULT CHARSET=UTF8";
    $mysqli->multi_query($sql);
    while ($mysqli->next_result()) {
      ;
    } //Solange nicht alle Abfragen abgearbeitet sind, kann keine andere Anweisung auf derselben Verbindung ausgeführt werden

    $pw = password_hash($this->password, PASSWORD_DEFAULT); //übertragenes Passwort verschlüsseln

    $sql_user = "INSERT INTO $this->user_tab (user_id, firstname, lastname, username, mail)" //Eintragung der Daten vorbereiten
      . " VALUES(?, ?, ?, ?, ?)";
    $sql_login = "INSERT INTO $this->login_tab (user_id, username, password)" //Eintragung der Daten vorbereiten
      . " VALUES(?, ?, ?)";

    $stmt = $mysqli->prepare($sql_user);
    $stmt->bind_param(
      //gesendeten Daten binden
      "issss",
      $user_id,
      $this->firstname,
      $this->lastname,
      $this->username,
      $this->mail
    );
    $stmt->execute(); //Daten eintragen

    $stmt->prepare($sql_login);
    $stmt->bind_param(
      "iss",
      $user_id,
      $this->username,
      $pw
    );

    $stmt->execute();

    $stmt->close();
    $mysqli->close();

    $this->data_set_default();
  }

  //Variablen-Werte löschen, damit das Formular sich leert
  private function data_set_default()
  {
    $this->firstname = $this->lastname = $this->username = $this->mail = $this->password = "";
  }
}
?>