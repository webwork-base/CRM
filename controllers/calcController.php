<?php
require_once ('classes/db.php');  

class calcController {
    
    
   public function actionCalc(){
       var_dump($_POST);
       
     $koroed20a = $_POST['s'] / 9.6; 
     $koroed25a = $_POST['s'] / 8.06; 
     $kam15a = $_POST['s'] / 10;
     $kam20a = $_POST['s'] / 8.33;
       
     $koroed20m = $_POST['s'] / 9.61; 
     $koroed25m = $_POST['s'] / 8.06;
     $koroed25m = $_POST['s'] / 6.25;  
       
     $kam15m = $_POST['s'] / 10.87;
     $kam20m = $_POST['s'] / 8.33; 
     
     $setka = $_POST['s'] / 50; 
     
       
       
       
       
       include __DIR__. '/../views/uf_ent.php';
       
       
       
       
       
       
   } 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
