<?php

$db = mysql_connect('localhost','root','');
mysql_select_db('base', $db);
mysql_query("SET NAMES utf8");
$test = mysql_query("SELECT `id`, `name` FROM `manager`", $db);
$row = mysql_fetch_array($test);

$mass = [];
while ($row['id'] == true){
   
    
    $mass[$row['id']] = $row['name'];
    
    
    
     $row = mysql_fetch_array($test);
    
    
    
}
$_POST[id] = 15;
print_r($_POST);
