<?PHP
include_once("./classes/database.config.php");
echo "Testausgabe<br>";

$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
//var_dump($mysqli);
// if ($mysqli->connect_errno) {
//   printf("Verbindungsfehler: %s\n", $mysqli->connect_error);
//   exit();
// }
// if (!$mysqli->query("SET a=1")) {
//   printf("Error message: %s\n", $mysqli->error);
// }

$query = ("SELECT username FROM user WHERE username like'ad%'");
$res = $mysqli->query($query);

if ($mysqli->error) {
  try {
    throw new Exception("MySQL error $mysqli->error <br> Query:<br> $query", $msqli->errno);
  } catch (Exception $e) {
    echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >";
    echo nl2br($e->getTraceAsString());
  }
}
$ausgabe = array();
$ausgabe[] = $res->fetch_all();


// $ergebnis = mysqli_query($sql) or die(mysqli_error());
//     $stmt->bind_param("s", $this->username);
//     $stmt->execute();
//     if ($stmt->fetch() > 0)
//       $Error = "Der Nutzername ist bereits vergeben.<br>";

    $res->close();
    $mysqli->close();
echo "<br>var ausgabe:<br>";
var_dump($ausgabe);


$password = "User123!";
$username = "user123";
echo "<br><br>var username:<br>";
var_dump($username);

$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD); //baut eine neue Verbindung zum MySQL-Server auf
echo "<br><br>var mysqli:<br>";
var_dump($mysqli);

$sql = "CREATE DATABASE IF NOT EXISTS " . MYSQL_DATABASE; //prüft ob DB bereits vorhanden ist, wenn nicht, dann neu erstellen
echo "<br><br>var sql1:<br>";
var_dump($sql);

$mysqli->query($sql); //mit query, da noch keine Nutzer-Daten übertragen werden
if (!$mysqli->query($sql)) {
  printf("Fehlermeldung: %s\n", $mysqli->error);
}

$mysqli->select_db(MYSQL_DATABASE);
echo "<br><br>var mysqli-1:<br>";
var_dump($mysqli);

//legt die Tabellen-Spalten an
$sql = "CREATE TABLE IF NOT EXISTS user"
  . " (id INT(11) NOT NULL AUTO_INCREMENT,"
  . " user_id INT(10) NOT NULL,"
  . " firstname VARCHAR(50) NOT NULL,"
  . " lastname VARCHAR(50) NOT NULL,"
  . " username VARCHAR(50) NOT NULL,"
  . " mail VARCHAR(100) NOT NULL,"
  . " admin INT(11) NULL DEFAULT NULL,"
  . " PRIMARY KEY (id)"
  . " ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;";
$mysqli->query($sql);

echo "<br><br>var sql2:<br>";
var_dump($sql);
$pw = password_hash($password, PASSWORD_DEFAULT); //übertragenes Passwort verschlüsseln
echo "<br><br>var pw:<br>";
var_dump($pw);

//Eintragung der Daten vorbereiten
$sql_login = "INSERT INTO login_data (username, password) VALUES(?, ?)";
echo "<br><br>var sql_login:<br>";
var_dump($sql_login);
echo "<br><br>Test";

$stmt = $mysqli->prepare($sql_login);

echo "<br><br>var stmt1:<br>";
var_dump($stmt);

$stmt->bind_param(
  "ss",
  $username,
  $pw
);
echo "<br><br>var stmt2:<br>";
var_dump($stmt);

$stmt->execute();

if ($mysqli->error) {
  try {
    throw new Exception("MySQL error $mysqli->error <br> Query:<br> $query", $msqli->errno);
  } catch (Exception $e) {
    echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >";
    echo nl2br($e->getTraceAsString());
  }
}

echo "<br><br>erfolgreich!<br>";


$stmt->close();
$mysqli->close();



?>