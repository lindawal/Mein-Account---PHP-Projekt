<?php

/**
 * 
 * 
 * @param string dbname = Name der Datenbank
 * @param string tabname = Tabellenname
 * @param string searchArea_input = Bereich/Spalte die durchsucht wird
 * @param string sort = Spalte nach der Sortiert wird
 * @param string search_input = Suchbegriff aus der Eingabemaske
 */


include_once("./includes/class_user.php");

class All_Users
{
  public $dbname = "logindaten_neu";
  public $tabname = "user";
  public $firstname = array();
  public $lastname = array();
  public $username = array();
  public $mail = array();
  public $id = array();
  public $data_length;
  public $name_shorty = array();
  public $card_Color = array("#cbc3d3", "#b6e6d2", "#cbcbcb", "#f4eab2", "#c6d7eb", "#e4d4ca");




  function load_with_filter(
    $search_area,
    $sort,
    $search_input
  )
  {
    $mysqli = new mysqli("", "root", "", $this->dbname);
    $sql = ("SELECT id, lastname, firstname, username, mail FROM $this->tabname WHERE $search_area LIKE ?  ORDER BY $sort");
    $stmt = $mysqli->prepare($sql);
    $search_txt = "%" . $search_input . "%";
    $stmt->bind_param("s", $search_txt);

    $stmt->execute();

    $stmt->bind_result($id, $lastname, $firstname, $username, $mail);
    $stmt->store_result();
    if ($stmt->num_rows > 0)
      while ($stmt->fetch()) {
        $this->id[] = $id;
        array_push($this->firstname, $firstname);
        array_push($this->lastname, $lastname);
        array_push($this->username, $username);
        array_push($this->mail, $mail);
      }
    $this->data_length = count($this->id);
    $this->avatar();

    $stmt->close();
    $mysqli->close();
  }

  public function avatar()
  {
    $data_i = 0;
    while ($data_i < $this->data_length) {
      $shorty = substr($this->lastname[$data_i], 0, 1) . substr($this->firstname[$data_i], 0, 1);
      array_push($this->name_shorty, $shorty);
       $data_i++;

      //   //$shorty_first = substr($firstname, 0, 1); //Kürzel erstellen: ersten Buchstaben aus jedem Namensteil
//   return array($lastname, $firstname, $shorty);
    }
  }

  function show_as_grid()
  {
      $col_i = 0;
    $data_i = 0;
    $col_length = count($this->card_Color);
    if ($this->data_length > 0) {
      while ($data_i < $this->data_length) {
        if ($col_i > $col_length - 1) {
          $col_i = 0;
        }
        echo "<div class='user-data-box' style='background-color:" . $this->card_Color[$col_i] . "'>
    <div class='card_avatar' style='color:" . $this->card_Color[$col_i] . "'>" . $this->name_shorty[$data_i] . "</div>
    <h3>" . $this->firstname[$data_i] . " " . $this->lastname[$data_i] . "</h3>
    <p>@" . $this->username[$data_i] . "</p>
    <img src='./images/mail.svg'><a href='mailto: " . $this->mail[$data_i] . "'>" . $this->mail[$data_i] . "</a>
    <form action='";
        echo linkTo("index.php?page=change_user");
        echo "' method='post' class='myForm'>
    <input type='hidden' name='id' value='"
          . $this->id[$data_i] . "'>
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

//    function personal_avatar($cur_lastname = "", $cur_firstname = "") //es darf auch ein Parameter leer bleiben = ""
// {
//   $lastname = $cur_lastname;
//   $firstname = $cur_firstname;
//   $shorty = substr($lastname, 0, 1)  . substr($firstname, 0, 1);
//   //$shorty_first = substr($firstname, 0, 1); //Kürzel erstellen: ersten Buchstaben aus jedem Namensteil
//   return array($lastname, $firstname, $shorty);
//  $pers_avatar = personal_avatar($_SESSION["firstname"], $_SESSION["lastname"]); //Parameter an die Funktion senden
//   // die return Werte werden mithilfe des Index aus dem Array abgerufen
//   echo  "<div><div class='avatar'>" . $pers_avatar[2] . "</div>" . $pers_avatar[0] . " " .  $pers_avatar[1] . 
//   }
}
?>