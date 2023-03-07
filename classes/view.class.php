<?PHP

include_once("./classes/user_data.class.php");
class View
{
  //protected $user_tab = "user";
  //protected $login_tab = "login_data";
  protected $firstname = array();
  protected $lastname = array();
  protected $username = array();
  protected $mail = array();
  protected $user_id = array();
  protected $_login_date = array();
  public $data_length;
  protected $_name_shorty = array();

//var $user_data;
// public function __construct($user_id)
// {
// $this->user_id = $user_id;
// $this->user_data = new User_Data($user_id);
// $data = $this->user_data->load_data();
// $this->firstname = $data[0];
// $this->lastname = $data[1];
// $this->username = $data[2];
// $this->mail = $data[3];
// }

    // function avatar($firstname, $lastname)
    // {
    // //Kürzel erstellen: ersten Buchstaben aus jedem Namensteil
    // $shorty = substr($firstname, 0, 1) . substr($lastname, 0, 1);
    // return array($shorty);
    // }

  protected function avatar()
  {
    $data_i = 0;
    while ($data_i < $this->data_length) {
      //Kürzel erstellen: ersten Buchstaben aus jedem Namensteil
      $shorty = substr($this->firstname[$data_i], 0, 1) . substr($this->lastname[$data_i], 0, 1);
      array_push($this->_name_shorty, $shorty);
      $data_i++;
      //return array($lastname, $firstname, $shorty);
    }
  }

    function format_date($date)
    {
    /*array mit regulären Ausdrücken zum Umstellen des mit Now() erzeugten Datums:
    (20)(zahl, 2-stellig)-(zahl, 1-2-stellig)-(zahl, 1-2-stellig)leerzeichen(zahl, 2-stellig):(zahl,
    1-2-stellig):(zahl, 1-2-stellig)*/
    $date_regex = '/(20)(\d{2})-(\d{1,2})-(\d{1,2})\s(\d{2}):(\d{1,2}):(\d{1,2})/';
    $date_replace = '${4}.${3}.${1}${2} ${5}:${6} Uhr'; /*array mit Ersatzsymbolen/zeichen: Angabe der nummerierten
    Ausdrücke, zuerst der 4., dann der 3. etc. der letzte wird weg gelassen, statt dessen "Uhr" eingefügt*/
    $formated_date = preg_replace($date_regex, $date_replace, $date);
    return $formated_date;
    }

    }

class All_Users_View extends View
{
  private $_card_Color = array("#cbc3d3", "#b6e6d2", "#cbcbcb", "#f4eab2", "#c6d7eb", "#e4d4ca");
  private $load_data;

  function __construct($load_data) {
   // $load_data = new All_Users_Data();
    $this->load_data = $load_data;
    $this->data_length = $this->load_data->data_length;
    $this->firstname = $this->load_data->firstname;
    $this->lastname = $this->load_data->lastname;
    $this->_login_date = $this->load_data->_login_date;
    $this->username = $this->load_data->username;
    $this->mail = $this->load_data->mail;
    $this->user_id = $this->load_data->user_id;
  }

  public function show_as_grid()
  {
  $this->avatar();

    $col_i = 0;
    $data_i = 0;
    $col_length = count($this->_card_Color);
    if ($this->data_length > 0) {
      while ($data_i < $this->data_length) {
      $formated_date = $this->format_date($this->_login_date[$data_i]);
        //array_push($this->_login_date, $formated_date);
        if ($col_i > $col_length - 1) {
          $col_i = 0;
        }
        echo "<div class='user-data-box' style='background-color:" . $this->_card_Color[$col_i] . "'>
    <div class='card_avatar' style='color:" . $this->_card_Color[$col_i] . "'>" . $this->_name_shorty[$data_i] . "</div>
    <h3>" . $this->firstname[$data_i] . " " . $this->lastname[$data_i] . "</h3>
    <p>letzter Login:<br>" . $formated_date . "</p>
    <p>@" . $this->username[$data_i] . "</p>
    <a href='mailto: " . $this->mail[$data_i] . "'><img src='./images/mail.svg'>" . $this->mail[$data_i] . "</a>
    <form action='";
        echo linkTo("admin.php?page=change_user");
        echo "' method='post' class='myForm'>
    <input type='hidden' name='user_id' value='"
          . $this->user_id[$data_i] . "'>
    <button type='submit' name='change' class='sort_button'>ändern</button>
     </form>
     </div>
     ";
        $col_i++;
        $data_i++;
      }
    } else
      echo "Keine Ergebnisse";
  }
}

class One_User_View extends View
{
  private $load_data;

  function __construct($load_data)
  {
    // $load_data = new All_Users_Data();
    $this->load_data = $load_data;
    $this->firstname = $this->load_data->firstname;
    $this->lastname = $this->load_data->lastname;
    $this->_login_date = $this->load_data->login_date;
    $this->username = $this->load_data->username;
    $this->mail = $this->load_data->mail;
    $this->user_id = $this->load_data->user_id;
  }

  function show_as_formular()
  {
    echo "<div class='user_card'>
  <form method='post' class='userdataform'>
    <label>Vorname</label><input type='text' name='fn' value='"
      . $this->firstname . "'>
    <label>Nachname</label><input type='text' name='ln' value='"
      . $this->lastname . "'>
    <label>Username</label><input type='text' name='un' value='"
      . $this->username . "'>
    <label>E-Mail</label><input type='text' name='em' value='"
      . $this->mail . "'>
    <input type='hidden' name='user_id' value='"
      . $this->user_id . "'>
    <input type='submit' name='safe_changes' value='speichern' class='change_user_Btn'>
    <input type='reset' class='change_user_Btn'>
    <input type='submit' name='confirm_del_user' value='Account löschen' class='change_user_Btn'>
  </form>
  <div>";
  }

  function show_as_table()
  {
    echo "
    <div class='user_card'>
      Soll der Account wirklich gelöscht werden?<br>
      <table>
        <tr>
          <td>Nachname</td>
          <td>" . $this->lastname . "</td>
        </tr>
        <tr>
          <td>Vorname</td>
          <td>" . $this->firstname . "</td>
        </tr>
        <tr>
          <td>Username</td>
          <td>" . $this->username . "</td>
        </tr>
        <tr>
          <td>E-Mail</td>
          <td>" . $this->mail . "</td>
        </tr>
        <tr>
          <td>
      </table>
      <form method='post' class='userdataform'>
        <input type='hidden' name='user_id' value='"
      . $this->user_id . "'>
        <button type='submit' name='cancel' value='"
      . $this->user_id . "' class='change_user_Btn'>abbrechen</button>
        <button type='submit' name='del_user' value='"
      . $this->user_id . "' class='change_user_Btn'>Account löschen</button>
      </form>
      </td>
      </tr>
    </div>
    ";
  }
}
?>