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
    $con = new mysqli("", "admin", "passwort", $this->dbname);
    $sql = "SELECT * FROM $this->tabname WHERE id = "
      . $this->id;
    $res = $con->query($sql);
    $dsatz = $res->fetch_assoc();
    $this->id;
    $this->firstname = $dsatz["firstname"];
    $this->lastname = $dsatz["lastname"];
    $this->username = $dsatz["username"];
    $this->mail = $dsatz["mail"];
    $res->close();
    $con->close();
  }

  function change_data(
    $firstname_input,
    $lastname_input,
    $username_input,
    $mail_input
  )
  {
    $con = new mysqli("", "admin", "passwort", $this->dbname);
    $ps = $con->prepare("UPDATE $this->tabname SET firstname = ?,"
      . " lastname = ?, username = ?, mail = ?"
      . " WHERE id = ?");
    $ps->bind_param(
      "ssssi",
      $firstname_input,
      $lastname_input,
      $username_input,
      $mail_input,
      $this->id
    );
    $ps->execute();

    if ($ps->affected_rows > 0) {
      $ergebnis = true;
      //$this->id = $id;
    } else
      $ergebnis = false;

    $ps->close();
    $con->close();

    return $ergebnis;
  }

  function delete_data()
  {
    $con = new mysqli("", "admin", "passwort", $this->dbname);
    $sql = "DELETE FROM $this->tabname WHERE"
      . " id = " . $this->id;
    $con->query($sql);
    if ($con->affected_rows > 0) {
      $ergebnis = true;
    } else
      $ergebnis = false;

    $con->close();

    return $ergebnis;
  }


}

class View extends User
{

  //parent::__construct();
//parent::data();

  function show_as_formular()
  {
    echo "<form method = 'post' class='userdataform'>
   <label>Vorname</label><input name='fn' value='"
      . $this->firstname . "'>
       <label>Nachname</label><input name='ln' value='"
      . $this->lastname . "'>
       <label>Username</label><input name='un' value='"
      . $this->username . "'>
       <label>E-Mail</label><input name='em' value='"
      . $this->mail . "'>
      <input type='hidden' name='id' value='"
      . $this->id . "'>
      <input type='reset' class='change_user_Btn'>
      <input type='submit' name='safe_changes' value='speichern' class='change_user_Btn'>
    
      <input type='submit' name='confirm_del_user' value='Account löschen' class='changeBtn'>
      </form>";
  }

  function show_as_table()
  {
    echo "Soll der Account wirklich gelöscht werden?<br>
    <table>
    <tr><td>Nachname</td>
    <td>" . $this->lastname . "</td></tr>
     <tr><td>Vorname</td>
     <td>" . $this->firstname . "</td></tr>
     <tr><td>Username</td>
     <td>" . $this->username . "</td></tr>
     <tr><td>E-Mail</td>
     <td>" . $this->mail . "</td></tr>
     <tr><td>
     <form method = 'post' class='userdataform'>
     <input type='hidden' name='id' value='"
      . $this->id . "'>
      <button type='submit' name='cancel' value='"
      . $this->id . "' class='change_user_Btn'>abbrechen</button>
    </td><td>
      <button type='submit' name='del_user' value='"
      . $this->id . "' class='change_user_Btn'>Account löschen</button></form>
      </td></tr>
     </table>";
  }
}

?>

<!-- <input type='submit' name='del_user' value='Account löschen' class='changeBtn'> -->