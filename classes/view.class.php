<?PHP

/*
 *   Laden der Ansicht für den Bereich 
 *   Header: Avatar, Datum formatieren
 *   User: Meine Kontakte
 *   Admin: alle User
 */

include_once("./classes/user_data.class.php");

class View
{
  protected $firstname = array();
  protected $lastname = array();
  protected $username = array();
  protected $mail = array();
  protected $user_id = array();
  protected $_login_date = array();
  public $data_length;
  protected $_name_shorty = array();

  //das kürzel für den Avatar erstellen
  public function avatar($firstname, $lastname)
  {
    //Kürzel erstellen: ersten Buchstaben aus jedem Namensteil
    $shorty = substr($firstname, 0, 1) . substr($lastname, 0, 1);
    return $shorty;
  }

  //das unformatierte Datum aus der Now() Funktion umstellen
  public function format_date($date)
  {
    /*array mit regulären Ausdrücken zum Umstellen des mit Now() erzeugten Datums:
    (20)(zahl, 2-stellig)-(zahl, 1-2-stellig)-(zahl, 1-2-stellig)leerzeichen(zahl, 2-stellig):(zahl,
    1-2-stellig):(zahl, 1-2-stellig)*/
    $date_regex = '/(20)(\d{2})-(\d{1,2})-(\d{1,2})\s(\d{2}):(\d{1,2}):(\d{1,2})/';
    $date_replace = '${4}.${3}.${1}${2} ${5}:${6} Uhr'; /*array mit Ersatzsymbolen/zeichen: Angabe der nummerierten Ausdrücke, zuerst der 4., dann der 3. etc. der letzte wird weg gelassen, statt dessen "Uhr" eingefügt*/
    $formated_date = preg_replace($date_regex, $date_replace, $date);
    return $formated_date;
  }

}

class All_Users_View extends View
{
  private $_card_Color = array("#cbc3d3", "#b6e6d2", "#cbcbcb", "#f4eab2", "#c6d7eb", "#e4d4ca");
  private $load_data;
  private $_formated_date = array();


  //mit dem Constructor werden die zuvor im Dokument eingegebenen oder geladenen Daten übergeben
  function __construct($load_data)
  {
    $this->load_data = $load_data;
    $this->data_length = $this->load_data->data_length;
    $this->firstname = $this->load_data->firstname;
    $this->lastname = $this->load_data->lastname;
    $this->_login_date = $this->load_data->_login_date;
    $this->username = $this->load_data->username;
    $this->mail = $this->load_data->mail;
    $this->user_id = $this->load_data->user_id;
  }

  private function avatar_to_array()
  {
    $i = 0;
    while ($i < $this->data_length) {
      //Kürzel erstellen: ersten Buchstaben aus jedem Namensteil
      $shorty = $this->avatar($this->firstname[$i], $this->lastname[$i]);
      array_push($this->_name_shorty, $shorty);
      $i++;
    }
  }

  private function date_to_array()
  {
    $i = 0;
    while ($i < $this->data_length) {
      $formated_date = $this->format_date($this->_login_date[$i]);
      array_push($this->_formated_date, $formated_date);
      $i++;
    }
  }

  //die Ansicht mit den Daten zu allen Usern wird erstellt
  public function show_as_grid()
  {
    $this->avatar_to_array();
    $this->date_to_array();

    $col_numb = 0; //Nummerierung der HG-Farbe
    $data_numb = 0; //Nummerierung der Nutzer-Daten
    $col_length = count($this->_card_Color);
    if ($this->data_length > 0) {
      while ($data_numb < $this->data_length) {
        if ($col_numb > $col_length - 1) { //wenn die höchste Nummerierung aller vorhanden HG-Farben erreicht ist, soll der Array wieder von vorn durchlaufen werden
          $col_numb = 0;
        }
        echo "<div class='user-data-box' style='background-color:" . $this->_card_Color[$col_numb] . "'>
        <div class='card_avatar' style='color:" . $this->_card_Color[$col_numb] . "'>" . $this->_name_shorty[$data_numb] . "</div>
        <h3>" . $this->firstname[$data_numb] . " " . $this->lastname[$data_numb] . "</h3>
        <p>letzter Login:<br>" . $this->_formated_date[$data_numb] . "</p>
        <p>@" . $this->username[$data_numb] . "</p>
        <a href='mailto:" . $this->mail[$data_numb] . "'><img src='./images/mail.svg' alt='mail icon'>" . $this->mail[$data_numb] . "</a>
        <form action='";
        echo linkTo("admin.php", "?page=change_user");
        echo "' method='post' class='myForm'>
        <input type='hidden' name='user_id' value='"
          . $this->user_id[$data_numb] . "'>
        <button type='submit' name='change' class='sort_button'>ändern</button>
        </form>
        </div>
        ";
        $col_numb++;
        $data_numb++;
      }
    } else
      echo "Keine Ergebnisse";
  }

  //die Ansicht mit den Daten zu allen Kontakten wird erstellt
  public function contacts_as_grid()
  {
    $this->avatar_to_array();

    $col_numb = 0;
    $data_numb = 0;
    $col_length = count($this->_card_Color);
    if ($this->data_length > 0) {
      while ($data_numb < $this->data_length) {
        if ($col_numb > $col_length - 1) {
          $col_numb = 0;
        }
        echo "<div class='user-data-box' style='background-color:" . $this->_card_Color[$col_numb] . "'>
        <div class='card_avatar' style='color:" . $this->_card_Color[$col_numb] . "'>" . $this->_name_shorty[$data_numb] . "</div>
        <h3>" . $this->firstname[$data_numb] . " " . $this->lastname[$data_numb] . "</h3><p>@" . $this->username[$data_numb] . "</p>
        <a href='mailto:" . $this->mail[$data_numb] . "'><img src='./images/mail.svg' alt='mail icon'></a>
        </div>";
        $col_numb++;
        $data_numb++;
      }
    } else
      echo "Keine Ergebnisse";
  }

}
?>