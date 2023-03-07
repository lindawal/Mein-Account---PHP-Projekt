<?PHP
require_once("database.config.php");
class User_Data
{
  protected $user_tab = "user";
  protected $login_tab = "login_data";
  public $firstname;
  public $lastname;
  public $username;
  public $mail;
  public $user_id;
  protected $password;
  protected $admin_rights;
  public $login_date;

  //   function __construct($firstname="", $lastname="", $username="", $mail="", $password="")
  // {
  //   $this->firstname = $this->convert_input($firstname);
  //   $this->lastname = $this->convert_input($lastname);
  //   $this->username = $this->convert_input($username);
  //   $this->mail = $this->convert_input($mail);
  //   $this->password = $this->convert_input($password);
  // }
  
  public function load_data($user_id)
  {
    // $database = new Database();
    // $db_access = $database->database_access();
    // $user_tab = $db_access['tb_user'];
    // $login_tab = $db_access['tb_login'];

    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $sql = "SELECT * FROM $this->user_tab INNER JOIN $this->login_tab ON $this->user_tab.user_id = $this->login_tab.user_id WHERE $this->user_tab.user_id = $user_id";
    $result = $mysqli->query($sql);
    $dsatz = $result->fetch_assoc();
    $this->user_id= $user_id;
    $this->firstname = $dsatz["firstname"];
    $this->lastname = $dsatz["lastname"];
    $this->username = $dsatz["username"];
    $this->mail = $dsatz["mail"];
    $this->admin_rights = $dsatz["admin"];
    $this->login_date = $dsatz["login_date"];
    $result->close();
    $mysqli->close();

    return array("user_id" => $this->user_id, "firstname" => $this->firstname, "lastname" => $this->lastname, "username" => $this->username, "mail" => $this->mail, "login_date" => $this->login_date, "admin_rights" => $this->admin_rights);
  }

  public function validate_data()
  {
    //im Vor-, Nach- und Usernamen erlaubte Zeichen: A-Z (mind. 1x Pflicht), ÜÄÖ (case insensitiv), Leerzeichen zwischen Doppelnamen und ,.-
    $pattern_name = '/^[a-z][a-zäöü ,.-]+$/i';
    $pattern_username = '/^[a-z][\da-zäöü ._-]{3,}$/i'; //Username kann außerdem Zahlen enthalten
    $pattern_mail = '/[.]/';
    $pattern_password = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!?+.*-])(?!.*\s).{6,15}/';

    $firstnameErr = $lastnameErr = $usernameErr = $mailErr = $passwordErr = "";

    if (!empty($this->firstname)){
    if (!preg_match($pattern_name, $this->firstname)) { //Prüfung ob eingegebene Daten valide sind
      $firstnameErr = "Der Vorname darf nur Buchstaben (A - Z, Ü, Ä, Ö) und Sonderzeichen (,.-) enthalten.<br>"; //Fehlermeldung
    }}
    if (!empty($this->lastname)){
    if (!preg_match($pattern_name, $this->lastname)) {
      $lastnameErr = "Der Nachname darf nur Buchstaben (A - Z, Ü, Ä, Ö) und Sonderzeichen (,.-) enthalten.<br>";
    } }
    if (!empty($this->username)){
    if (!preg_match($pattern_username, $this->username)) {
      $usernameErr = "Der Username muss mindestens aus 4 Zeichen bestehen und darf nur Buchstaben (A - Z, Ü, Ä, Ö), Zahlen und Sonderzeichen (.-_) enthalten.<br>";
    }}
    if (!empty($this->mail)){
    if (!preg_match($pattern_mail, $this->mail)) {
      $mailErr = "Keine gültige E-Mail-Adresse.<br>";
    }}
    if (!empty($this->password)){
    if (!preg_match($pattern_password, $this->password)) {
      $passwordErr = "Das Passwort muss aus 6 - 15 Zeichen bestehen und folgendes enthalten: Sonderzeichen (!?+.*-), Zahl, Groß- und einen Kleinbuchstaben.<br>";
    }
    }
    return array('firstname' => $firstnameErr, 'lastname' => $lastnameErr, 'username' => $usernameErr, 'mail' => $mailErr, 'password' => $passwordErr);
  }

  protected function convert_input($data)
  {
    $data = trim($data); //Leerzeichen entfernen
    $data = stripslashes($data); //Slashes entfernen
    $data = htmlspecialchars($data); //Sonderzeichen konvertieren
    return $data;
  }
}

?>