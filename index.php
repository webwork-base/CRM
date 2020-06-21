<?php session_start();

            

 require_once __DIR__.'/autoload.php';
 
 
$ctr = isset($_POST['ctr']) ? $_POST['ctr'] : 'buers';
$act = isset($_POST['act']) ? $_POST['act'] : 'Buers';


//$ctr = isset($_GET['ctr']) ? $_GET['ctr']: 'sales';
//$act = isset($_GET['act']) ? $_GET['act']: 'sale';
if($_GET['ctr'] == 'sales' and $_GET['act'] == 'view'){
   $ctr =  'sales';
   $act =  'view';
}
if($_GET['ctr'] == 'sales' and $_GET['act'] == 'search_contragent'){
   $ctr =  'sales';
   $act =  'search_contragent';
}
if($_GET['ctr'] == 'sales' and $_GET['act'] == 'search_contragent'){
   $ctr =  'sales';
   $act =  'search_contragent';
}

$controllername = $ctr.'Controller';
//require __DIR__.'/controllers/'.$controllername.'.php';
$method = 'action'.$act;

$controller = new $controllername;
$controller -> $method();


//var_dump($method);
//var_dump($controller);
//$test = new DB;
//$test ->user();
//
//echo $test->login_of_base;
//
?>
        
