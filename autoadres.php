<?php
//подключение к базе
require "include/connect.php";


$autoadres = $_GET[autoadr];

$autoadr = mysql_query("UPDATE `manager` SET `autoadres` = '$autoadres' WHERE `id` = '$men_id' ",$db);
if ($autoadr == true &&  $autoadres == "no" ){
	
	
	
	
	
	echo "<script language = 'javascript'>
  var delay = 5;
  setTimeout(\"document.location.href='setting.php?sov12=yes'\", delay);
</script> 
";
 
}

elseif ($autoadr == true &&  $autoadres == "yes" ){
echo "<script language = 'javascript'>
  var delay = 5;
  setTimeout(\"document.location.href='setting.php?sov13=yes'\", delay);
</script> 
";	
}


else { echo "Ошибка в записи значения статуса автозаполнения адреса";}


?>