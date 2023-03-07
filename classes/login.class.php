<?PHP
include_once("./classes/user_data.class.php");
require_once("database.config.php");
class Login extends User_Data
{
  //public $username;
  //protected $password;

  public function __construct($username_input, $password_input) //Parameter werden von login.inc.php übermittelt

  {
    $this->username = $this->convert_input($username_input);
    $this->password = $this->convert_input($password_input);
  }

  function verify()
  {
    //@vorangestellt (Silence-Operator) unterdrückt Fehlermeldungen, um diese vor potenziellen Angreifern zu verbergen
    $mysqli = @new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE); //neue Verbindung zum MySQL-Server ("hostname -> 0 entspricht localhost", "MySQL-Benutzername", "Passwort", "gewünschte Datenbank")

    $stmt = $mysqli->prepare(
      //Einleitung der SQL-Anweisung
      "SELECT password, user_id FROM $this->login_tab WHERE username=?"
    );
    $stmt->bind_param("s", $this->username); //verknüpft Variablen als Parameter an eine vorbereitete Anweisung
    $stmt->execute(); //führt die Anweisung aus
    $stmt->bind_result($password_db, $user_id_db); //verknüpft die Variablen name und passwort aus der Datenbank an vorbereitete Anweisung zur Speicherung des Ergebnisses

    $stmt->store_result(); //Speichert das Ergebnis in einem internen Puffer
    if ($stmt->num_rows > 0) //Abfrage, ob in der Datenbank ein Datensatz gefunden wurde
    {
      $stmt->fetch(); //Ruft die Ergebnisse aus dem Puffer ab
      if (password_verify($this->password, $password_db)) //Überprüft, ob das Passwort und der Hash zusammenpassen, gibt true oder false wieder
      {
        $success = true;
        //$this->username = $name_db;
        $this->user_id = $user_id_db;
        $this->set_session_data();
      } else
        $success = false;
    } else
      $success = false;

    $stmt->close(); //schließt die aktuelle Anweisung/ Datenbank, Speicherressourcen werden frei gegeben
    $mysqli->close();
    return $success;
  }
  private function set_session_data()
  {
    //bei erfolgreichem Login wird das Datum und Anzahl der Logins gespeichert
    $mysqli = @new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $mysqli->query("UPDATE $this->login_tab SET login_date = NOW(), count_logins = count_logins+1 WHERE user_id='$this->user_id'");
     $mysqli->close();
  }

  function get_session_data()
  {
    $get_data = $this->load_data($this->user_id);
    $this->firstname = $get_data["firstname"];
    $this->lastname = $get_data["lastname"];
    $this->login_date = $get_data["login_date"];
    $this->admin_rights = $get_data["admin_rights"];

    return array("user" => $this->username, "first" => $this->firstname, "last" => $this->lastname, "date" => $this->login_date, "admin_rights" => $this->admin_rights);
  }

}




?>