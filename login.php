<?php
require "include/connect.php";
$login = $_POST['login'];
$password = $_POST['pass'];
//подключение к базе
 $password = md5($password);








$resuser = mysql_query("SELECT * FROM `manager` WHERE `login` = '$login'",$db);
$userm = mysql_fetch_array($resuser);
$pass = $userm['pass'];
$id = $userm['id'];
$name = $userm['name'];
$body = $userm['body_color'];
$cont = $userm['color_cont'];
$nchetnaya = $userm['color_row_1'];
$chetnaya = $userm['color_row_2'];
if ($password == $pass){
	
$_SESSION['pass'] = $password;
$_SESSION['id'] = $id;
$_SESSION['login']	= $login;
$_SESSION['name'] = $name;
$_SESSION['body'] = $body;
$_SESSION['cont'] = $cont;
$_SESSION['nchetnaya'] = $nchetnaya;
$_SESSION['chetnaya'] = $chetnaya;


$prava = mysql_query("SELECT * FROM `prava` WHERE `men_id`='$id'",$db);
$prava2 = mysql_fetch_array($prava);
$_SESSION['editeshopermain'] = $prava2['editeshopermain'];
$_SESSION['editeprice'] = $prava2['editeprice'];
$_SESSION['editemainsale'] = $prava2['editemainsale'];
$_SESSION['enterprih'] = $prava2['enterprih'];
$_SESSION['mainreports'] = $prava2['mainreports'];
$_SESSION['allreports'] = $prava2['allreports'];
$_SESSION['allusers'] = $prava2['allusers'];
$_SESSION['loockallshopers'] = $prava2['loockallshopers'];
$_SESSION['loockallsales'] = $prava2['loockallsales'];
$_SESSION['editeallsales'] = $prava2['editeallsales'];
$_SESSION['editekassanal'] = $prava2['editekassanal'];

 echo "<script language = 'javascript'>
  var delay = 5;
  setTimeout(\"document.location.href='index.php'\", delay);
</script>" ;
}

else {
	unset ($_SESSION['pass'], $_SESSION['id'], $_SESSION['login'], $_SESSION['editeshopermain'], $_SESSION['editeprice'], $_SESSION['editemainsale'],
 $_SESSION['enterprih'], $_SESSION['mainreports'], $_SESSION['allreports'], $_SESSION['allusers'], $_SESSION['loockallsales'], $_SESSION['editeallsales'],
 $_SESSION['editekassanal'], $_SESSION['name']	);
	echo "неправильный логин или пароль";
}





?>
