<?PHP

/*
 *   Ändern und Löschen einzelner Nutzer-Daten
 *   Bereiche:
 *   Allgemein: Passowrt ändern
 *   User: Mein Account
 *   Admin: User-Daten ändern/löschen
 */

include_once("./classes/user_data.class.php");
class User_Edit extends User_Data
{
  public function __construct($user_id = "")
  {
    $this->user_id = $user_id;
  }
  //eingegebene Daten übertragen und konvertieren
  public function convert_data($firstname = "", $lastname = "", $username = "", $mail = "", $password = "", )
  {
    $this->firstname = $this->convert_input($firstname);
    $this->lastname = $this->convert_input($lastname);
    $this->username = $this->convert_input($username);
    $this->mail = $this->convert_input($mail);
    $this->password = $this->convert_input($password);
  }

  //Daten ändern in der Tabelle user und in login_data
  public function change_data()
  {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $stmt = $mysqli->prepare(
      "UPDATE $this->user_tab INNER JOIN $this->login_tab " .
      "ON $this->user_tab.user_id = $this->login_tab.user_id " .
      "SET $this->user_tab.firstname = ?, $this->user_tab.lastname = ?, $this->user_tab.username = ?, $this->user_tab.mail = ?, " .
      "$this->login_tab.username = ? " . //username muss in beiden Tabellen geändert werden, daher doppelt
      "WHERE $this->user_tab.user_id = ?"
    );
    $stmt->bind_param(
      "sssssi",
      $this->firstname,
      $this->lastname,
      $this->username,
      $this->mail,
      $this->username, //username muss in beiden Tabellen geändert werden, daher doppelt
      $this->user_id
    );

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      $success = true;
    } else
      $success = false;

    $stmt->close();
    $mysqli->close();

    return $success;
  }

  //Passwort ändern
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
  //Nuter löschen
  function delete_data()
  {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $sql = "DELETE $this->user_tab, $this->login_tab FROM $this->user_tab INNER JOIN $this->login_tab " .
      "ON $this->user_tab.user_id = $this->login_tab.user_id " .
      "WHERE $this->user_tab.user_id = $this->user_id";
    $mysqli->query($sql);
    if ($mysqli->affected_rows > 0) {
      $success = true;
    } else
      $success = false;

    $mysqli->close();

    return $success;
  }

}

?>