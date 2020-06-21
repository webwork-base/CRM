<?php
session_start();
$db = mysql_connect('euromast.mysql.ukraine.com.ua','euromast_base','nn48x3k9');
mysql_select_db('euromast_base', $db);
mysql_query("SET NAMES utf8");


$men_id = $_SESSION['id'];

$result_2 = mysql_query("SELECT * FROM `manager` WHERE `id` = '$men_id' ",$db);
$myrow_2 = mysql_fetch_array($result_2);
$password = $myrow_2['pass'];
$login = $myrow_2['login'];
$name_manager = $myrow_2['name'];
$manager_table = "pokupatel";

$hostNAME = $_SERVER['SERVER_NAME'];

?>