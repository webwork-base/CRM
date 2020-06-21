<?php
require_once ('classes/db.php');  


class buersController {
    public function actionBuers() {
        
       $count_per = 20; 
       $sort = $_POST['selvar'];
       $manager = $_SESSION['id'];
       $count = Buers::getCount_pokupatel($manager);
       function count_pages($count_per, $count){
           if($count_per > $count){
               return FALSE;
               
           }
          
        $num_pages = (int)($count / $count_per);
        if(($count % $count_per) != 0){
         $num_pages ++;   
        }
        return $num_pages;
       }
       if($_GET['page'] == TRUE){
            $pages = (int)$_GET['page'];
        }
        if($_GET['page'] != TRUE){
            $pages = 1;
            $_GET['page'] = 1;
        }
        
     //$pages = 4;
       $num_pages =  count_pages($count_per, $count);
       
       $start_rows = ($pages - 1) * $count_per;
       function getPages($sort, $count, $pages, $count_per, $start_rows){
          
         $buers = Buers::getAll($sort, $count_per, $start_rows, $manager);  
           
       return $buers;  
       }
       $buers = getPages($sort, $count, $pages, $count_per, $start_rows);
       

       
       
 include __DIR__. '/../views/view.php';
      $testadres = new Buers;

      
     
    }
    
    public function actionGet_search_result() {
        
        
       $like = trim($_POST['search_line']);
       
      
        $buers = Buers::get_search_result($like);
       
       $view = new View();
      $view ->assign('buers', $buers);
      $view ->display('view.php');
        
    }
    
    public function actionInsert_buers(){
                                    
       $name = trim($_POST['name']);
       $organization = trim($_POST['org']);
       $telephone = trim($_POST['tel']);
       $comment = trim($_POST['comm']);
       $email = trim($_POST['email']);
       $manager_id = trim($_POST['men']);
       $adress = trim($_POST['adress']);
       $list = trim($_POST['status']);
       $date =  date("Y-m-d");
       
     
       $num_pages = $_POST['page'];
        
       $test_tell = Buers::get_search_result_all_tell($telephone);
      if ($test_tell === 0){
       $buers = Buers::get_insert_result($name, $organization, $telephone, $comment, $email, $manager_id, $adress, $list, $date);
      }
      else {
          header('Location:index.php?sov=yes');
      
      }
       if($buers === true){
       
      header("Location:index.php?sov3=yes&page=".$num_pages."");
       }
                                   
       //include __DIR__. '/../views/view.php';
       
    }
    
    
    public function actionSearch_buers(){
        $number = trim($_POST['search_pokupatel']);
        $validation = "/[0-9]{4,10}/";
    if (preg_match($validation, $number) == TRUE){
        
    }
    else {
        $number = 'portret859584'; 
    }
       $buers = Buers::get_search_result_tell($number);
       $user = new DB;
       $user ->getNameMen();
       $manager = new DB;
     $manager ->user();
     
     
     
     //var_dump($test);
    
 


        
      include __DIR__. '/../views/search.php';
        
    }
    
    public function actionDelete_buers (){
        $id = $_POST['id_buers'];
      $delete = Buers::getDelete_buers($id);
      if ($delete === TRUE)
      {
          header('Location:index.php?sov125=yes'); 
          
      }
        
        
        
    }
   
    public function actionUpdate_buers(){
            $name = trim($_POST['name_edit']);
            $organization = trim($_POST['org_edit']);
            $adress = trim($_POST['adress_edit']);
            
            $telephone = trim($_POST['tel_edit']);
            $telephone4 = trim($_POST['tel_edit_4']);
            $telephone2 =  trim($_POST['tel_edit_2']);
            $telephone3 =  trim($_POST['tel_edit_3']);
            
            $email = trim($_POST['email_edit']);
            $type = trim($_POST['status']);
            
            $manager_id = trim($_POST['men_edit']);
            $buers_id = trim($_POST['edit_id']);
            
            
            $comment = trim($_POST['comm_edit']);
            $cenpol = trim($_POST['cenpol']);
            $tel = [];
            $tel[] = $telephone;
            $tel[] = $telephone2;
            $tel[] = $telephone3;
            $tel[] = $telephone4;
         $tell =   array_filter($tel);
            foreach($tell as $telephone_test):
               
            $test_tell = Buers::get_search_upd_all_tell($telephone_test);
            if ($test_tell > 0):
                 
            exit(header('Location:index.php?sov126=yes'));
            endif;
            endforeach;
            
            
            
            
            $update_buers = Buers::get_upd_result(
                    $name,
                    $organization,
                    $adress,
                    $telephone,
                    $telephone4,
                    $telephone2,
                    $telephone3,
                    $email,
                    $type,
                    $manager_id,
                    $buers_id,
                    $comment,
                    $cenpol);
            if ($update_buers === TRUE){
                
               $alert = Buers::$allert = 'yes';
               
               $count_per = 20; 
       $sort = $_POST['selvar'];
       $manager = $_SESSION['id'];
       $count = Buers::getCount_pokupatel($manager);
       function count_pages($count_per, $count){
           if($count_per > $count){
               return FALSE;
               
           }
           
           
        $num_pages = (int)($count / $count_per);
        if(($count % $count_per) != 0){
         $num_pages ++;   
        }
        return $num_pages;
       }
       if($_GET['page'] == TRUE){
            $pages = (int)$_GET['page'];
        }
        if($_GET['page'] != TRUE){
            $pages = 1;
            $_GET['page'] = 1;
        }
        
     //$pages = 4;
       $num_pages =  count_pages($count_per, $count);
       $start_rows = ($pages - 1) * $count_per;
               
               function getPages($sort, $count, $pages, $count_per, $start_rows){
          
         $buers = Buers::getAll($sort, $count_per, $start_rows, $manager);  
           
       return $buers;  
       }
       $buers = getPages($sort, $count, $pages, $count_per, $start_rows);
                
            }
            else {
              exit(header('Location:index.php?sov126=yes'));  
                
            }
            
            
      include __DIR__. '/../views/view.php';
     
        }
    
        
        
        
        
}
