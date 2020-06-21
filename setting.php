
<!DOCTYPE html>
<html>




<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Настройки</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/modal-win.css">
<script type="text/javascript" src="js/jquery-1.11.3.js"></script>

 <!-- стили демо страницы -->
	<link rel="stylesheet" href="css/demo-page.css" rel="stylesheet">
	<!-- стили модального окна -->
	<link rel="stylesheet" href="css/style-modal.css" rel="stylesheet">
	
	
</head>

<?php 
//подключение
require "include/connect.php";


echo "
<body bgcolor=\"".$myrow_2[body_color]." \">





 

<div class=\"container\" align=\"center\" style=\"background-color: ".$myrow_2[color_cont]."\">
<div align=\"center\">

<div class=\"alicia\"><img src=\"img/logo.png\" width=\"250\" height=\"50\" ><div class=\"setting\"><a href=\"index.php\"><img src=\"img/back.png\" width=\"50\" height=\"50\" ></a></div></div>
<div class=\"manager_name_setting\">изменение имени менеджера, текущее имя <b>".$myrow_2['name']."</b></div>
<div class=\"manager_name_setting\">";


echo
"<form action=\"setting.php\" method=\"POST\" name=\"manager_form\">
<p> введите имя  
<input type=\"text\" name=\"login\"/> 

<input type=\"submit\" value=\"изменить\">
</p>
 


</form>
";

$login = $_POST['login'];


$result = mysql_query("SELECT * FROM `manager` WHERE `name` = '$login' ",$db);
$myrow = mysql_fetch_array($result);
if ($myrow['name'] == true){
	echo "<div class=\"manager_name_setting\" style =\" background-color: #CD5C5C\"  ><font color=\"white\">login занят</font></div>";
}
elseif ($myrow['name'] == false && iconv_strlen($login,'UTF-8') > 3 ){
	
	
$res = mysql_query("UPDATE `manager` SET `name` ='$login' WHERE `id` = '$men_id' ",$db);
	
	
	
	
	
	
	echo "<div class=\"manager_name_setting\" style =\" background-color: #00FF7F\" >login свободен</div>";
}
else { 
}


if ($res == true) {
	echo " <div class=\"manager_name_setting\" style =\" background-color: #00FF7F\" >Запись успешна, текущее имя изменено на <b>".$login."</b></div>";
}
else {}

echo "<br/><hr/><div class=\"chenge_color\">Можно изменить цвет отображения информации на свой вкус</div><div class=\"chenge_color\">
<form action=\"chenge_color.php\" >
<input type=\"color\" name=\"bgcolor\" value=\"#a5f3a9\" >
<input type=\"submit\" value=\"изменить фон\">
</form>
<div class=\"chenge_colorcon\">
<form action=\"chenge_colorcon.php\" >
<input type=\"color\" name=\"colorcon\" value=\"#f6f6f6\" >
<input type=\"submit\" value=\"изменить подложку\">
</form>
</div>
<div class=\"chenge_colorcon_2\"><form action=\"chenge_colorrow_2.php\" >
<input type=\"color\" name=\"colorrow_2\" value=\"#fefbf3\" >
<input type=\"submit\" value=\"цвет четной строки\">
</form></div>
<div class=\"chenge_colorcon_1\"><form action=\"chenge_colorrow_1.php\" >
<input type=\"color\" name=\"colorrow_1\" value=\"#ffffff\" >
<input type=\"submit\" value=\"цвет нечетной строки\">
</form></div>
<div class=\"chenge_color_text\"><form action=\"chenge_color_text.php\" >
<input type=\"color\" name=\"color_text\" value=\"#000000\" >
<input type=\"submit\" value=\"цвет текста\">
</form></div>
</div>
<hr/>
<div class=\"chenge_color\">Укажите какое количество записей должно отображаться на Вашей странице, а также порядок вывода, если необходимо выводить все записи, поставьте 0 </div>
<form action=\"col_rows.php\" >
<input type=\"text\" name=\"col_rows\" value=\"".$myrow_2[col_rows]."\" pattern=\"[0-9]{1,10}\" ><br/>
<input type=\"radio\" name =\"stroki\" value=\"posl\" checked=\"checked\">последние<br/>
<input type=\"radio\" name =\"stroki\" value=\"perv\">первые<br/>
<input type=\"submit\" value=\"количество строк\">
</form>
<hr/>
<div class=\"autoadres\">Автозаполнение адреса. Система сама заполнит поле адресс если данная организация уже была введена и к ней привязан адрес</div>
<form action=\"autoadres.php\" >

<input type=\"radio\" name =\"autoadr\" value=\"no\" checked=\"checked\">нет<br/>
<input type=\"radio\" name =\"autoadr\" value=\"yes\">да<br/>
<input type=\"submit\" value=\"применить\">
</form>
";



$sov6 = $_GET['sov6'];
$sov7 = $_GET['sov7'];
$sov8 = $_GET['sov8'];
$sov9 = $_GET['sov9'];
$sov10 = $_GET['sov10'];
$sov11 = $_GET['sov11'];
$sov12 = $_GET['sov12'];
$sov13 = $_GET['sov13'];

if (isset($sov6)) {
	echo "<script type =\"text/javascript\">
alert( \"УСПЕШНО.цвет фона изменен \" );
</script> ";
}
else {}

if (isset($sov7)) {
	echo "<script type =\"text/javascript\">
alert( \"УСПЕШНО.цвет подложки изменен \" );
</script> ";
}
else {}

if (isset($sov8)) {
	echo "<script type =\"text/javascript\">
alert( \"УСПЕШНО.цвет текста изменен \" );
</script> ";
}
else {}

if (isset($sov9)) {
	echo "<script type =\"text/javascript\">
alert( \"УСПЕШНО.цвет нечетной строки изменен \" );
</script> ";
}
else {}

if (isset($sov10)) {
	echo "<script type =\"text/javascript\">
alert( \"УСПЕШНО.цвет четной строки изменен \" );
</script> ";
}
else {}

if (isset($sov11)) {
	echo "<script type =\"text/javascript\">
alert( \"УСПЕШНО. Порядок отображения записей изменен \" );
</script> ";
}
else {}

if (isset($sov12)) {
	echo "<script type =\"text/javascript\">
alert( \"Автозаполнение адреса ОТКЛЮЧЕНО \" );
</script> ";
}
else {}
if (isset($sov13)) {
	echo "<script type =\"text/javascript\">
alert( \"Автозаполнение адреса ВКЛЮЧЕНО \" );
</script> ";
}
else {}
?>
</div>







<!-- <script>
//передача элементов по id "a" и "b"
window.onload = function()
{
a = document.getElementById("a");
b = document.getElementById("b");
} 

//показываем окно функции "showA"
function showA()
{
//Задаем прозрачность и блокируем дисплей
//элемента "b"
b.style.filter = "alpha(opacity=80)";
b.style.opacity = 0.8;
b.style.display = "block";
// Задаем блокироваку и отступ сверху в 200px
//элемента "a"
a.style.display = "block";
a.style.top = "200px";
}

//Вызываем функцию "hideA", которая будет скрывать окно
//для элементов "a" и "b"
function hideA()
{
b.style.display = "none";
a.style.display = "none";
}      
</script>






<a href="#" onclick="showA();" class="pages">Открыть</a> 

<div id="a"><div id="windows">
<!-- Ваш текст --> <!--
<a href="#" onclick="hideA();" class="pages" 
style="float: right;">Закрыть</a>
</div></div>
<div id="b"></div>
-->
</div>

</td>
</tr>
</table>
</div>



</div>


</div>

</body>

</html>
