<?PHP

include_once("./classes/user_data.class.php");
class Form
{
  protected $firstname; 
  protected $lastname;
  protected $username;
  protected $mail;
  protected $password;
  private $get_data;

  function __construct($get_data)
  {
    // $get_data = new All_Users_Data();
    $this->get_data = $get_data;
    $this->firstname = $this->get_data->firstname;
    $this->lastname = $this->get_data->lastname;
    $this->username = $this->get_data->username;
    $this->mail = $this->get_data->mail;
    //$this->password = $this->get_data->password;
  }

/*
$fruechte = ['Frühjahr' => 'Erdbeeren', 'Sommer' => 'Pflaumen', 'Herbst' => 'Äpfel', 'Winter' => 'Mandarinen'];
foreach ($fruechte as $jahreszeit => $frucht) {
    echo ("Im $jahreszeit reifen $frucht. ");
}
oder vereinfacht ohne Schlüssel:


foreach ($fruechte as $frucht) {
    echo ("Es gibt $frucht. ");
}
*/

  function input_fields($firstname="", $lastname="", $username="") {
  $fields = array ('Vorname' => $firstname, 'Nachname' => $lastname, 'Benutzername' => $username);
    foreach ($fields as $placeholder => $value) {
    if (!empty ($value))
     echo ("<input placeholder='$placeholder' name='$value' value='" . $this->$value . "' required='required'>");
   }
  }
  function input_mail()
  {
    echo "<input type='email' placeholder='E-Mail' name='mail' value='" . $this->mail . "' required='required'>";
  }
    function input_password() {
    echo "<input type='password' placeholder='Passwort' name='password' required='required'>";
  }


}
  ?>