<?php

/*
*   Laden der Daten für den Bereich 
*   User: Meine Kontakte
*   Admin: alle User
*/

require_once("./includes/database.config.php");
class All_Users_Data
{
  //Tabellen
  protected $user_tab = "user";
  protected $login_tab = "login_data";
  protected $contact_tab = "contactlist";

  //Daten der User
  public $firstname = array();
  public $lastname = array();
  public $username = array();
  public $mail = array();
  public $user_id = array();
  public $_login_date = array();
  public $data_length;
  protected $_contact_list = array();


  //die Daten aller User mit Filtern laden
  //Filter: Suche Eingabe, Suche in welchem Bereich und Sortiereihenfolge der Ergebnisse
  public function load_with_filter(
    $cur_user_id,
    $search_area,
    $sort,
    $search_input
  )
  {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $sql = ("SELECT $this->user_tab.user_id, $this->user_tab.lastname, $this->user_tab.firstname, $this->user_tab.username, mail, login_date FROM $this->user_tab INNER JOIN $this->login_tab ON $this->user_tab.username = $this->login_tab.username WHERE $this->user_tab.$search_area LIKE ? AND NOT $this->user_tab.user_id = $cur_user_id ORDER BY $sort");
    $stmt = $mysqli->prepare($sql);
    $search_txt = "%" . $search_input . "%"; //Suchparameter + % so dass dieser sowohl am anfang, als auch am ende vorkommen kann
    $stmt->bind_param("s", $search_txt);

    $stmt->execute();

    $stmt->bind_result($user_id, $lastname, $firstname, $username, $mail, $login_date);
    $stmt->store_result();
    if ($stmt->num_rows > 0)
      while ($stmt->fetch()) { //die gefunden Daten in die jeweiligen Arrays speichern
        $this->user_id[] = $user_id;
        array_push($this->firstname, $firstname);
        array_push($this->lastname, $lastname);
        array_push($this->username, $username);
        array_push($this->mail, $mail);
        array_push($this->_login_date, $login_date);
      }
    $this->data_length = count($this->user_id); //Anzahl der Ergerbnisse zählen und speichern

    $stmt->close();
    $mysqli->close();
  }

  //Anzahl und Ids der Kontakte für die User Ansicht ermitteln
  private function get_contact_list($user_id)
  {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);

    //Abfrage der Anzahl an Spalten, die mit 'c' beginnen, da diese die Kontakte enthalten z.b. contact_id_3
    $sql = ("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$this->contact_tab' and COLUMN_NAME like 'c%'");
    $result = $mysqli->query($sql);
    $column_info = $result->fetch_all();
    $column_numb = count($column_info); //Speichern des Ergebnisses

    //es werden so viele Ergebnisse geladen, wie in $column_numb gezählt wurden
    //Zählvariable $data_numb beginnt mit 2, da in der Tabelle contactlist in der ersten Spalte die id und in der zweiten die eigene user_id steht
    //die Kontakt-ids sind erst ab Spalte Nr. 3 'contact_id_1' abrufbar
    $data_numb = 2;
    if ($column_numb > 0) {
      while ($data_numb < $column_numb) {
        $sql = ("SELECT * FROM $this->contact_tab WHERE $this->contact_tab.user_id = $user_id");
        $result = $mysqli->query($sql);
        while ($user_row = $result->fetch_row()) {
          array_push($this->_contact_list, $user_row[$data_numb]); //KOntak-Ids im array speichern
        }
        $data_numb++;
      }

      $this->data_length = count($this->_contact_list); //Anzahl der Ergebnisse zählen und speichern

      $result->close();
      $mysqli->close();
    }
  }

  //die Daten der jeweiligen Kontakte des Users laden 
  public function load_contact_data(
    $cur_user_id,
    //Id des eingeloggten Users
    $sort, //Sortierreihenfolge der Ergebnisse
  )
  {
    $this->user_id = $cur_user_id;
    $this->get_contact_list($this->user_id);

    $data_numb = 0;
    if ($this->data_length > 0) {
      while ($data_numb < $this->data_length) {
        $contact_id = $this->_contact_list[$data_numb]; //Id des Kontaktes, zu dem die Daten im aktuellen Durchlauif der Schleife geladen werden sollen

        $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        $sql = ("SELECT $this->user_tab.lastname, $this->user_tab.firstname, $this->user_tab.username, $this->user_tab.mail FROM $this->user_tab WHERE $this->user_tab.user_id = $contact_id");
        $stmt = $mysqli->prepare($sql);

        $stmt->execute();

        $stmt->bind_result($lastname, $firstname, $username, $mail);
        $stmt->store_result();
        if ($stmt->num_rows > 0)
          while ($stmt->fetch()) { //Speichern der Daten des Kontaktes im Array
            array_push($this->firstname, $firstname);
            array_push($this->lastname, $lastname);
            array_push($this->username, $username);
            array_push($this->mail, $mail);
          }
        $data_numb++;
      }
    }

    $stmt->close();
    $mysqli->close();
  }
}

?>