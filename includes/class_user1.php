<?PHP

class User
{
  public $dbname = "logindaten_neu";
  public $tabname = "user";
  public $id;
  public $firstname;
  public $lastname;
  public $username;
  public $mail;

  function data($id)
  {
    $con = new mysqli("", "root", "", $this->dbname);
    $sql = "SELECT * FROM $this->tabname WHERE id = "
      . $id;
    $res = $con->query($sql);
    $dsatz = $res->fetch_assoc();
    $this->id = $id;
    $this->firstname = $dsatz["firstname"];
    $this->lastname = $dsatz["lastname"];
    $this->username = $dsatz["username"];
    $this->mail = $dsatz["mail"];
    $res->close();
    $con->close();
  }

  function show()
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
   <div>
      <input type='submit' name='safe_changes' value='speichern' class='changeBtn'>
      <input type='reset'>
      <input type='submit' name='del_user' value='Account löschen' class='changeBtn'>
      </div>
      </form>";
  }

  function change_data(
    $id,
    $firstname_input,
    $lastname_input,
    $username_input,
    $mail_input
  )
  {
    $con = new mysqli("", "root", "", $this->dbname);
    $ps = $con->prepare("UPDATE $this->tabname SET firstname = ?,"
      . " lastname = ?, username = ?, mail = ?"
      . " WHERE id = ?");
    $ps->bind_param(
      "ssssi",
      $firstname_input,
      $lastname_input,
      $username_input,
      $mail_input,
      $id
    );
    $ps->execute();

    if ($ps->affected_rows > 0) {
      $ergebnis = true;
      $this->id = $id;
    } else
      $ergebnis = false;

    $ps->close();
    $con->close();

    return $ergebnis;
  }

  function delete_data($id)
  {
    $con = new mysqli("", "root", "", $this->dbname);
    $sql = "DELETE FROM $this->tabname WHERE"
      . " id = " . $id;
    $con->query($sql);
    if ($con->affected_rows > 0) {
      $ergebnis = true;
      $this->id = $id;
    } else
      $ergebnis = false;

    $con->close();

    return $ergebnis;
  }


}

?>