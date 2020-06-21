<?php 
// Устанавливаем соединение с базой
class DB 
{
    public $id;
    public $login_of_session;
    public $login_of_base;
    public $pass_of_session;
    public $pass_of_base;
    public $user_array;


    public $user_id;
    public function __construct() {
            
		$db = mysql_connect ('localhost', 'root', '');
		mysql_select_db('base', $db);
                mysql_query("SET NAMES utf8");
                
                
		

		
	//Проверяем пароль, если не верен перенаправляем на страницу регистрации	
	}
	public function user(){
            $this->login_of_session = $_SESSION['login'];
            $this->pass_of_session = $_SESSION['pass'];
            if(!isset($this->login_of_session)  or !isset($this->pass_of_session)){
                //header('Location:aut.php?sov101=yes');
                header('Refresh: 0; url=aut.php' );
                exit();
            }
            $this->user_id = $_SESSION['id'];
            $rows = mysql_query("SELECT * FROM `manager` WHERE `login` = '$this->login_of_session'");
            $manager = mysql_fetch_array($rows);
            $this->id = $manager['id'];
            $this -> login_of_base = $manager['login'];
            $this -> pass_of_base = $manager['pass'];
            $this -> name_manager = $manager['name'];
            if($this->pass_of_session != $this->pass_of_base){
                header('Location:aut.php?sov101=yes');
               
                exit();
            }
            
            
        }
        public function getNameMen(){
           $name = mysql_query("SELECT `id`, `name` FROM `manager`");
           $user_array = [];
           
            while($nameman = mysql_fetch_array($name)) :
               $user_array[$nameman['id']] = $nameman['name'];
               
                
                
            endwhile;
            $this->user_array = $user_array;
            
           
           
            
        }

                // Обрабатіваем запросі к базе
		public function query ($sql, $class = 'stdClass'){
		$resurs = mysql_query($sql);
		if (false === $resurs){
			return false;
		}
		$ret = [];
		while ($row = mysql_fetch_object($resurs, $class) ) {
			$ret[] = $row;
		}
		return $ret;
	}	
	
	public function query_insert ($sql){
          
		$result = mysql_query($sql);
             
                return $result;
		
		
		
	}	
	
        public function query_col_rows ($sql){
          
		$result = mysql_query($sql);
             $row_cnt = mysql_num_rows($result);
             
                return $row_cnt;
		
		
		
	}
        
        
        
        public function query_fetch_array ($sql){
          $result = mysql_query($sql);  
          $array = mysql_fetch_array($result) ;
          return $array;
            
            
        }
        
} 



