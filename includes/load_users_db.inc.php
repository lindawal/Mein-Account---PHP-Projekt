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
 
  while ($ps->fetch()) {
    echo "<div class='user-data-box'>
     <p>" . $firstname . " " . $lastname . "</p>
     <p>" . $username . "</p>
     <p>" . $mail . "</p>
     <form action='";
     echo linkTo("index.php?page=change_user");
     echo "' method='post' class='myForm'>
     <input type='hidden' name='id' value='"
      . $id . "'>
     <button type='submit' name='change' class='sort_button'>ändern</button>
     </form>
     </div>
     ";
    }
$ps->close();
  $con->close();

}
}
?>