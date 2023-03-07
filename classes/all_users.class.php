<?php

//include_once("./classes/user_data.class.php");
require_once("database.config.php");
class All_Users_Data //extends User_Data
{

  protected $user_tab = "user";
  protected $login_tab = "login_data";
  public $firstname = array();
  public $lastname = array();
  public $username = array();
  public $mail = array();
  public $user_id = array();
  public $_login_date = array();
  public $data_length;
  protected $_name_shorty = array();
  protected $_card_Color = array("#cbc3d3", "#b6e6d2", "#cbcbcb", "#f4eab2", "#c6d7eb", "#e4d4ca");

 // function __construct() {}

  public function load_with_filter(
    $search_area,
    $sort,
    $search_input
  )
  {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $sql = ("SELECT $this->user_tab.user_id, $this->user_tab.lastname, $this->user_tab.firstname, $this->user_tab.username, mail, login_date FROM $this->user_tab INNER JOIN $this->login_tab ON $this->user_tab.username = $this->login_tab.username WHERE $this->user_tab.$search_area LIKE ?  ORDER BY $sort");
    $stmt = $mysqli->prepare($sql);
    $search_txt = "%" . $search_input . "%";
    $stmt->bind_param("s", $search_txt);

    $stmt->execute();

    $stmt->bind_result($user_id, $lastname, $firstname, $username, $mail, $login_date);
    $stmt->store_result();
    if ($stmt->num_rows > 0)
      while ($stmt->fetch()) {
        $this->user_id[] = $user_id;
        array_push($this->firstname, $firstname);
        array_push($this->lastname, $lastname);
        array_push($this->username, $username);
        array_push($this->mail, $mail);
        // $formated_date = $this->format_date($login_date);
        //array_push($this->_login_date, $formated_date);
        array_push($this->_login_date, $login_date);
      }
    $this->data_length = count($this->user_id);
    //$this->avatar();

    $stmt->close();
    $mysqli->close();
  }

  // protected function avatar()
  // {
  //   $data_i = 0;
  //   while ($data_i < $this->data_length) {
  //     //Kürzel erstellen: ersten Buchstaben aus jedem Namensteil
  //     $shorty = substr($this->firstname[$data_i], 0, 1) . substr($this->lastname[$data_i], 0, 1);
  //     array_push($this->_name_shorty, $shorty);
  //     $data_i++;
  //     //return array($lastname, $firstname, $shorty);
  //   }
  // }

  // protected function format_date($date)
  // {
  //   //array mit regulären Ausdrücken zum Umstellen des mit Now() erzeugten Datums: 
  //   //(20)(zahl, 2-stellig)-(zahl, 1-2-stellig)-(zahl, 1-2-stellig)leerzeichen(zahl, 2-stellig):(zahl, 1-2-stellig):(zahl, 1-2-stellig)
  //   $date_regex = '/(20)(\d{2})-(\d{1,2})-(\d{1,2})\s(\d{2}):(\d{1,2}):(\d{1,2})/';
  //   $date_replace = '${4}.${3}.${1}${2} ${5}:${6} Uhr'; //array mit Ersatzsymbolen/zeichen: Angabe der nummerierten Ausdrücke, zuerst der 4., dann der 3. etc. der letzte wird weg gelassen, statt dessen "Uhr" eingefügt
  //   $formated_date = preg_replace($date_regex, $date_replace, $date);
  //   return $formated_date;
  // }
}

// class Show_All_Users extends All_Users_Data
// {
//   public function show_as_grid()
//   {
//     $col_i = 0;
//     $data_i = 0;
//     $col_length = count($this->_card_Color);
//     if ($this->data_length > 0) {
//       while ($data_i < $this->data_length) {
//         if ($col_i > $col_length - 1) {
//           $col_i = 0;
//         }
//         echo "<div class='user-data-box' style='background-color:" . $this->_card_Color[$col_i] . "'>
//     <div class='card_avatar' style='color:" . $this->_card_Color[$col_i] . "'>" . $this->_name_shorty[$data_i] . "</div>
//     <h3>" . $this->firstname[$data_i] . " " . $this->lastname[$data_i] . "</h3>
//     <p>letzter Login:<br>" . $this->_login_date[$data_i] . "</p>
//     <p>@" . $this->username[$data_i] . "</p>
//     <a href='mailto: " . $this->mail[$data_i] . "'><img src='./images/mail.svg'>" . $this->mail[$data_i] . "</a>
//     <form action='";
//         echo linkTo("index.php?page=change_user");
//         echo "' method='post' class='myForm'>
//     <input type='hidden' name='user_id' value='"
//           . $this->user_id[$data_i] . "'>
//     <button type='submit' name='change' class='sort_button'>ändern</button>
//      </form>
//      </div>
//      ";
//         $col_i++;
//         $data_i++;
//       }
//     } else
//       echo "Keine Ergebnisse";
//   }
// }
?>