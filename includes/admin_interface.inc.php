<?PHP

/** Hauptseite im Adminbereich mit der Übersicht aller User und den Filteroptionen
 ***/

if (isset($_SESSION["name"])) {
  if ($_SESSION["admin"] == true) {

    $search_input = ""; //Suchparameter standartmäßig auf leeren String setzen
    if (isset($_GET["search"])) { //wenn Suchparameter gesendet wurde diesen umwandeln
      $search_input = htmlentities($_GET["search"]);
    }

    $search_area = "lastname"; //Suchbereich Default-Wert
    if (isset($_GET["search_area"])) {
      $search_area = $_GET["search_area"];
    }

    $sort = "lastname"; //Sortierung Default-Wert
    if (isset($_GET["sort"])) {
      $sort = $_GET["sort"];
    }

    //Formular zum Angeben der Suchparameter
    echo "<form action='admin.php' method='get' class='myForm'>
        <div class='filter_box'>
        <fieldset class='my-radio'>
        <p><input type='radio' name='search_area' value='lastname'";
    if ($search_area == "lastname") {
      echo " checked='checked'";
    }
    echo "> Nachname</p>
      <p><input type='radio' name='search_area' value='firstname'";
    if ($search_area == "firstname") {
      echo " checked='checked'";
    }
    echo "> Vorname</p>
      <p><input type='radio' name='search_area' value='username'";
    if ($search_area == "username") {
      echo " checked='checked'";
    }
    echo "> Username</p>
      <p><input type='radio' name='search_area' value='mail'";
    if ($search_area == "mail") {
      echo " checked='checked'";
    }
    echo "> E-Mail</p><br></fieldset>
      <input type='text' name='search' placeholder='Suche' value='" . $search_input . "'>
      <input type='submit' class='sort_button'>
      <input type='button' onClick='resetPage();' value='reset' class='sort_button'></div>";

    // Selectfelder für die Sortierung
    // Wenn diese angeklickt werden, wird die Änderung mit Hilfe eines Javascript onchange Events sofort ausgelöst
    // die aktive Option wird mit Hilfe einer If-Anweisung auf "selected" gesetzt
    echo "<label for='sort'>Sortierung:</label>
      <select id='sort' name='sort' onchange='this.form.submit()'>
      <option value='firstname'";
    if ($sort == "firstname") {
      echo " selected";
    }
    echo ">Vorname </option>

      <option value='lastname'";
    if ($sort == "lastname") {
      echo " selected";
    }
    echo ">Nachname </option>
        
      <option value='username'";
    if ($sort == "username") {
      echo " selected";
    }
    echo ">Username</option>
  
      <option value='mail'";
    if ($sort == "mail") {
      echo " selected";
    }
    echo ">E-Mail</option>
      </select>
      </form>";

    //Klassen einbinden um Daten aus der Datenbank zu laden
    //als Variablen werden die Suchparameter gesendet
    include_once("./classes/all_users.class.php");
    include_once("./classes/view.class.php");
    $all_users = new All_Users_Data();
    $all_users->load_with_filter(
      $_SESSION["user_id"],
      $search_area,
      $sort,
      $search_input
    );
    echo $all_users->data_length . " Ergebnisse" .
      "<div class='all-users'>";

    //das Objekt All_Users wird als Parameter in das View Objekt gegeben, um die Daten der User zu laden
    $all_users_view = new All_Users_View($all_users);

    $all_users_view->show_as_grid();
    echo "</div>";
  } else
    echo "<br><br><h3>Zugriff nicht erlaubt</h3>";
}

?>