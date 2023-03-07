<?PHP
include_once("./classes/user_data.class.php");
class User_Edit extends User_Data
{
  protected $dbname;
  protected $user_tab;
  protected $login_tab;
  //protected $login_date;
  
  public function __construct($user_id="")
  {
    $this->user_id = $user_id;
  }

  public function change_data(
    $firstname_input,
    $lastname_input,
    $username_input,
    $mail_input
  )
  {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $stmt = $mysqli->prepare(
    "UPDATE $this->user_tab INNER JOIN $this->login_tab " .
    "ON $this->user_tab.user_id = $this->login_tab.user_id " . 
    "SET $this->user_tab.firstname = ?, $this->user_tab.lastname = ?, $this->user_tab.username = ?, $this->user_tab.mail = ?, " . 
    "$this->login_tab.username = ? " . 
    "WHERE $this->user_tab.user_id = ?");
    $stmt->bind_param(
      "sssssi",
      $firstname_input,
      $lastname_input,
      $username_input,
      $mail_input,
      $username_input,
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

  function delete_data()
  {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $sql = "DELETE $this->user_tab, $this->login_tab FROM $this->user_tab INNER JOIN $this->login_tab " .
      "ON $this->user_tab.username = $this->login_tab.username ".
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