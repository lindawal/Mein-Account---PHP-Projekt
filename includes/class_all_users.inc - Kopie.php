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

class All_Users extends User
{

  public $firstname = array();
  public $lastname = array();
  public $username = array();
  public $mail = array();
  public $backgroundColor = array("#cbc3d3", "#b6e6d2", "#cbcbcb", "#f4eab2", "#c6d7eb", "#e4d4ca" );





  function load_with_filter(
    $search_area,
    $sort,
    $search_input
  )
  {
    $con = new mysqli("", "root", "", $this->dbname);
    $sql = ("SELECT id, lastname, firstname, username, mail FROM $this->tabname WHERE $search_area LIKE ?  ORDER BY $sort");

    $ps = $con->prepare($sql);
    $such_txt = "%" . $search_input . "%";
    $ps->bind_param("s", $such_txt);

    $ps->execute();


    $ps->bind_result($id, $lastname, $firstname, $username, $mail);
    $ps->store_result();
    if ($ps->num_rows == 0)
      echo "Keine Ergebnisse<br>";

    $i = 0;
    $arrLength = count($this->backgroundColor);
    while ($ps->fetch()) {
      if ($i > $arrLength - 1) {
        $i = 0;
      }
      echo "<div class='user-data-box' style='background-color:" . $this->backgroundColor[$i] . "'>
     <h3>" . $firstname . " " . $lastname . "</h3>
     <p>@" . $username . "</p>
     <a href='mailto:" . $mail . "'>" . $mail . "</a>
     <form action='";
      echo linkTo("index.php?page=change_user");
      echo "' method='post' class='myForm'>
     <input type='hidden' name='id' value='"
        . $id . "'>
     <button type='submit' name='change' class='sort_button'>ändern</button>
     </form>
     </div>
     ";
      $i++;
    }
    $ps->close();
    $con->close();

  }
}
?>