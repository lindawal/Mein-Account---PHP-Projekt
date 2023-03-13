<?PHP
/*
 *   Erstellen von Eingabeformularen bzw. Affenformularen z.B für 
 *   Änderungen in Mein Account
 *   Admin: User-Daten ändern
 *   Registrierung neuer Nutzer
 */

//bindet die benötigte Klasse ein
//include_once("./classes/user_data.class.php");
class Form
{
  protected $firstname;
  protected $lastname;
  protected $username;
  protected $mail;
  private $user_id;
  private $get_data;

  //mit dem Constructor werden die zuvor im Dokument eingegebenen oder geladenen Daten übergeben
  function __construct($get_data)
  {
    $this->get_data = $get_data;
    $this->firstname = $this->get_data->firstname;
    $this->lastname = $this->get_data->lastname;
    $this->username = $this->get_data->username;
    $this->mail = $this->get_data->mail;
    $this->user_id = $this->get_data->user_id;
  }

  //einfache Eingabefelder für Vorname, Nachname und Username
  function input_fields($firstname = "", $lastname = "", $username = "")
  {
    $fields = array('Vorname' => $firstname, 'Nachname' => $lastname, 'Benutzername' => $username);
    foreach ($fields as $label => $value) {
      if (!empty($value))
        echo ("<label>$label</label><input placeholder='$label' name='$value' value='" . $this->$value . "' required='required'>");
    }
  }
  //Eingabefeld für E-Mail
  function input_mail()
  {
    echo "<label>E-Mail</label><input type='email' placeholder='E-Mail' name='mail' value='" . $this->mail . "' required='required'>";
  }
  //Eingabefeld für Passwort
  function input_password()
  {
    echo "<label>Passwort</label><input type='password' placeholder='Passwort' name='password' required='required'>";
  }
  //verstecktes Feld zum übertragen der Id
  function input_hidden_id()
  {
    echo "<input type='hidden' name='user_id' value='"
      . $this->user_id . " ' >";
  }
  //disabled Felder in denen die Daten nur angezeigt, aber nicht geändert werden können
  function input_disabled($firstname = "", $lastname = "", $username = "", $mail = "")
  {
    $fields = array('Vorname' => $firstname, 'Nachname' => $lastname, 'Benutzername' => $username, 'E-Mail' => $mail);
    foreach ($fields as $label => $value) {
      if (!empty($value))
        echo ("<label>$label</label><input placeholder='$label' name='$value' value='" . $this->$value . "' disabled>");
    }
  }

}
?>