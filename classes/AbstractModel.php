<?php


class AbstractModel {
    
    
     public static function getAll($sort='ORDER BY `id`'){
		
	       $db = new DB;
               $db ->user();
               $db ->user_id;
               
                
		return $db->query("SELECT * FROM `pokupatel` WHERE `status`='1' AND `manager`='$db->user_id' $sort","Buers");
			
	}
   
    
}
