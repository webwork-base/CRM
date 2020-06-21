<?php



class View {

    protected $data = [];

    public function assign($name, $value){
        
       $this->data[$name] = $value; 
    }


    public function display($template) {
       
        
        
        foreach($this->data as $key => $buers){
            $$key = $buers;
        }
       include __DIR__. '/../views/'.$template;
       
       
   } 
    
    
    
}
