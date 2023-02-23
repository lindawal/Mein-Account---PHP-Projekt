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


function load_users_db(
  $dbname,
  $tabname,
  $searchArea_input,
  $sort,
  $search_input
) 
{


  $con = new mysqli("", "root", "", $dbname);
  $sql = ("SELECT id, lastname, firstname, username, mail FROM $tabname WHERE $searchArea_input LIKE ? ORDER BY $sort");

  $ps = $con->prepare($sql);
  $such_txt = "%" . $search_input . "%";
  $ps->bind_param("s", $such_txt);

  $ps->execute();


  $ps->bind_result($id, $lastname, $firstname, $username, $mail);
  $ps->store_result();
  if ($ps->num_rows == 0)
    echo "Keine Ergebnisse<br>";
 
  while ($ps->fetch()) {
    echo "<tr>"
     . "<td>" . $lastname . "</td>
     <td>" . $firstname . "</td>
     <td>" . $username . "</td>
     <td>" . $mail . "</td>
     <td>
     <form action='";
     echo linkTo("index.php?page=change_user");
     echo "'method='post' id='myForm'>
     <input type='hidden' name='id' value='"
      . $id . "'>
     <button type='submit' name='change' class='sort_button'>ändern</button></form></td>"
     . "</tr>";
    }
  echo "</table>";
$ps->close();
  $con->close();

}

?>

<!-- <a href='db_tabelle_filtern.php?page=change_user'>ändern</a> -->