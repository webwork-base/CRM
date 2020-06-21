<?php
     
               
     $pokupatel = Buers::getAll_pokupatel();
     $contr = Sales::get_one_sales($number_n);
     $contragent_name = $contr[0]->contragent_name;
     $borg_viev = $contr[0] ->borg;
     $contr_id = $contr[0]->contragent_id;
     
     //извлекаем все значения товаров из накладной
     $products_n = Sales::get_Product_from_nakl($number_n);
     
    
     $sel_ar =[];
     $key = 0;
    // все ID товаров из накладной заливаем в отдельный массив $sel_ar
     foreach ($products_n as $product_n){
         $sel_ar[$product_n ->id_product] = $product_n ->id_product;
         $id=$product_n ->id_product;
         
         $key ++;
        
     }
     $select1 = Sales::view_otgruzka_from_sales($number_n);
    
     // объединяем все значения массива в одну переменную $sel_var
     $glue = ',';
     $sel_var=implode($glue,$sel_ar);
     // выводим все категории товаров
    $price = Price::get_all_cat();
   // извлекаем из базы товары только те что в накладной   
  $prod = Price::get_all_product_sale($sel_var);
  // извлекаем из базы все товары кроме тех что в накладной
  $prod2 = Price::get_all_product_sale_not($sel_var);
  // конец транзакции
  $stop = Sales::stop_transaction();
  if($oplata == 1){
         $checkbox_oplata = "checked";
         $style_opl = "background-color: #3cf20b;";
     }
  else {
         $style_opl = "background-color: #FFF00;";
     }
     if($provodka == 1){
         $checkbox_provodka = "checked";
         $style_prov = "background-color: #3cf20b;";
     }
     else {
         $style_prov = "background-color: #FFF00;";
     }
     if($otgruzka == 1){
         $checkbox_otgruzka = "checked";
         $style_otgruz = "background-color: #3cf20b;";
     }
     else {
         $style_otgruz = "background-color: #FFF00;";
     }
     ?>

