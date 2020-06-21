<?php require "include/connect.php"; ?>
<!DOCTYPE html>
<html>




<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>БАЗА покупателей</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">

<script type="text/javascript" src="js/jquery-1.11.3.js"></script>

 <!-- стили демо страницы -->
	<link rel="stylesheet" href="css/demo-page.css" rel="stylesheet">
	<!-- стили модального окна -->
	<link rel="stylesheet" href="css/style-modal.css" rel="stylesheet">
<style>














</style>

</head>

<?php
//подключение к базе



echo "
<body bgcolor=\"".$myrow_2[body_color]." \">

<div class=\"container\" align=\"center\" style=\"background-color: ".$myrow_2[color_cont]."\">
<div class=\"alicia\"><img src=\"img/logo.png\" width=\"250\" height=\"50\" >

</div>";


?>

 <div class ="logcont">
 
 <form action="login.php" method="POST">
 <div class = "logintxt"><b>введите логин</b></div>
 <input type="text" name="login" size="40" >
 <div class = "passtxt"><b>введите пароль</b></div>
 <input type="password" name="pass" size="40" >
 <input type = "submit" class = "butlog">
 </form>
 
 
 
 <a class ="reg" href= "users/reg.php">регистрация</a>
 </div>
</div>
















       
     
       
       
      
  
      






















</div>

</body>

</html>
