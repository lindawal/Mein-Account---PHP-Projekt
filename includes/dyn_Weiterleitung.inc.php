<?PHP
function weiterleiten($mypage){ //als Parameter wird die spezifische Seite mit gesendet

$host  = $_SERVER['HTTP_HOST']; //Host z.B. localhost
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); //Unterordner z.B: /linda/php
header("Location: http://$host$uri/$mypage"); 
}

function get_filename($path){
  $file = basename($path);
  return $file;
}
function linkTo($myPage, $myParam){
$host  = $_SERVER['HTTP_HOST']; //Host z.B. localhost
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); //Unterordner z.B: /linda/php
echo "http://$host$uri/$myPage$myParam"; 
}

function safe_filter($uri)
{
  $safe_url = fopen("letzteURL.txt", "w");
  fwrite($safe_url, $uri);
  fclose($safe_url);
}

function get_last_url()
{
  $file = "letzteURL.txt";
  $get_url = fopen($file, "r");
  $url = fread($get_url, filesize($file));
  fclose($get_url);

  return $url;
}
?>