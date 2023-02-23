<!-- <!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <title>Datensatz ändern</title>
</head>

<body> -->
<?php
/*function changeUser(
  $id,
  $firstname_input,
  $lastname_input,
  $username_input,
  $mail_input
)
{
  $con = new mysqli("", "root", "", $dbname);
  $ps = $con->prepare("UPDATE $tabname SET firstname = ?,"
    . " lastname = ?, username = ?, mail = ?"
    . " WHERE id = ?");
  $ps->bind_param(
    "ssssi",
    $firstname_input,
    $lastname_input,
    $username_input,
    $mail_input,
    $id
  );

  $ps->execute();
  //$ps->bind_result($id, $lastname, $firstname, $username, $mail);
  //$ps->store_result();

  if ($ps->affected_rows > 0)
    $ergebnis = true;
  else
    $ergebnis = false;

  $ps->close();
  $con->close();

  //return $ergebnis;
  return array($ergebnis, $id);
}*/

function deleteUser(
  $dbname,
  $tabname,
  $id
)
{
  $con = new mysqli("", "root", "", $dbname);
  $sql = "DELETE FROM $tabname WHERE"
    . " id = " . $id;
  $con->query($sql);
  if ($con->affected_rows > 0)
    $ergebnis = true;
  else
    $ergebnis = false;

  $con->close();

  return array($ergebnis, $id);
}
?>
<!-- 

 <button type='button' name='back' class='sort_button'><a href='http://localhost/linda/php/db_tabelle_filtern.php'>zurück</a></button>
</body> 

</html>-->