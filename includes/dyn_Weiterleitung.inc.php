<?PHP
function weiterleiten($mypage){ //als Parameter wird die spezifische Seite mit gesendet

$host  = $_SERVER['HTTP_HOST']; //Host z.B. localhost
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); //Unterordner z.B: /linda/php
header("Location: http://$host$uri/$mypage"); 
}

function linkTo($mypage){
$host  = $_SERVER['HTTP_HOST']; //Host z.B. localhost
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); //Unterordner z.B: /linda/php
echo "http://$host$uri/$mypage"; 
}
?>