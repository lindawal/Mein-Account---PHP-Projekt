<!-- Header Template -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PHP">
  <title>PHP Test</title>
  <link href="./css/admin-style.css" rel="stylesheet">
</head>

<body>
  <div id="wrapper">

    <!--ANCHOR Navigationsleiste-->
    <nav>
      <object name="mars" data="images/mars.svg"></object>

      <!--Hamburger-Button-->
      <a href="javascript:void(0);" class="menubutton" onclick="MobileMenu()"><img alt="Hamburger" src="images/hamburger.svg"></a>


      <!--ANCHOR Hauptmenü-->
      <div id="navi-line">
        <ul>
          <li><a href="index.html">Start</a></li>
          <li><a href="index.html#jobs">Erfahrungen</a></li>
          <li><a href="index.html#ausbildung">Ausbildung</a></li>
          <li><a href="index.html#skills">Skills</a></li>
          <li class="drop"><a href="#">Portfolio</a><i class="arrow"></i> <!--href="#portfolio"-->
            <ul class="dropdown">
              <li><a href="portfolio.html#Studium">Studium</a></li>
              <li><a href="portfolio.html#Fotografie">Fotografie</a></li>
              <li><a href="portfolio.html#eisboerg">eisbörg</a></li>
              <li><a href="portfolio.html#webdesign">Webdesign</a></li>
            </ul>
          </li>
          <li><a href="index.html#kontakt">Kontakt</a></li>
          <li><a href="login_area.php" id="now">Zertifikate</a></li>
        </ul>
      </div>
    </nav>
    <main>