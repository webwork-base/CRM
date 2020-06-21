<?php
require_once ('classes/db.php');  

class salesController {
     
    public function actionSale() {
        
        
        
        
      // Убираем все пустые значения и ненужные значение  
     $notnull = array_diff($_POST, array('', NULL, false, 'накладная', 'sale', 'sales')); 
     
  
     // Проверяем сколько товаров было затронуто в отправке
     //////////////////////////////////////////////////////////////////////ПРОВЕРКА ВВЕДЕННЫХ ДАННЫХ И ИХ ИСПРАВЛЕНИЕ + ОТОБРАЖЕНИЕ ОШИБОК ////////////////////////////////////////////////////////////////////////
$data_kol = 0;
$pattern = "/^actioncheck\d+$/";
foreach ($notnull as $key => $value) { 
    $result = preg_match($pattern, $key);
    if($result)
    {
     $data_kol =  $data_kol + 1;
    }
}

// Присваиваем всем значениям массива цифровые ключи
     $numeric = array_values($notnull);
           
      
 // Подсчитывем количество переданных значений  
      $count = count($numeric); 
      $test_input = $count / $data_kol;
      
      // Проверяем у всех ли затронутых продуктов заполнены все поля
      if($test_input != 3){
      $price = Price::get_all_cat();
      $prod = Price::get_all_product();
      $nekratno = 1;
      include __DIR__. '/../views/price.php';
        exit();
    }

    

      
      // Перебираем все введенные значения в цикле
    
       while ($count >= 3):
        $i1 = array_shift($numeric); // переносим первое значение из массива в переменную и удаляем в массиве
        $i2 = array_shift($numeric); // переносим второе значение из массива в переменную и удаляем в массиве
        $i3 = array_shift($numeric); // переносим третье значение из массива в переменную и удаляем в массиве
        

    
    $id_product = str_replace(' ', '',trim (str_replace (',', '.', trim($i1)), '.')); // удаляем в значениях лишние пробелы, точки, и заменяем запятые на точки ИД
    $quantity = str_replace(' ', '',trim (str_replace (',', '.', trim($i2)), '.')); // удаляем в значениях лишние пробелы, точки, и заменяем запятые на точки КОЛИЧЕСТВО
    $price = str_replace(' ', '',trim (str_replace (',', '.', trim($i3)), '.')); // удаляем в значениях лишние пробелы, точки, и заменяем запятые на точки ЦЕНА
    
    // Проверяем являются ли полученные данные числом
    $test_1 = is_numeric($id_product);
    $test_2 = is_numeric($quantity);
    $test_3 = is_numeric($price);
    
    // Если введенные данные не число, переадрессовуем на страницу прайс, выводим ошибку и прекращаем дальнейшее исполнение
    if($test_1 != TRUE || $test_2 != TRUE || $test_3 != TRUE ){
      $price = Price::get_all_cat();
      $prod = Price::get_all_product();
      $test_numeric_sales = 1;
      include __DIR__. '/../views/price.php';
        exit();
    }    
    
    $start_transaction = Sales::start_transaction();
   
     //получаем текущий остаток товара из таблицы
    $balance = Sales::get_current_balance($id_product);
    if($balance != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-8');}
    
    foreach ($balance as $current_balance):
       
        

    // Проверяем не превышает ли введенное количество текущий остаток если да выводим ошибку и прекращаем дальнейшее исполнение
    if ($quantity > $current_balance ->col){
    
         $test_ballance = 1;
              $price = Price::get_all_cat();
              $prod = Price::get_all_product();
        include __DIR__. '/../views/price.php';
        exit();   
        
    }
    // проверяем не ниже ли введенная цена минимально допустимой если да выводим ошибку и прекращаем дальнейшее исполнение
    if ($price < $current_balance ->stop){
        
              $test_minprice = 1;
              $price = Price::get_all_cat();
              $prod = Price::get_all_product();
        include __DIR__. '/../views/price.php';
        exit();      
        
    }
 
    
    endforeach;
   
      $count = count($numeric);  
  
    endwhile; 
    
    // ХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХ
    // ХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХХ
    

    
    $numeric = array_values($notnull);
    
    
    
    $numeric_2 = array_values($notnull);
    $count_2 = count($numeric_2);
    $count_prod = $count_2;
    
    
    $nakladnaya = []; // массив для формирования накладной
      $sumall = []; // массив для общей суммы
      $kll = 0; // стартовый ключ для этого массива
      
      
      // Получаем из таблицы продаж последний номер продажи
    $last_numb = Sales::get_current_number_sale();
      if($last_numb != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-7');}
    foreach($last_numb as $lastnumb):
        $number_sale = $lastnumb ->number;
        $code_sale = $lastnumb ->code_nakl;
        
    endforeach;
    if ($code_sale == FALSE){
        $code_sale = 1;
       
       
      $code_sale = str_pad($code_sale, 9, "0", STR_PAD_LEFT);
    }
    else {
    $code_sale ++;
    $code_sale = str_pad($code_sale, 9, "0", STR_PAD_LEFT);
    }
    
    if ($number_sale == FALSE){
        $number_sale = 1;
    }
    else {
       $number_sale ++; 
    }
    
     while ($count_2 >= 3):
        $i1_1 = array_shift($numeric_2);
        $i2_1 = array_shift($numeric_2);
        $i3_1 = array_shift($numeric_2);

    $id_product1 = str_replace(' ', '',trim (str_replace (',', '.', trim($i1_1)), '.')); // удаляем в значениях лишние пробелы, точки, и заменяем запятые на точки ИД
    $quantity1 = str_replace(' ', '',trim (str_replace (',', '.', trim($i2_1)), '.')); // удаляем в значениях лишние пробелы, точки, и заменяем запятые на точки КОЛИЧЕСТВО
    $price1 = str_replace(' ', '',trim (str_replace (',', '.', trim($i3_1)), '.')); // удаляем в значениях лишние пробелы, точки, и заменяем запятые на точки ЦЕНА
         // получаем сумму за этот товар
        $sum1 = $price1 * $quantity1;
        
       
        // Получаем текущий остаток
    $balance = Sales::get_current_balance($id_product1);
    if($balance != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-6');}
    
   foreach ($balance as $current_balance):
      
       $current_balance ->name_tovar;
        // текущий остаток
    $current_balance ->col;
       
    endforeach;
   $col = $current_balance ->col - $quantity1;
   $name_product = $current_balance ->name_tovar;
   $ed_izm = $current_balance -> ed_izm;
      $count_2 = count($numeric_2);  
        $sumall[$kll] = $sum1;
        $kll ++;
        
      
        
  $nakladnaya[$id_product1] = array($id_product1,$name_product,$quantity1,$price1,$sum1,$ed_izm,$col);
    endwhile; 
    
    
  
    
      $totalsum = array_sum($sumall);
      $totalsum_viz =sprintf("%01.2f", $totalsum);
      
      
      $date = date('Ymd');
      $date_us = date('Y-m-d');
      //записівем данніе для накладной
      $insert_sale = Sales::get_insert_sale($date, $date_us, $number_sale, $code_sale, $totalsum); 
     if($insert_sale != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-5');}
     
     $manager = new DB;
     $manager ->getNameMen();
     $manager ->user_array;
     $pokupatel = Buers::getAll_pokupatel();
   $stop_transaction = Sales::stop_transaction();
   
   
   include __DIR__. '/../views/nakl.php';
   
    }
    
    
    
    
    
    public function actionView(){
     $sales = Sales::get_all_sales();   
        
        
        
        
        
    include __DIR__. '/../views/sales.php';    
        
    }
    
    public function actionNakladnayaWrite(){
         
        if ($_POST['oplata'] == TRUE){
            $oplata = 1;
        }
         if ($_POST['otgruzka'] == TRUE){
            $otgruzka = 1;
        }
         if ($_POST['provesti'] == TRUE){
            $provodka = 1;
        }
        if($_POST['id_manager'] == TRUE){
            
           $manager = explode ('||', $_POST['id_manager']);
          
           unset($_POST['id_manager']);
        }
        if($_POST['id_shoper'] == TRUE){
           $shoper = explode('||', $_POST['id_shoper']);
           unset($_POST['id_shoper']);
        }
        if($_POST['comment'] == TRUE){
            $comment = $_POST['comment'];
            unset($_POST['comment']);
        }
     
        echo"<br/>";
        $notnull = array_diff($_POST, array('', NULL, false, 'накладная', 'sale', 'provodka', 'oplata','otgruzka', 'sales', 'nakladnayaWrite', 'save', 'ctr', 'Сохранить')); 
        $numeric = array_values($notnull);
        $count_prod = count($numeric)/8;
        $totals = [];
        while ($numeric == TRUE){
            
       
        $edizm = array_shift($numeric); // переносим первое значение из массива в переменную и удаляем в массиве++
        $count = array_shift($numeric); // переносим первое значение из массива в переменную и удаляем в массиве
        $price = array_shift($numeric); // переносим второе значение из массива в переменную и удаляем в массиве
        $sum = array_shift($numeric); // переносим третье значение из массива в переменную и удаляем в массиве
        $id_prod = array_shift($numeric); // переносим тчетвертое значение из массива в переменную и удаляем в массиве
        $number = array_shift($numeric); // переносим пятое значение из массива в переменную и удаляем в массиве
        $name = array_shift($numeric); // переносим шестое значение из массива в переменную и удаляем в массиве
        $balance = array_shift($numeric); // переносим седьмое значение из массива в переменную и удаляем в массиве
       
        
        $totals[] = $sum;
 
        
        if ($oplata == TRUE || $otgruzka == TRUE){
            
           $provodka = 1; 
            
        }
        
        $start_transaction = Sales::start_transaction();
        $product_to_sale = Sales::get_insert_product_to_sale($id_prod, $name, $number, $price, $count, $sum, $balance, $edizm);
       if($product_to_sale != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-1');}
       if ($otgruzka == TRUE || $provodka == '1' || $oplata == '1' ){
        $product_upd_balance = Sales::get_update_balance_product($id_prod, $balance);
        if($product_upd_balance != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-2');}
       }
       
       
        }
        $total = array_sum($totals);
        $id_manager = $manager[0];
        $name_manager = $manager[1];
        if($id_manager != TRUE || $id_manager === NULL || $id_manager === 0 ){
            exit("НЕ УКАЗАНО ИМЯ МЕНЕДЖЕРА");
            
            
            
        }
        $id_shoper = $shoper[0];
        
        $name_shoper = $shoper[1];
      $sale_upd = Sales::get_Update_sale($id_manager, $name_manager, $name_shoper, $id_shoper, $oplata, $otgruzka, $provodka, $comment, $count_prod, $number, $total, $col_prod);
      if($sale_upd != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-3-1');}
      // РАБОТА С БОНУСАМИ
      function bonus($total, $id_shoper){
        $bonus_tek = $total / 100;  
        $bonus_select_obj = Buers::getOne_pokupatel($id_shoper);
        if($bonus_select_obj != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-3-2');}
        $bonus_select = $bonus_select_obj[0] ->bonus;
        $bonus = $bonus_tek + $bonus_select;
        $upd_bonus = Buers::get_upd_bonus_shoper($bonus, $id_shoper);
        return $upd_bonus;
      }
     $bonus =  bonus($total, $id_shoper);
     if($bonus != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-3-4');}
     
      
      
      //Получаем и обновляем количество накладніх для конкретного покупателя в таблице покупателя
      $true_id = $id_shoper;
      $get_count_sales_shoper = Buers::getSales_pokupatel($true_id);
      $count_sales_shoper = $get_count_sales_shoper[0] -> sales;
      
      
      $sales = (int)$count_sales_shoper + 1;
      
      $sale_shoper = Buers::get_upd_sales_shoper($id_shoper, $sales);
      
      
      
      if($sale_shoper != TRUE){ $otkat = Sales::otkat(); exit('ОШИБКА ТРАНЗАКЦИИ-3-3');}
        $stop_transaction = Sales::stop_transaction();
      
       include __DIR__. '/../views/mediator.php'; 
    }
    
    public function actionExpot_excel() {
      
        $export = Price::getExport_product();
      //var_dump($export);
      if(!$export){
		
		exit(mysql_error());
		
	}
	

//Подключение библиотеки
      
        require_once __DIR__.'../../classes/Classes/PHPExcel.php';  
     
    

$objPHPexcel = new PHPExcel();
//активируем активный лист
$objPHPexcel -> setActiveSheetIndex(0);
//$objPHPexcel -> createSheet();
// получаем доступ к активному листу
$active_sheet = $objPHPexcel -> getActiveSheet();
//Устанавливаем статичные настройки листа.
$active_sheet ->getPageSetUp()->setOrientation(PHPExcel_Worksheet_Pagesetup::ORIENTATION_PORTRAIT); // Ориентация листа
$active_sheet ->getPageSetUp()->setPaperSize(PHPExcel_Worksheet_Pagesetup::PAPERSIZE_A4);           // Формат листа
$active_sheet ->getPageMargins()->setTop(0.5);                                                      // Верхний отступ
$active_sheet ->getPageMargins()->setRight(0.2);                                                    // Правый отступ
$active_sheet ->getPageMargins()->setLeft(0.2);                                                     // Левый отступ
$active_sheet ->getPageMargins()->setBottom(0.2);                                                   // Нижний отступ
$active_sheet ->setTitle("Накладна");                                                                  // Название листа
$active_sheet ->getHeaderFooter()->setOddHeader("&CВидаткова накладна");                           // Заголовок верхний
$active_sheet ->getHeaderFooter()->setOddFooter('&L&B'.$active_sheet ->getTitle().'&RСторінка &P из &N'); // Заголовок нижний
$objPHPexcel->getDefaultStyle()->getFont()->setName('Arial');                                             // Шрифт
$objPHPexcel->getDefaultStyle()->getFont()->setSize(8);                                                    // Размер шрифта
//Настройки размеров ячеек
$active_sheet->getColumnDimension('A')->setWidth(5); // номер
$active_sheet->getColumnDimension('B')->setWidth(7); // артикул
$active_sheet->getColumnDimension('C')->setWidth(55); // название
$active_sheet->getColumnDimension('D')->setWidth(5); // ед.изм
$active_sheet->getColumnDimension('E')->setWidth(7); // розница
$active_sheet->getColumnDimension('F')->setWidth(7); // м.опт
$active_sheet->getColumnDimension('G')->setWidth(7); // с.опт
$active_sheet->getColumnDimension('H')->setWidth(7); // к.опт
$active_sheet->getColumnDimension('I')->setWidth(7); // стоп 
$active_sheet->getColumnDimension('J')->setWidth(17); // остаток
//Шапка
$active_sheet->mergeCells('D1:J1'); // объединение
$active_sheet->getRowDimension(1)->setRowHeight(15);// высота 
$active_sheet->setCellValue('C1', 'Постачальник:'); // значение

$active_sheet->getRowDimension(1)->setRowHeight(15);// высота 
$active_sheet->setCellValue('D1', 'СПД Драч О.В'); // значение

$active_sheet->mergeCells('D2:J2'); // объединение
$active_sheet->getRowDimension(2)->setRowHeight(15);// высота 
$active_sheet->setCellValue('D2', 'Є платником податку на Ⅲ групі '); // значение


$active_sheet->mergeCells('D3:J3'); // объединение
$active_sheet->getRowDimension(2)->setRowHeight(20);// высота 

$active_sheet->setCellValue('D3', 'Адреса: м.Бровари вул.Олега Онікієнка 133'); // значение

$active_sheet->mergeCells('D4:J4'); // объединение
$active_sheet->getRowDimension(1)->setRowHeight(15);// высота 
$active_sheet->setCellValue('C4', 'Одержувач:'); // значение
$active_sheet->setCellValue('D4', 'Кінцевий споживач'); // значение
$date = date('d-m-Y');

$active_sheet->mergeCells('D2:G2'); // объединение
$active_sheet->mergeCells('A6:J6'); // объединение
//$active_sheet->mergeCells('A11:J11'); // объединение
//$active_sheet->setCellValue('A11', 'Видаткова накладна №.'.str_pad($_POST['number'], 7, "0", STR_PAD_LEFT)); // значение
$active_sheet->setCellValue('A6', 'Видаткова накладна №'.str_pad($_POST['number'], 7, "0", STR_PAD_LEFT)); // значение
$active_sheet->mergeCells('A6:J6'); // объединение
$active_sheet->mergeCells('A7:J7'); // объединение
$active_sheet->setCellValue('A7', 'Від:'.date('d-m-y')); // значение
$active_sheet->setCellValue('A8', '№'); // значение
$active_sheet->setCellValue('B8', 'Товар'); // значение
$active_sheet->mergeCells('B8:C8'); // объединение
$active_sheet->setCellValue('D8', 'Од'); // значение
$active_sheet->mergeCells('E8:G8'); // объединение
$active_sheet->setCellValue('E8', 'Кількість'); // значение
$active_sheet->mergeCells('H8:I8'); // объединение
$active_sheet->setCellValue('H8', 'Ціна'); // значение
$active_sheet->setCellValue('J8', 'Сума'); // значение


$style_body = array(
                //шрифт
 'font'=>array(
    'bold'=>true,
	'name'=>'Verdana',
	'size'=>8
	),
	//-------------------------------------------------------
	              // Выравнивание
  'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
	   'vertical'=>PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
  ),
  //----------------------------------------------------------------
                // Заливка
  'fill'=>array(
    'type'=>PHPExcel_STYLE_FILL::FILL_NONE,
	'color'=>array(
	   'rgb'=>'FFFFFF')
  )
  //-------------------------------------------------------------
);
$style_total = array(
    'font'=>array(
    'bold'=>true,
	'name'=>'Verdana',
	'size'=>8),
    'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
	   'vertical'=>PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
  ),
 'borders'=>array(
  'outline' => array(
   'style'=>PHPExcel_Style_Border::BORDER_THICK     ),
     
   //----------------------------------------------------------------------
                 // Внутренние границы -------------------------------------
 'allborders'=>array(
   'style'=>PHPExcel_Style_Border::BORDER_THICK, 'color' =>array(
     'rgb'=>'696969')    )
   )            );

//Запись данных в цикле**************************************************
//Запись данных в цикле*************************************************************************************************************************
$number = $_POST['number'];
$totalsum = $_POST['totalsum'];
unset($_POST['ctr'],$_POST['act'],$_POST['number'],$_POST['totalsum'] );
$numeric = array_values($_POST);

        //var_dump($numeric);
        //exit();

$start=9;
$i=0;
$number_prod = 1;
while($numeric == TRUE){
	$next_val = $start + $i;
	
      $active_sheet->getStyle('A'.$next_val, $number_prod)->applyFromArray($style_body);	
      $active_sheet->setCellValue('A'.$next_val, $number_prod); // значение
      $active_sheet->getStyle('C'.$next_val, $number_prod)->applyFromArray($style_body);
      $active_sheet->setCellValue('C'.$next_val, $numeric[0]); // значение
      $active_sheet->getStyle('D'.$next_val, $number_prod)->applyFromArray($style_body);
      $active_sheet->setCellValue('D'.$next_val, $numeric[1]); // значение
      $active_sheet->getStyle('E'.$next_val, $number_prod)->applyFromArray($style_body);
      $active_sheet->mergeCells('E'.$next_val.':G'.$next_val.''); // объединение
      $active_sheet->setCellValue('E'.$next_val, $numeric[2]); // значение	
      //$active_sheet->setCellValue('F'.$next_val, $val -> m_opt); // значение	
      //$active_sheet->setCellValue('G'.$next_val, $val ->s_opt); // значение
      $active_sheet->getStyle('H'.$next_val, $number_prod)->applyFromArray($style_body);
      $active_sheet->mergeCells('H'.$next_val.':I'.$next_val.''); // объединение
      $active_sheet->setCellValue('H'.$next_val, $numeric[3]); // значение	
	  //$active_sheet->setCellValue('I'.$next_val, $val -> stop); // значение
      $active_sheet->getStyle('J'.$next_val, $number_prod)->applyFromArray($style_body);
	  $active_sheet->setCellValue('J'.$next_val, $numeric[4]); // значение	
	unset($numeric[0],$numeric[1],$numeric[2],$numeric[3],$numeric[4]);
	$numeric = array_values($numeric);
$i++;	
$number_prod ++;
}
$next_val= $next_val+1;
$active_sheet->getRowDimension($next_val)->setRowHeight(25);// высота
$active_sheet->mergeCells('H'.$next_val.':I'.$next_val.''); // объединение
$active_sheet->getStyle('H'.$next_val)->applyFromArray($style_total);
$active_sheet->setCellValue('H'.$next_val, 'Всього:'); // значение
$active_sheet->getStyle('I'.$next_val)->applyFromArray($style_total);
$active_sheet->getStyle('J'.$next_val)->applyFromArray($style_total);
$active_sheet->setCellValue('J'.$next_val, $totalsum); // значение
// Конец цикла записи данных*

//установка обводок

                 //внешняя граница ---------------------
$style_wrap = array(
 'borders'=>array(
  'outline' => array(
   'style'=>PHPExcel_Style_Border::BORDER_THICK     ),
   //----------------------------------------------------------------------
                 // Внутренние границы -------------------------------------
 'allborders'=>array(
   'style'=>PHPExcel_Style_Border::BORDER_NONE, 'color' =>array(
     'rgb'=>'696969')    )
   )            );
//--------------------------------------------------------------------------------

$active_sheet->getStyle('A1:J'.($i+8))->applyFromArray($style_wrap);
//конец установки  обводок ********************************************************

//Установка стиля поля поставщика

$style_header = array(
                //шрифт
 'font'=>array(
    'bold'=>true,
	'name'=>'Verdana',
	'size'=>10
	),
	//-------------------------------------------------------
	              // Выравнивание
  'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
	   'vertical'=>PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
  ),
  //----------------------------------------------------------------
                // Заливка
  'fill'=>array(
    'type'=>PHPExcel_STYLE_FILL::FILL_SOLID,
	'color'=>array(
	   'rgb'=>'FFFFFF')
  )
  //-------------------------------------------------------------
);

//Установка стиля поля поставщика

$style_header2 = array(
                //шрифт
 'font'=>array(
    'bold'=>false,
	'name'=>'Verdana',
	'size'=>10
	),
	//-------------------------------------------------------
	              // Выравнивание
  'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
	   'vertical'=>PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
  ),
  //----------------------------------------------------------------
                // Заливка
  'fill'=>array(
    'type'=>PHPExcel_STYLE_FILL::FILL_SOLID,
	'color'=>array(
	   'rgb'=>'FFFFFF')
  )
  //-------------------------------------------------------------
);


$style_number = array(
                //шрифт
 'font'=>array(
    'bold'=>true,
	'name'=>'Verdana',
	'size'=>10
	),
	//-------------------------------------------------------
	              // Выравнивание
  'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
	   'vertical'=>PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
  ),
  //----------------------------------------------------------------
                // Заливка
  'fill'=>array(
    'type'=>PHPExcel_STYLE_FILL::FILL_SOLID,
	'color'=>array(
	   'rgb'=>'FFFFFF')
  )
  //-------------------------------------------------------------
);

//Установка стиля стартовой строки
$style_startrow = array(
                //шрифт
 'font'=>array(
    'bold'=>true,
	
	'name'=>'Verdana',
	'size'=>9,
	'color'=>array(
	  'rgb'=>'FFFFFF'
	  )
	),
	//-------------------------------------------------------
	              // Выравнивание
  'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
	
  ),
  //----------------------------------------------------------------
                // Заливка
  'fill'=>array(
    'type'=>PHPExcel_STYLE_FILL::FILL_SOLID,
	'color'=>array(
	   'rgb'=>'000000'
  )
  )
  //-------------------------------------------------------------
);




$active_sheet->getStyle('A1:C1')->applyFromArray($style_header);
//Конец установки стилей поставщика
$active_sheet->getStyle('D1:J1')->applyFromArray($style_header2);
$active_sheet->getStyle('D3:J3')->applyFromArray($style_header2);
$active_sheet->getStyle('D4:J4')->applyFromArray($style_header2);
$active_sheet->getStyle('A4:C4')->applyFromArray($style_header);
$active_sheet->getStyle('A3:C3')->applyFromArray($style_header);
$active_sheet->getStyle('A5:J5')->applyFromArray($style_number);
$active_sheet->getStyle('A6:J6')->applyFromArray($style_number);
$active_sheet->getStyle('A7:J7')->applyFromArray($style_number);
$active_sheet->getStyle('A8:J8')->applyFromArray($style_startrow);
//Конец установки стилей имени поставщика

//Установка стиля слогана
$style_slogan = array(
                //шрифт
 'font'=>array(
    'bold'=>false,
	'italic'=>false,
	'name'=>'Verdana',
	'size'=>10,
	'color'=>array(
	  'rgb'=>'FFFFFF'
	  )
	),
	//-------------------------------------------------------
	              // Выравнивание
  'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
	   'vertical'=>PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
  ),
  //----------------------------------------------------------------
                // Заливка
  'fill'=>array(
    'type'=>PHPExcel_STYLE_FILL::FILL_SOLID,
	'color'=>array(
	   'rgb'=>'FFFFFF')
  ),
  'borders'=>array(
    'bottom'=>array(
	  'style'=>PHPExcel_Style_Border::BORDER_NONE 
	)
  )
  //-------------------------------------------------------------
);

$active_sheet->getStyle('A2:C2')->applyFromArray($style_slogan);
//Конец установки стилей слогана







//Установка стиля даты
$style_date = array(
                //шрифт
 'font'=>array(
    'bold'=>false,
	'italic'=>true,
	'name'=>'Verdana',
	'size'=>10,
	'color'=>array(
	
	  )
	),
	//-------------------------------------------------------
	              // Выравнивание
  'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
	   'vertical'=>PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
  ),
  //----------------------------------------------------------------
                // Заливка
  'fill'=>array(
    'type'=>PHPExcel_STYLE_FILL::FILL_SOLID,
	'color'=>array(
	   'rgb'=>'FFFFFF')
  ),
  'borders'=>array(
    'bottom'=>array(
	  'style'=>PHPExcel_Style_Border::BORDER_NONE  
	)
  )
  //-------------------------------------------------------------
);


//$style_rows = array(
               
	//-------------------------------------------------------
	              // Выравнивание
  //'alignment'=> array(
       //'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT
	
 // )
  //----------------------------------------------------------------
                // Заливка
  
//);















// отдаем необходимые заголовки для браузера
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=nakladn-№".$number."||".date('d-m-y').".xls");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');

$objWriter ->save('php://output');

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------







exit();


    }
    
   
    
    
    public function actionEditenakl(){
      $manager_name = $_POST['manager_name'];
      $manager_id = $_POST['men_id'];
     // извлекаем номер накладной
     $number_n = $_POST['number'];
     // извлекаем общую сумму
     $total_sum=$_POST['total'];
     // извлекаем дату
     $date=$_POST['date_user'];
     // извлекаем имя автора
     $author=$_POST['author'];
     $author_id=$_POST['author_id'];
     $oplata = $_POST['status_opl'];
     $provodka = $_POST['status_reg'];
     $otgruzka = $_POST['status_otgr'];
     $comment = $_POST['comment'];
     $contr = Sales::get_one_sales($number_n);
     $oplacheno = $contr[0]->opl_sum;
     $borg_viev = $contr[0]->borg;
     $contr_id = $contr[0]->contragent_id;
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
     
     $start = Sales::start_transaction();
     $pokupatel = Buers::getAll_pokupatel();
     if ($pokupatel != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА - 7"); }
     //извлекаем все значения товаров из накладной
     $products_n = Sales::get_Product_from_nakl($number_n);
     if ($products_n != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА - 8"); }
     $contr = Sales::get_one_sales($number_n);
     if ($contr != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА - 9"); }
     $contragent_name = $contr[0]->contragent_name;
     
    
     
     $sel_ar =[];
     $key = 0;
    // все ID товаров из накладной заливаем в отдельный массив $sel_ar
     foreach ($products_n as $product_n){
         $sel_ar[$product_n ->id_product] = $product_n ->id_product;
         $key ++;
         
     }
     
     // объединяем все значения массива в одну переменную $sel_var
     $glue = ',';
     $sel_var=implode($glue,$sel_ar);
     // выводим все категории товаров
    $price = Price::get_all_cat();
    if ($price != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА - 10"); }
   // извлекаем из базы товары только те что в накладной   
  $prod = Price::get_all_product_sale($sel_var);
  if ($prod != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА - 11"); }
  // извлекаем из базы все товары кроме тех что в накладной
  $prod2 = Price::get_all_product_sale_not($sel_var);
  if ($prod2 != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА - 12"); }
  
  $select1 = Sales::view_otgruzka_from_sales($number_n);
  // конец транзакции
  $stop = Sales::stop_transaction();
  
      include __DIR__. '/../views/edite_n.php';  
        
    }
    
    
    public function actionSearch_contragent(){
        
        
        
        if(!empty($_POST["referal"])){ //Принимаем данные
            
    $like = trim(strip_tags(stripcslashes(htmlspecialchars($_POST["referal"]))));
    
    $db_referal = Buers::get_search_result($like)
    or die('Ошибка №'.__LINE__.'<br>Нет совпадений.');

    foreach ($db_referal as $row) {
       
        echo "\n<li>".$row->name."  ||".$row->organization."||  тел.".$row->telephone." ,".$row->telephone2." ,".$row->telephone3." ,".$row->telephone4."id".$row->id."</li>";
         
    }
   
}
    
    
}


 public function actionNakladnaya_rewrite (){
      
     
     $start = Sales::start_transaction();
    
     //выделяем из строки ID контрагента, которій біл выбран в поиске
     // на странице редактирования накладной
     $id_contragent_sel = explode('id', $_POST['referal']);
    
     //удаляем ненужные значения
     
     $oplacheno = round(filter_input(INPUT_POST, 'oplacheno'),2); // Частичная оплата
     $number_n = filter_input(INPUT_POST, 'number_n'); // номер накладной
     $date = filter_input(INPUT_POST, 'date'); // Дата создания накладной
     $author = filter_input(INPUT_POST, 'author'); //Автор накладной
     $provodka = filter_input(INPUT_POST, 'provesti');// Чекбокс проводки
     $otgruzka = filter_input(INPUT_POST, 'otgruzka'); //Чекбокс отгрузки
     $oplata = filter_input(INPUT_POST, 'oplata'); // Чекбокс оплаты
     $comment = filter_input(INPUT_POST, 'comment'); // Комментарий
     $total_sum = filter_input(INPUT_POST, 'total_sum'); // Текущая общая сумма
     $manager_name = filter_input(INPUT_POST, 'manager_name'); //Имя менеджера
     $manager_id = filter_input(INPUT_POST, 'manager_id');//ID менеджера
     //$otgruzka_ch = filter_input(INPUT_POST, 'otgruzka_ch');//Частичная отгрузка
     $contragent_name = filter_input(INPUT_POST, 'contragent_name'); // Имя покупателя
     $id_manager = $_SESSION['id'];
     
     $contr = Sales::get_one_sales($number_n);
     if ($contr != TRUE){$otkat=Sales::otkat(); exit(); }
    // $contragent_name = $contr[0]->contragent_name;
     //$otgruzka_ch = $_POST['otgruzka_ch'];
     
     
     //ОПЛАЧЕНАЯ СУММА ИЗ БАЗЫ
     $oplacheno0_1 = $contr[0]->opl_sum;
     // получение текущего баланса
      function curent_balance($delete_isset){
         $id_product = $delete_isset;
         $bal= Sales::get_current_balance($id_product);
         if ($bal != TRUE){$otkat=Sales::otkat(); exit(); }
         foreach($bal as $balanc):
           $balance_tek =  $balanc -> col;
        
         endforeach;
         return $balance_tek;
         
        //Очищаем POST от ненужных данных--------------------------------------- --------------------------------- //
         }                                                                                                         //
      function cleaning_array(){                                                                                   //
         unset ($_POST['author'],                                                                                  //
                $_POST['number_n'],                                                                                //
                $_POST['date'],                                                                                    //
                $_POST[`referal`],                                                                                 //
                $_POST['otgruzka'],                                                                                //
                $_POST['oplata'],                                                                                  //
                $_POST['comment'],                                                                                 //
                $_POST['manager_name']);                                                                           //
                                                                                                                   //
                $cleen_array = array_diff($_POST, array('', false,'Nakladnaya_rewrite','sales','редактировать'));  //
                return $cleen_array;                                                                               //
      }                                                                                                            //
    $cleen_array = cleaning_array();                                                                               //
                                                                                                           //
     //--------------------------------------------------------------------------------------------------------------
    //**************УБИРАЕМ ЛИШНИЕ ПРОБЕЛЫ И МЕНЯЕМ ЗАПЯТЫЕ НА ТОЧКИ ******************************* 
     function trim_all ($trim){                                                                   //
                                                                                                  //
        $trim = str_replace(' ', '',trim (str_replace (',', '.', trim($trim)), '.'));             //
                                                                                                  //
                                                                                                  //
                                                                                                  //
        return $trim;                                                                             //
                                                                                                  //
     } 
   
    //----------------------------------------------------------------------------------------------
    
    function chast_otgruzka ($isset_product,$number_n,$otgruzka){
     $chast = [];
     $all = [];
     $last_number = Sales::get_current_number_otgr($number_n);
     $curent_number = $last_number[0]->otgr_number;
     if ($curent_number == NULL){
         $curent_number = 1;
     }
     else{
        $curent_number++; 
     }
     
     
     
     
     $otgruzka_array = [];
     $all_otgr = [];
     
     $n = 0;
     if($otgruzka == 0):
   foreach ($isset_product as $i => $chastichnaya_otgr):
      
       
       
       $id = $chastichnaya_otgr['id'];
       $price = $chastichnaya_otgr['price'];
       $sum_otgr = $chastichnaya_otgr['price']*$chastichnaya_otgr['otgruzka_ch'];
       // ВОТ ЗДЕСЬ СМОТРИ!!!!!!! остаток надо брать с базі
       $select = Sales::select_otgruzka_from_sales($number_n,$id);
       $all_otgr_one_prod =[];
       $i = 0;
       //массив с всеми отгрузками одного продукта
      foreach($select as $select_1):
          $all_otgr_one_prod[$i] = $select_1 -> otgruzka;
         $i++; 
      endforeach;
      $sumprod_otgr = array_sum($all_otgr_one_prod);
       $ost= $chastichnaya_otgr['quantity'] - $chastichnaya_otgr['otgruzka_ch']-$sumprod_otgr;
 
       $ost_sum = $ost * $chastichnaya_otgr['price'];
       //*******************************************************************
       $date_otgr = date("m.d.y");
       $chast[$n] = $chastichnaya_otgr['otgruzka_ch'];
       $chastichnaya_otgruzka = $chastichnaya_otgr['otgruzka_ch'];
       
       $all[$n] = $chastichnaya_otgr['quantity'];
       
       
      
      
      
     
  
     
      if($sumprod_otgr == $chastichnaya_otgr['quantity']){
       if($chastichnaya_otgr['otgruzka_ch'] > 0 ||  $chastichnaya_otgr['otgruzka_ch'] == '*'){
               echo $sumprod_otgr;
     echo $chastichnaya_otgr['quantity'];
             include __DIR__.'/../include/prov_sale_r.php';                                               
     $test_numeric_sales = 3;                                                                              
      include __DIR__. '/../views/edite_n.php';                                                           
        exit();            
          $stop= Sales::otkat();
           
       }
         
      }
      else{
      
      //ЕСЛИ ЧАСТИЧНАЯ ОТГРУЗКА ="*" отгружаем все что выписано
      if($chastichnaya_otgr['otgruzka_ch'] == '*'):
       $chastichnaya_otgruzka = $chastichnaya_otgr['quantity'] -  $sumprod_otgr;
       $ost = 0;
       $ost_sum = 0;
       $sum_otgr = $chastichnaya_otgruzka * $chastichnaya_otgr['price'];
       $insert = Sales::get_insert_otgruzka_to_sale($id,$curent_number,$number_n,$date_otgr,$chastichnaya_otgruzka,$sum_otgr,$ost,$ost_sum);
      endif;
      //ЕСЛИ ЧАСТИЧНАЯ ОТГРУЗКА РАВНА "0", То не выполняем никакие действия
      if($chastichnaya_otgr['otgruzka_ch'] == 0 || $chastichnaya_otgr['otgruzka_ch'] == '0' || $chastichnaya_otgr['otgruzka_ch'] == NULL ):
      
      endif;
      
      $deference_otgr = $chastichnaya_otgr['quantity'] - $chastichnaya_otgr['otgruzka_ch'] - $sumprod_otgr;
      if($deference_otgr<0):
          include __DIR__.'/../include/prov_sale_r.php';                                               
     $test_numeric_sales = 2;                                                                              
      include __DIR__. '/../views/edite_n.php';                                                           
        exit();            
          $stop= Sales::otkat();
          
      endif;
      
       if($chastichnaya_otgr['otgruzka_ch']>0):
           // Здесь чтото криво, никакой математики
          $insert = Sales::get_insert_otgruzka_to_sale($id,$curent_number,$number_n,$date_otgr,$chastichnaya_otgruzka,$sum_otgr,$ost,$ost_sum); 

       endif;
       
    
       
       
       $n++;
      }
      $otgruzka_array[$n] = $n;
   endforeach;
endif;   
   
   
  
  
 return $select;
   }

   
    
    
     //echo "N-nakl".$n_nakladnoy;
     //var_dump($_POST);
     //извлекаем и сортируем входящие даные в 2 массива
     //$isset_prod = [] - существующие продукты
     //$new_prod = [] новые продукты
    
     $isset_products = [];
     $new_products = [];
     
     foreach ($cleen_array as $k => $v):
        if (preg_match("/^actioncheck\d+$/", $k)){
           $isset_products[$k] = $v; 
           
           
            
        } 
          if (preg_match("/^quantity\d+$/", $k)){
           $isset_products[$k] = $v;
          $isset_products[$k]= trim_all($isset_products[$k]);
            
        }
        
         if (preg_match("/^otgruzka_ch\d+$/", $k)){
           $isset_products[$k] = $v;
          $isset_products[$k] = trim_all($isset_products[$k]);
            
        }
       
          if (preg_match("/^price\d+$/", $k)){
           $isset_products[$k] = $v;
          $isset_products[$k] = trim_all($isset_products[$k]);
            
        }
        
        if (preg_match("/^action_new\d+$/", $k)){
           $new_products[$k] = $v;  
           
            
        }
        
        if (preg_match("/^quantity_new\d+$/", $k)){
           $new_products[$k] = $v;  
           
            
        }
        
        if (preg_match("/^price_new\d+$/", $k)){
           $new_products[$k] = $v;  
           
            
        }
        
        

     endforeach;
     
     
     //ПРОВЕРКА ВХОДЯЩИХ ДАННИХ СУЩЕСТВУЮЩИХ ТОВАРОВ
     // Разбиваем существующие товары на отдельные вложенные массивы в $isset_product = [];---------------------- //
                                                                                                                  //
                                                                                                                  //
     $isset_product = [];                                                                                         //
     foreach ($isset_products as $ki => $tesst_isset):                                                            //
        if (preg_match("/^actioncheck\d+$/", $ki)){                                                               //
           $isset_product[$ki]['id'] = $tesst_isset;                                                              //
                                                                                                                  //
           $isset_product[$ki]['quantity'] = $isset_products['quantity'.$isset_product[$ki]['id']];               //
                                                                                                                  //
           $is_num_isset_quan = is_numeric($isset_product[$ki]['quantity']); // Число ли это                      //                             
                                                                                                                  //
            if($is_num_isset_quan != TRUE){                                                                       //
                                                                                                                  //
                                                                                                                  //
include __DIR__.'/../include/prov_sale_r.php';                                                                    //
     $test_numeric_sales = 1;                                                                                     //
      include __DIR__. '/../views/edite_n.php';                                                                   //
        exit();                                                                                                   //
            }                                                                                                     //
                                                                                                                  //
                                                                                                                  //                                 
           $isset_product[$ki]['price'] = $isset_products['price'.$isset_product[$ki]['id']];                     //
                                                                                                                  //
                                                                                                                  //
           $is_num_isset_price = is_numeric($isset_product[$ki]['price']); // Число ли это                        //                   // на точки ЦЕНА
              if($is_num_isset_price != TRUE){                                                                    //
include __DIR__.'/../include/prov_sale_r.php';                                                                    //
     $test_numeric_sales = 1;                                                                                     //
      include __DIR__. '/../views/edite_n.php';                                                                   //
        exit();                                                                                                   //
            }                                                                                                     //                  
           if ($isset_product[$ki]['quantity']=== NULL or $isset_product[$ki]['price'] != TRUE){                  //
               unset($isset_product[$ki]);                                                                        //
                                                                                                                  //
                                                                                                                  //
           }                                                                                                      //
                                                                                                                  //
 /////////////         РАБОТАЕМ С ОТГРУЗКАМИ  --------------------------------------------------------------//    //
 //Выполняем условия вывода                                                                                 //    //
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////    //                                                                                                               
                                                                                                            //    //
                                                                                                            //    //
           $isset_product[$ki]['otgruzka_ch'] = $isset_products['otgruzka_ch'.$isset_product[$ki]['id']]; //    //
                                                                                        //    //
         if ($isset_product[$ki]['otgruzka_ch']>$isset_product[$ki]['quantity']){                           //    //
             include __DIR__.'/../include/prov_sale_r.php';                                                 //    //
     $test_numeric_sales = 2;                                                                               //    //
      include __DIR__. '/../views/edite_n.php';                                                             //    //
        exit();                                                                                             //    //
         }                                                                                                  //    //
     /*      $is_num_isset_quan2 = is_numeric($isset_product[$ki]['otgruzka_ch']); // Число ли это            //    //                                
                                                                                                            //    //
            if($is_num_isset_quan2 != TRUE){                                                                //    //
                                                                                                            //    //
                                                                                                            //    //
include __DIR__.'/../include/prov_sale_r.php';                                                              //    //
     $test_numeric_sales = 1;                                                                               //    //
      include __DIR__. '/../views/edite_n.php';                                                             //    //
        exit();                                                                                             //    //
            }    */                                                                                           //    //
                                                                                                 //    //
 //===========================================================================================================    //                                                                                                            //
                                                                                                                  //
                                                                                                                  //
                                                                                                                  //
                                                                                                                  //
           $test_array_isset = count($isset_product[$ki]);                                                        //
           if ($test_array_isset != 3){                                                                           //
               unset($isset_products[$ki]);                                                                       //
           }                                                                                                      //
        }                                                                                                         //  
                                                                                                                  //
     endforeach;                                                                                                  //
     //*************************************************************************************************************
     
     
     
     
    
    
     chast_otgruzka($isset_product, $number_n, $otgruzka); 
     
     //ПРОВЕРКА ВХОДЯЩИХ ДАННИХ НОВЫХ ТОВАРОВ
     // Разбиваем новіе товарі на отдельніе вложенніе массиві в $new_product = [];---------------------------------//
     $new_product = [];                                                                                            //
     foreach ($new_products as $ky => $tesst_new):                                                                 //
        if (preg_match("/^action_new\d+$/", $ky)){                                                                 //
           $new_product[$ky]['id'] = $tesst_new;                                                                   //
                                                                                                                   //
          $new_product[$ky]['quantity'] = $new_products['quantity_new'.$new_product[$ky]['id']];                   //
         $new_product[$ky]['quantity'] = trim_all ($new_product[$ky]['quantity']);                                                                 //
          $is_num_new_quan = is_numeric($new_product[$ky]['quantity']); // Число ли это                            //                    
                     if($is_num_new_quan != TRUE){                                                                 //
include __DIR__.'/../include/prov_sale_r.php';                                                                     //
     $test_numeric_sales =1;                                                                                       //
      include __DIR__. '/../views/edite_n.php';                                                                    //
        exit();                                                                                                    //
            }                                                                                                      //                         
           $new_product[$ky]['price'] = $new_products['price_new'.$new_product[$ky]['id']];                        //
          $new_product[$ky]['price'] = trim_all($new_product[$ky]['price']);                                                                   //
           $is_num_new_price = is_numeric($new_product[$ky]['price']); // Число ли это                             //                                                                                            
           if($is_num_new_price != TRUE){                                                                          //
include __DIR__.'/../include/prov_sale_r.php';                                                                     //
     $test_numeric_sales =1;                                                                                       //
      include __DIR__. '/../views/edite_n.php';                                                                    //
        exit();                                                                                                    //
            }                                                                                                      //
           if ($new_product[$ky]['quantity']=== NULL or $new_product[$ky]['price'] != TRUE){                       //
               unset($new_product[$ky]);                                                                           //
                                                                                                                   //
                                                                                                                   //
           }                                                                                                       //
           $test_array_new = count($new_product[$ky]);                                                             //
           if ($test_array_new != 3){                                                                              //
               unset($new_products[$ky]);                                                                          //
           }                                                                                                       //
        }                                                                                                          //
     endforeach;                                                                                                   //
                                                                                                                   //
                                                                                                                   //
     //*************************************************************************************************************

// ПОДСЧИТІВАЕМ ОБЩЕЕ КОЛИЧЕСТВО ИОВАРОВ В НАКЛАДНОЙ ------------
    //количество существующих товаров в накладной              //
$isset_product_total = count($isset_product);                  //
// количество добавленных товаров                              //
$new_product_total = count($new_product);                      //
// общее количество всех товаров в накладной                   //
$count_prod = $isset_product_total + $new_product_total;       //
//номер накладной                                              //
        if($count_prod < 1){                                   //
           include __DIR__.'/../include/prov_sale_r.php';      //
     $test_count =1;                                           //
      include __DIR__. '/../views/edite_n.php';                //
        exit();                                                //
        }                                                      //
//***************************************************************
        
//---ПОЛУЧАЕМ НЕОБХОДИМЫЕ ДАННЫЕ ИЗ НАКЛАДНОЙ -----------------//        
$tt = Sales::get_one_sales($number_n);                         //
 if ($tt != TRUE){$otkat=Sales::otkat(); exit(); }             //
                                                               //
foreach ($tt as $rows_sale):                                   //
     $rows_sale -> contragent_id;                              //
     $total_sum2 = $rows_sale ->total;                         //
     $n_contr = $rows_sale -> contragent_name;                 //
     $col_prod = $rows_sale -> col_prod;                       //
                                                               //
                                                               //
endforeach;                                                    //
$true_id =  $rows_sale -> contragent_id;                       //
                                                               //
//***************************************************************


 




// ОБНОВЛЕНИЕ КОЛИЧЕСТВА НАКЛАДНІХ ПОКУПАТЕЛЯ ПРИ СМЕНЕ КОНТРАГЕНТА---------------------------------------------------
if($id_contragent_sel[1] == TRUE and $id_contragent_sel[1] != $rows_sale -> contragent_id ){                        //
  
                                                                                                                    //
      // получаем количество накладніх от текущего покупателя                                                       //
      // и уменьшаем на 1                                                                                           //
      $select_sales_shoper = Buers::getSales_pokupatel($true_id);                                                   //
       if ($select_sales_shoper != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА ВІБОРКИ КОЛИЧЕСТВА НАКЛАДНІХ"); }      //
      $sales_shoper = $select_sales_shoper[0] -> sales;                                                             //
      $sales_shoper --;                                                                                             //
      $id_shoper = $true_id;                                                                                        //
      $sales = $sales_shoper;                                                                                       //
      $upd_true_sales_shoper = Buers::get_upd_sales_shoper($id_shoper, $sales);                                     //
       if ($upd_true_sales_shoper != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА ОБНОВЛЕНИЯ КОЛИЧЕСТВА НАКЛАДНІХ"); } //
      unset($select_sales_shoper[0] -> sales,$true_id, $sales_shoper, $sales, $id_shoper, $select_sales_shoper);    //
                                                                                                                    //
      // получаем количество накладніх от нового покупателя                                                         //
      // и увеличиваем на 1                                                                                         //
      $true_id = $id_contragent_sel[1];                                                                             //
      $get_new_sales_shoper = Buers::getSales_pokupatel($true_id);                                                  //
       if ($get_new_sales_shoper != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА ВІБОРКИ КОЛИЧЕСТВА НАКЛАДНІХ"); }     //
      $new_sales_shoper = $get_new_sales_shoper[0] -> sales;                                                        //
     $sales = (int)$new_sales_shoper;                                                                               //
     $sales = $sales +1;                                                                                            //
      $id_shoper = $id_contragent_sel[1];                                                                           //
      $upd_new_sales_shoper = Buers::get_upd_sales_shoper($id_shoper, $sales);                                      //
      if ($get_new_sales_shoper != TRUE){$otkat=Sales::otkat(); exit("ОШИБКА ВІБОРКИ КОЛИЧЕСТВА НАКЛАДНІХ"); }      //
                                                                                                                    //
                                                                                                                    //
                                                                                                                    //
     }                                                                                                              //
                                                                                                                    //
     //***************************************************************************************************************
     
     
     
     
     
     
     
     

// Проверяем сколько существующих товаров біло в накладной и какие біли убрані---------------
    // Извлекаем все ID товаров отправленные на изменение                                  //
     $id_isset_produkts = [];                                                              //
     $i =0;                                                                                //
     foreach ($isset_product as $id_isset_product):                                        //
         $id_isset_produkts[$i] = $id_isset_product['id'];                                 //
         $i++;                                                                             //
                                                                                           //
     endforeach;                                                                           //
     // Извлекаем все ID товаров до изменения                                              //
     $i2 = 0;                                                                              //
     $id_old_isset_produkts = [];                                                          //
     $id_old_isset = Sales::get_Product_from_nakl($number_n);                              //
     if ($id_old_isset != TRUE){$otkat=Sales::otkat(); exit(); }                           //
                                                                                           //
     foreach($id_old_isset as $id_old_isset_product):                                      // 
     $id_old_isset_produkts[$i2] = $id_old_isset_product -> id_product;                    //
     $i2++;                                                                                //
    endforeach;                                                                            //
    // сравниваем                                                                          //
    $difference = array_diff($id_old_isset_produkts, $id_isset_produkts);                  //
    $difference_count = count($difference);                                                //
    $number = $number_n;                                                                   // 
                                                                                           //
                                                                                           //
    if($difference_count > 0){                                                             //
     foreach($difference as $delete_isset):                                                //
                                                                                           //  
                                                                                           //
      // ВЫЗОВ БАЛАНСА                                                                     //
         $balance_tek = curent_balance($delete_isset);                                     //
                                                                                           //
                                                                                           // 
         // получаем товары из накладной которые необходимо удалить                        //
         $delete = Sales::get_Product_from_nakl_to_delete($number_n, $delete_isset);       //
         if ($delete != TRUE){$otkat=Sales::otkat(); exit(); }                             //
     foreach ($delete as $delete_m):                                                       //
         //высчитываем количество которое необходимо вернуть                               //
       $balance = $balance_tek + $delete_m -> col;                                         //
     // сумма для возврата                                                                 //
       $sum_to_ret = $delete_m -> sum;                                                     //
       // готовая сумма                                                                    //
       $total = $total_sum2 - $sum_to_ret;                                                 //
       // пересчитываем количество продуктов в накладной                                   //
       $count_prod = $col_prod -1;                                                         //
       $id_prod = $delete_isset;                                                           //
       // удаляем продукт из накладной                                                     //
     $del_p_n = Sales::getDelete_prod_from_nakl($id_prod);                                 //
     if ($del_p_n != TRUE){$otkat=Sales::otkat(); exit(); }                                //
                                                                                           //
       // обновляем балланс на складе                                                      //
     trim_all($balance);
    $upd_bal = Sales::get_update_balance_product($id_prod, $balance);                      //
                                                                                           //
    if ($upd_bal != TRUE){$otkat=Sales::otkat(); exit(); }                                 //
                                                                                           //
                                                                                           //
                                                                                           //
                                                                                           //
                                                                                           //
                                                                                           //
                                                                                           //
                                                                                           //
                                                                                           //
                                                                                           //
      // обновляем накладную                                                               //
    //$upd_sale = Sales::get_Update_sale($id_manager, $name_manager, $name_shoper,         //
    // $id_shoper, $oplata, $otgruzka, $provodka, $comment, $count_prod,                   //
    //  $number, $total, $col_prod);                                                       //
    //if ($upd_sale != TRUE){$otkat=Sales::otkat(); exit(); }                              //
                                                                                           //
                                                                                           //
     endforeach;                                                                           //
                                                                                           //
     endforeach;                                                                           //
                                                                                           //
    }                                                                                      //
                                                                                           //
    //***************************************************************************************
 
 //определяем оставшиеся товары, которые не были удалены но возможно были изменены----------------------------------
   foreach ($difference as $prod_ch):                                                                              //
      unset($isset_product["actioncheck".$prod_ch]);                                                               // 
                                                                                                                   // 
                                                                                                                   //
                                                                                                                   //
                                                                                                                   //
   endforeach;                                                                                                     //
                                                                                                                   //
                                                                                                                   //
    $i3 = 0;                                                                                                       //
    $sum_array = [];                                                                                               //
    $ballance_prod_array = [];                                                                                     //
    $price_prod_array =[];                                                                                         //
    $count_prod_array = []; 
    $otgruz_chast=[];
  foreach ($isset_product as $isset_product_row):                                                                  //
   $id_prod = $isset_product_row["id"];                                                                            //
    $ostatok = Sales::get_current_balance($id_prod);                                                               //
     if ($ostatok != TRUE){$otkat=Sales::otkat(); exit(); }                                                        //
    //остаток по складу                                                                                            //
    $ostatok[0]->col;                                                                                              //    
    $delete_isset = $id_prod;                                                                                      //
    $count = Sales::get_Product_from_nakl_to_delete($number_n, $delete_isset);                                     //
    if ($count != TRUE){$otkat=Sales::otkat(); exit(); }                                                           //
    // количество товара в накладной                                                                               //
    $count[0] -> col;                                                                                              //
    // Запрошенное количество товара                                                                               //
    $quant_product = $isset_product_row["quantity"];
    
     $quant_product = trim_all($quant_product);              //
    //РАЗНИЦА МЕЖДУ НОВЫМ И СТАРЫМ КОЛИЧЕСТВОМ                                                                     //
  $defernc_prod = $quant_product - $count[0] -> col;                                                               //
 $defernc_prod = trim_all($defernc_prod);                    
  //ЕСЛИ ЗАПРОШЕННОЕ КОЛИЧЕСТВО БОЛЬШЕ ОСТАТКА, ВЫВОДИМ ОШИБКУ                                                     //
  if ($defernc_prod > $ostatok[0]->col){                                                                           // 
                                                                                                                   //
 include __DIR__.'/../include/prov_sale_r.php';                                                                    //
     $test_ballance = 1;                                                                                           //
      include __DIR__. '/../views/edite_n.php';                                                                    //
        exit();                                                                                                    //
            }                                                                                                      //
            if ($quant_product < 0.00001){                                                                         // 
                                                                                                                   //
 include __DIR__.'/../include/prov_sale_r.php';                                                                    //
     $test_min_count = 1;                                                                                          //
      include __DIR__. '/../views/edite_n.php';                                                                    //
        exit();                                                                                                    //
            }                                                                                                      //
      //********************************************************************************************************** //
  
      unset($balance);  
           
  //ЗАПРОШЕННАЯ ЦЕНА
  $price_product = $isset_product_row["price"];
  
  $price = Sales::get_Product_one_from_nakl($id_prod);
  if ($price != TRUE){$otkat=Sales::otkat(); exit(); }
  //СТОП ЦЕНА
  
  $price_product = $price_product * 1;
  

  if ($price_product < $price[0]->stop ){
      
   
  include __DIR__.'/../include/prov_sale_r.php';
     $test_minprice = 1;
      include __DIR__. '/../views/edite_n.php';  
        exit();  
  }
  
  
 $sum = $price_product * $quant_product;
 $sum_array[$id_prod] = $sum;
  $balance = $ostatok[0]->col - $defernc_prod;
  $ballance_prod_array[$id_prod] = $balance;
 $price_prod_array[$id_prod] = $price_product;
 $count_prod_array[$id_prod] = $quant_product;
  
  //Цена товара
  
  
  
  
  
  $i3++;
  
  unset($balance);
      
      
      
      
  endforeach;
  
unset ($sum, $total_sum);
  //ОБНОВЛЕНИЕ ОСТАТКА СКЛАДА
  foreach ($ballance_prod_array as $id_prod => $balance):
      trim_all($balance); 
    $balance_upd = Sales::get_update_balance_product($id_prod, $balance); 
      if ($balance_upd != TRUE){$otkat=Sales::otkat(); exit(); }
  endforeach;  
  //ОБНОВЛЕНИЕ ЦЕН
  foreach ($price_prod_array as $id_product => $price):
      trim_all($price); 
    $price_upd = Sales::get_update_price_product($price, $id_product, $number_n); 
      if ($price_upd != TRUE){$otkat=Sales::otkat(); exit(); }

  endforeach;
  //ОБНОВЛЕНИЕ КОЛИЧЕСТВА В НАКЛАДНОЙ
  foreach ($count_prod_array as $id_product => $col):
      trim_all($col);
      $count_upd = Sales::get_update_count_product($id_product, $col, $number_n);
        if ($count_upd != TRUE){$otkat=Sales::otkat(); exit(); }

  endforeach;
  // ОБНОВЛЕНИЕ СУММЫ ПРОДУКТА
  foreach($sum_array as $id_product => $sum):
      trim_all($sum); 
      $sum_upd = Sales::get_update_sum_product($id_product, $sum, $number_n);
        if ($sum_upd != TRUE){$otkat=Sales::otkat(); exit(); }
  endforeach;
  //ОБНОВЛЕНИЕ ОБЩЕЙ СУММЫ НАКЛАДНОЙ И ОПЛАТЫ
  
  $total_sum = array_sum($sum_array);
  trim_all($total_sum); 
  $borg = round($total_sum,2) - $oplacheno;

  $total_sum_upd = Sales::get_update_total_sum_nakl($number_n, $total_sum, $oplacheno, $borg);
  
        if ($total_sum_upd != TRUE){$otkat=Sales::otkat(); exit(); }
   //ОБНОВЛЕНИЕ КОММЕНТАРИЯ
  $comment_upd = Sales::get_Update_comment_sale($number_n, $comment);      
  
       // $provodka = $_POST['provesti'];
     //$otgruzka = $_POST['otgruzka'];
     //$oplata = $_POST['oplata'];
    
     // ОБНОВЛЯЕМ СТАТУСЫ  
     $status_upd = Sales::get_update_status($provodka,$otgruzka,$oplata,$number_n);
     if ($status_upd != TRUE){$otkat=Sales::otkat(); exit(); }
     
     
   //РАБОТАЕМ С КОНТРАГЕНТОМ
     if (isset($id_contragent_sel[1])){
         $id_shoper = $id_contragent_sel[1];
         
         $name_con = Buers::getOne_pokupatel($id_shoper);
         if ($name_con != TRUE){$otkat=Sales::otkat(); exit(); }
         
         foreach ($name_con as $name_contr):
          $name_shoper =  $name_contr -> name;  
            
         endforeach;
       
          
     }
    
    
     else {
     $id_shoper = $rows_sale -> contragent_id; 
     $name_shoper = $n_contr;
      
     }        
     $contr = Sales::get_Update_contragent_sale($number_n, $name_shoper, $id_shoper); 
     if ($contr != TRUE){$otkat=Sales::otkat(); exit(); }
        
   if($new_product_total == 0){
      
       
        include __DIR__.'/../include/prov_sale_r.php';
     $nonew = 1;
      include __DIR__. '/../views/edite_n.php';  
         
        
        
        
    }
  else{
    
    $n = 0;
   foreach ($new_product as $product):
   
   $products[$n] = $product;
   // ID ТОВАРА
   $id_product = $products[$n]['id'];
    
   $ballance_new = Sales::get_current_balance($id_product);
   if ($ballance_new != TRUE){$otkat=Sales::otkat(); exit(); }
   // НАЗВАНИЕ
   $name = $ballance_new[0]->name_tovar;
   //БАЛЛАНС НА СКЛАДЕ
   $balance = $ballance_new[0]->col;
   //ЗАПРОШЕННОЕ КОЛИЧЕСТВО
   $quantity = $products[$n]['quantity'];
   //ЕД.ИЗМ
   $edizm = $ballance_new[0]->ed_izm;
   // Проверяем не превышает ли запрошенное количество балланс на складе
   if ($quantity > $balance){
       
      include __DIR__.'/../include/prov_sale_r.php';
     $test_ballance = 1;
      include __DIR__. '/../views/edite_n.php';  
        exit(); 
       
   }
   // STOP ЦЕНА
   $price_min = $ballance_new[0]->stop;
   // ЗАПРОШЕННАЯ ЦЕНА
   $price_new = $products[$n]['price'];
   
   //ЕСЛИ ЗАПРОШЕННАЯ ЦЕНА НИЖЕ МИНИМАЛЬНОЙ ВОЗВРАЩАЕМ ОШИБКУ
   if($price_new < $price_min){
       
      include __DIR__.'/../include/prov_sale_r.php';
     $test_minprice = 1;
      include __DIR__. '/../views/edite_n.php';  
        exit();   
       
       
   }
  
   //СУММА ЗА ТОВАР
   $sum = $price_new * $quantity;
   $price = $price_new;
   $count = $quantity;
   $id_prod = $id_product;
   $number = $number_n;
   
   $newpr = Sales::get_insert_product_to_sale($id_prod, $name, $number, $price, $count, $sum, $balance, $edizm);
   if ($newpr != TRUE){$otkat=Sales::otkat(); exit(); }
   //БАЛЛАНС
   $newbal = $balance - $quantity;
   $balance = $newbal;
   $newb = Sales::get_update_balance_product($id_prod, $balance);
   if ($newb != TRUE){$otkat=Sales::otkat(); exit(); }
   $getsale = Sales::get_one_sales($number_n);
   if ($getsale != TRUE){$otkat=Sales::otkat(); exit(); }
   $total_pr = $getsale[0] -> col_prod; 
   $total = $getsale[0] -> total + $sum;
   $total_pr ++;
  $total_sum = $total;
  
   $name_manager = $manager_name;
   $count_prod = $total_pr;
   $updsale = Sales::get_Update_sale($id_manager, $name_manager, $name_shoper, $id_shoper, $oplata, $otgruzka, $provodka, $comment, $count_prod, $number, $total);
   if ($updsale != TRUE){
       $otkat=Sales::otkat();
       exit("ERROR");
       
   }
       $n++;
       
       
   endforeach;
  

     
    include __DIR__.'/../include/prov_sale_r.php';
     $nonew = 1;
      include __DIR__. '/../views/edite_n.php'; 
    
  }  
  //ОБРАБОТКА БОНУСОВ
  $new_contr = (int)$id_contragent_sel[1];      
  $old_contr = (int)$rows_sale -> contragent_id; 
  
  $totalsum_obj = Sales::get_one_sales($number_n);
  $total_sum_new = $totalsum_obj[0] ->total;
  $total_sum_old = $_POST['total_sum'];
 
  
  function bonus_upd($new_contr, $old_contr, $total_sum_new, $bonus_old_contr, $total_sum_old){
   if ($new_contr != 0 and $new_contr != $old_contr){
      
         $bonus_nakl_new = $total_sum_new / 100;
         $bonus_nakl_old = $total_sum_old / 100;
         $bonus_obj_new = Buers::getOne_pokupatel($new_contr);
         $bonus_new_contr = $bonus_obj_new[0] -> bonus;
         $bonus_to_new = ($bonus_new_contr + $bonus_nakl_new);
         $upd_bonus_new_contr = Buers::get_upd_bonus_shoper($bonus_to_new, $new_contr);
         $bonus_obj_old = Buers::getOne_pokupatel($old_contr);
         $bonus_old_contr = $bonus_obj_old[0] -> bonus;
         $bonus_to_old = ($bonus_old_contr - $bonus_nakl_old);
         $upd_bonus_old_contr = Buers::get_upd_bonus_shoper($bonus_to_old, $old_contr);
   
   }   
    else{
        
         $bonus_nakl_new = $total_sum_new / 100;
         $bonus_nakl_old = $total_sum_old / 100;
        
         $bonus_def = ($bonus_nakl_new - $bonus_nakl_old);
         $bonus_obj_old = Buers::getOne_pokupatel($old_contr);
         $bonus_old_contr = $bonus_obj_old[0] -> bonus; 
         $bonus_to_old = ($bonus_old_contr + $bonus_def);
         $upd_bonus_old_contr = Buers::get_upd_bonus_shoper($bonus_to_old, $old_contr); 

    }  
      
      
     return $upd_bonus_old_contr; 
  }

   $bonus_upd = bonus_upd($new_contr, $old_contr, $total_sum_new, $bonus_old_contr, $total_sum_old);
    
   
   
   
   
    
    $sto = Sales::stop_transaction();
 
   
}


public function actionSales_shoper(){
    $start =Sales::start_transaction();
    $id = $_POST['id'];
    
 $sales = Sales::get_shoper_sales($id);
 
 if ($sales != TRUE){$otkat=Sales::otkat(); exit(); echo 'NO';}
       
        
  $stop=Sales::stop_transaction();      
        
        
    include __DIR__. '/../views/sales.php';     
    
    
    
    
    
}

public function actionDelete_nakl(){
    
    
    
    
    
}

}