<?php

function __autoload($class){
   
 if (file_exists(__DIR__.'/controllers/'.$class.'.php')) {
     require __DIR__.'/controllers/'.$class.'.php'; 
 }  

  if(file_exists(__DIR__.'/model/'.$class.'.php')){
      require __DIR__.'/model/'.$class.'.php';
  }  
  if(file_exists(__DIR__.'/classes/'.$class.'.php')){
      require __DIR__.'/classes/'.$class.'.php';
  }  
}

