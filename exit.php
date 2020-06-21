<?php 
session_start();
unset ($_SESSION['pass'], $_SESSION['id'], $_SESSION['login'] );

	echo "<script language = 'javascript'>
  var delay = 5;
  setTimeout(\"document.location.href='aut.php'\", delay);
</script>" ;
	
print_r ($_SESSION);


?>