<?PHP

class User
{
  public $dbname = "logindaten_neu";
  public $tabname = "user";
  public $firstname;
  public $lastname;
  public $username;
  public $mail;

  function __construct(public $id)
  {
  }

  function load_data()
  {
    $mysqli = new mysqli("", "admin", "passwort", $this->dbname);
    $sql = "SELECT * FROM $this->tabname WHERE id = "
      . $this->id;
    $result = $mysqli->query($sql);
    $dsatz = $result->fetch_assoc();
    $this->id;
    $this->firstname = $dsatz["firstname"];
    $this->lastname = $dsatz["lastname"];
    $this->username = $dsatz["username"];
    $this->mail = $dsatz["mail"];
    $result->close();
    $mysqli->close();
  }

  function change_data(
    $firstname_input,
    $lastname_input,
    $username_input,
    $mail_input
  )
  {
    $mysqli = new mysqli("", "admin", "passwort", $this->dbname);
    $stmt = $mysqli->prepare("UPDATE $this->tabname SET firstname = ?,"
      . " lastname = ?, username = ?, mail = ?"
      . " WHERE id = ?");
    $stmt->bind_param(
      "ssssi",
      $firstname_input,
      $lastname_input,
      $username_input,
      $mail_input,
      $this->id
    );
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      $ergebnis = true;
      //$this->id = $id;
    } else
      $ergebnis = false;

    $stmt->close();
    $mysqli->close();

    return $ergebnis;
  }

  function delete_data()
  {
    $mysqli = new mysqli("", "admin", "passwort", $this->dbname);
    $sql = "DELETE FROM $this->tabname WHERE"
      . " id = " . $this->id;
    $mysqli->query($sql);
    if ($mysqli->affected_rows > 0) {
      $ergebnis = true;
    } else
      $ergebnis = false;

    $mysqli->close();

    return $ergebnis;
  }


}

class View extends User
{

  function show_as_formular()
  {
    echo "<div class='user_card'>
    <form method = 'post' class='userdataform'>
    <label>Vorname</label><input type='text' name='fn' value='"
      . $this->firstname . "'>
       <label>Nachname</label><input type='text' name='ln' value='"
      . $this->lastname . "'>
       <label>Username</label><input type='text' name='un' value='"
      . $this->username . "'>
       <label>E-Mail</label><input type='text' name='em' value='"
      . $this->mail . "'>
      <input type='hidden' name='id' value='"
      . $this->id . "'>
      <input type='submit' name='safe_changes' value='speichern' class='change_user_Btn'>
      <input type='reset' class='change_user_Btn'>
      <input type='submit' name='confirm_del_user' value='Account löschen' class='change_user_Btn'>
      </form><div>";
  }

  function show_as_table()
  {
    echo "
    <div class='user_card'>
    Soll der Account wirklich gelöscht werden?<br>
    <table>
    <tr><td>Nachname</td>
    <td>" . $this->lastname . "</td></tr>
     <tr><td>Vorname</td>
     <td>" . $this->firstname . "</td></tr>
     <tr><td>Username</td>
     <td>" . $this->username . "</td></tr>
     <tr><td>E-Mail</td>
     <td>" . $this->mail . "</td></tr>
     <tr><td></table>
     <form method = 'post' class='userdataform'>
     <input type='hidden' name='id' value='"
      . $this->id . "'>
      <button type='submit' name='cancel' value='"
      . $this->id . "' class='change_user_Btn'>abbrechen</button>
       <button type='submit' name='del_user' value='"
      . $this->id . "' class='change_user_Btn'>Account löschen</button>
      </form>
      </td></tr>
     
     </div>
     ";
  }
}

?>