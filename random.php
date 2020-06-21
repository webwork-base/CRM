<?php


$ar = [];
$i=0;
while ($i < 100000){

$dig =  mt_rand(1111111111111,9999999999999);

if(strlen($dig) < 9 || $dig < 0){
  $i= $i;  
}
else {
$ar[$dig] = $dig;
$i++;
}
}

echo count($ar);
foreach($ar as $result):
 echo"<br/>" ;
echo $result;
    
    
    
endforeach; 