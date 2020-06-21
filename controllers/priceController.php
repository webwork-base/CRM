<?php
require_once ('classes/db.php');  

class priceController {
    
    
  public function actionGetprice(){
      
     $price = Price::get_all_cat();
      
  $prod = Price::get_all_product();
  
      
//      $view = new View();
//      $view ->assign('buers', $buers);
//      $view ->display('price.php');
      
      
      include __DIR__. '/../views/price.php';
      
      
      
  }  
    
  public function actionDelete_product() {
      $id = $_POST['prod_id'];
      $delete = Price::getDelete_product($id);
      $price = Price::get_all_cat();
      $prod = Price::get_all_product();
      if ($delete === TRUE)
      {
          
          include __DIR__. '/../views/price.php';
          
          
      }
      
  }
    
 
  public function actionUpdate_product() {
      
      
    $id = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['prod_id'])), '.')); 
    $strcod = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['strcod'])), '.'));
    $stop = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['stop'])), '.'));
    $kopt = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['kopt'])), '.'));
    $sopt = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['sopt'])), '.'));
    $mopt = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['mopt'])), '.'));
    $rozn = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['rozn'])), '.'));
    $edizm = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['edizm'])), '.'));
    $name = trim (str_replace (',', '.', trim($_POST ['name'])), '.');
    $number = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['number'])), '.'));
    $art = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['art'])), '.'));
    $cat_id = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['cat_id'])), '.')); 
    $nomer_pr = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['nomer_pr'])), '.'));
    
    $test_r = is_numeric($rozn);
    $test_m = is_numeric($mopt);
    $test_sr = is_numeric($sopt);
    $test_k = is_numeric($kopt);
    $test_s = is_numeric($stop);		
    
    //$test_nomer_pr = is_numeric($nomer_pr);
    //$test_number = is_numeric($number);
    
    if ($test_r != true || $test_m != true || $test_k != true || $test_s != true ||  $test_sr != true ){
            $test_numeric = 1;
             $price = Price::get_all_cat();
             $prod = Price::get_all_product();
             include __DIR__. '/../views/price.php';
             exit();
          }
     if ($rozn < $mopt || $rozn < $sopt || $rozn < $kopt || $rozn < $stop || $mopt < $sopt || $mopt < $kopt || $mopt < $stop || $sopt < $kopt || $sopt < $stop || $kopt < $stop ){
      $test_price = 1; 
      $price = Price::get_all_cat();
      $prod = Price::get_all_product();
      include __DIR__. '/../views/price.php';
      exit();
     }          
          

    $update = Price::getUpdate_product($id, $art, $name, $edizm, $rozn, $mopt, $sopt, $kopt, $stop, $strcod, $cat_id);
     $price = Price::get_all_cat();
     $prod = Price::get_all_product();
     
      if ($update === TRUE)
      {
          
          include __DIR__. '/../views/price.php';
          
          
      }
      else {
          echo "Ошибка обновления";
          
      }
      
  }
  
  public function actionAdd_category(){
   $name = $_POST ['name']; 
   $number = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['number'])), '.'));
   $test_numeric = is_numeric($number);
  
   if ($test_numeric === FALSE){
      $price = Price::get_all_cat();
      $prod = Price::get_all_product();
      include __DIR__. '/../views/price.php';
      exit();
   }
   $add_catalog = Price::getAdd_catalog($name, $number);
   if ($add_catalog === TRUE){
      $price = Price::get_all_cat();
      $prod = Price::get_all_product();
      include __DIR__. '/../views/price.php'; 
       
   }
      
   
      
      
      
      
  }
  
  
  
  
  
  
  
  public function actionUpdate_category(){
     $id = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['cat_id'])), '.'));
     $name = $_POST ['name'];
     $update_c = Price::getUpdate_catalog($id, $name);
     $price = Price::get_all_cat();
     $prod = Price::get_all_product();
     if ($update_c === TRUE)
      {
          
          include __DIR__. '/../views/price.php';
          
          
      }
      else {
          echo "Ошибка обновления";
          
      }
  } 
  
  public function actionDelete_category(){
     $id = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['cat_id'])), '.')); 
     $test_col_prod = Price::getProd_catalog($id);
     if ($test_col_prod > 0){
         $price = Price::get_all_cat();
         $prod = Price::get_all_product();
         include __DIR__. '/../views/price.php';
     }
     else {
         
         $delete_cat = Price::getDelete_catalog($id);
         if ($delete_cat === TRUE) {
            $price = Price::get_all_cat();
            $prod = Price::get_all_product();
            include __DIR__. '/../views/price.php';
         
         }
         
         else {
             echo "ОШИБКА УДАЛЕНИЯ КАТЕГОРИИ";
         }
         
     }
     
  }
  
  public function actionAdd_product(){
      
    $id_catalog = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['cat_id'])), '.')); 
    $strcod = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['strcod'])), '.'));
    $stop = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['stop'])), '.'));
    $kopt = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['kopt'])), '.'));
    $sopt = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['sopt'])), '.'));
    $mopt = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['mopt'])), '.'));
    $rozn = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['rozn'])), '.'));
    $edizm = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['edizm'])), '.'));
    $name = trim (str_replace (',', '.', trim($_POST ['name'])), '.');
    
    $art = str_replace(' ', '',trim (str_replace (',', '.', trim($_POST ['art'])), '.')); 
      
     $test_r = is_numeric($rozn);
    $test_m = is_numeric($mopt);
    $test_sr = is_numeric($sopt);
    $test_k = is_numeric($kopt);
    $test_s = is_numeric($stop);
    $test_number = is_numeric($id_catalog);
    
    if ($test_r != true || $test_m != true || $test_k != true || $test_s != true || $test_m != true || $test_sr != true || $test_number != true){
             $test_numeric = 1;
             $price = Price::get_all_cat();
             $prod = Price::get_all_product();
             include __DIR__. '/../views/price.php';
             exit();
          }
     if ($rozn < $mopt || $rozn < $sopt || $rozn < $kopt || $rozn < $stop || $mopt < $sopt || $mopt < $kopt || $mopt < $stop || $sopt < $kopt || $sopt < $stop || $kopt < $stop ){
      $test_price = 1; 
      $price = Price::get_all_cat();
      $prod = Price::get_all_product();
      include __DIR__. '/../views/price.php';
      exit();
     }     
       
          $test_articul = Price::getTest_articul($art);
          if ($test_articul < 1){
             $add = Price::getAdd_product($art, $name, $edizm, $rozn, $mopt, $sopt, $kopt, $stop, $strcod, $id_catalog);
             if($add === TRUE){
             $price = Price::get_all_cat();
             $prod = Price::get_all_product();
             include __DIR__. '/../views/price.php';
             }
             else {
                 echo "НЕУДАЧНО";
             }
          }
 else {
     $test_articul = 1;
     $price = Price::get_all_cat();
     $prod = Price::get_all_product();
     include __DIR__. '/../views/price.php';
 }
          
      
      
      
  }
  //                                                    EXPORT
  public function actionExport_excel() {
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
$active_sheet ->setTitle("Прайс");                                                                  // Название листа
$active_sheet ->getHeaderFooter()->setOddHeader("&CПрайс лист из базы");                           // Заголовок верхний
$active_sheet ->getHeaderFooter()->setOddFooter('&L&B'.$active_sheet ->getTitle().'&RСтраница &P из &N'); // Заголовок нижний
$objPHPexcel->getDefaultStyle()->getFont()->setName('Arial');                                             // Шрифт
$objPHPexcel->getDefaultStyle()->getFont()->setSize(8);                                                    // Размер шрифта
//Настройки размеров ячеек
$active_sheet->getColumnDimension('A')->setWidth(5); // номер
$active_sheet->getColumnDimension('B')->setWidth(7); // артикул
$active_sheet->getColumnDimension('C')->setWidth(65); // название
$active_sheet->getColumnDimension('D')->setWidth(5); // ед.изм
$active_sheet->getColumnDimension('E')->setWidth(7); // розница
$active_sheet->getColumnDimension('F')->setWidth(7); // м.опт
$active_sheet->getColumnDimension('G')->setWidth(7); // с.опт
$active_sheet->getColumnDimension('H')->setWidth(7); // к.опт
$active_sheet->getColumnDimension('I')->setWidth(7); // стоп 
$active_sheet->getColumnDimension('J')->setWidth(7); // остаток
//Шапка
$active_sheet->mergeCells('A1:J1'); // объединение
$active_sheet->getRowDimension(1)->setRowHeight(30);// высота 
$active_sheet->setCellValue('A1', 'Лаки-Буд'); // значение

$active_sheet->mergeCells('A2:C2'); // объединение
$active_sheet->getRowDimension(2)->setRowHeight(20);// высота 
$active_sheet->setCellValue('A2', 'Строительные материалы по доступным ценам'); // значение

$date = date('d-m-Y');

$active_sheet->mergeCells('D2:G2'); // объединение
$active_sheet->setCellValue('D2', 'Дата создания'); // значение

$active_sheet->mergeCells('H2:J2'); // объединение
$active_sheet->setCellValue('H2', $date); // значение
$active_sheet->getStyle('H2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14); //установка формата даты



//установка заголовков для данных
$active_sheet->setCellValue('A4', '№'); // значение
$active_sheet->setCellValue('B4', 'арт-ул'); // значение
$active_sheet->setCellValue('C4', 'название товара'); // значение
$active_sheet->setCellValue('D4', 'ед'); // значение
$active_sheet->setCellValue('E4', 'розн'); // значение
$active_sheet->setCellValue('F4', 'м.опт'); // значение
$active_sheet->setCellValue('G4', 'c.опт'); // значение
$active_sheet->setCellValue('H4', 'к.опт'); // значение
$active_sheet->setCellValue('I4', 'стоп'); // значение
$active_sheet->setCellValue('J4', 'ост-ок'); // значение

//Запись данных в цикле**************************************************
$start=5;
$i=0;
$number_prod = 1;
foreach($export as $val){
	$next_val = $start + $i;
	
      $active_sheet->setCellValue('A'.$next_val, $number_prod); // значение	
      $active_sheet->setCellValue('B'.$next_val, $val ->art); // значение	
      $active_sheet->setCellValue('C'.$next_val, $val -> name_tovar); // значение	
      $active_sheet->setCellValue('D'.$next_val, $val->ed_izm); // значение	
      $active_sheet->setCellValue('E'.$next_val, $val -> roznica); // значение	
      $active_sheet->setCellValue('F'.$next_val, $val -> m_opt); // значение	
      $active_sheet->setCellValue('G'.$next_val, $val ->s_opt); // значение	
      $active_sheet->setCellValue('H'.$next_val, $val -> s_opt); // значение	
	  $active_sheet->setCellValue('I'.$next_val, $val -> stop); // значение	
	  $active_sheet->setCellValue('J'.$next_val, $val -> col); // значение	
	
	
$i++;	
$number_prod ++;
}
// Конец цикла записи данных****************************************************

//установка обводок

                 //внешняя граница ---------------------
$style_wrap = array(
 'borders'=>array(
  'outline' => array(
   'style'=>PHPExcel_Style_Border::BORDER_THICK     ),
   //----------------------------------------------------------------------
                 // Внутренние границы -------------------------------------
 'allborders'=>array(
   'style'=>PHPExcel_Style_Border::BORDER_THIN, 'color' =>array(
     'rgb'=>'696969')    )
   )            );
//--------------------------------------------------------------------------------

$active_sheet->getStyle('A1:J'.($i+4))->applyFromArray($style_wrap);
//конец установки  обводок ********************************************************

//Установка стиля хедера

$style_header = array(
                //шрифт
 'font'=>array(
    'bold'=>true,
	'name'=>'Verdana',
	'size'=>20
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
	   'rgb'=>'CFCFCF')
  )
  //-------------------------------------------------------------
);

$active_sheet->getStyle('A1:J1')->applyFromArray($style_header);
//Конец установки стилей хедера



//Установка стиля слогана
$style_slogan = array(
                //шрифт
 'font'=>array(
    'bold'=>true,
	'italic'=>true,
	'name'=>'Verdana',
	'size'=>10,
	'color'=>array(
	  'rgb'=>'8B8989'
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
	   'rgb'=>'CFCFCF')
  ),
  'borders'=>array(
    'bottom'=>array(
	  'style'=>PHPExcel_Style_Border::BORDER_THICK  
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
    'bold'=>true,
	'italic'=>true,
	'name'=>'Verdana',
	'size'=>10,
	'color'=>array(
	
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
	  'style'=>PHPExcel_Style_Border::BORDER_THICK  
	)
  )
  //-------------------------------------------------------------
);

$active_sheet->getStyle('D2:J2')->applyFromArray($style_date);
//Конец установки стилей даты






//Установка стиля стартовой строки
$style_startrow = array(
                //шрифт
 'font'=>array(
    'bold'=>true,
	
	'name'=>'Verdana',
	'size'=>7,
	'color'=>array(
	  'rgb'=>'000000'
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
	   'rgb'=>'F6F6F6'
  )
  )
  //-------------------------------------------------------------
);

$active_sheet->getStyle('A4:J4')->applyFromArray($style_startrow);
//Конец установки стилей стартовой строки










//Установка стиля стартовой строки
$style_rows = array(
               
	//-------------------------------------------------------
	              // Выравнивание
  'alignment'=> array(
       'horizontal'=>PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT
	
  )
  //----------------------------------------------------------------
                // Заливка
  
);

$active_sheet->getStyle('A4:J'.($i+4))->applyFromArray($style_rows);
//Конец установки стилей стартовой строки













// отдаем необходимые заголовки для браузера
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=base".date('d-m-y').".xls");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');

$objWriter ->save('php://output');

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------







exit();


      
  }
  
  public function actionImport(){
      $impo = Price::getImport_setting();
      
     //var_dump($impo['id']);
    include __DIR__. '/../views/import.php';  
      
      
      
  }
  
  public function actionImport_price(){
      
   $filename = $_FILES['importfile']['name'];

$type = $_FILES['importfile']['type'];

$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm", ".xls", ".xlsx", ".sql", ".js", ".xml");
  foreach ($blacklist as $item)
    if(preg_match("/$item\$/i", $_FILES['importfile']['name'])) exit;
  $type = $_FILES['importfile']['type'];
  $size = $_FILES['importfile']['size'];
  if (($type != "application/vnd.ms-excel")) exit;
  if ($size > 102400) exit;


$uploadfile = "uploads/".$_FILES['importfile']['name'];
$ntr = move_uploaded_file($_FILES['importfile']['tmp_name'], $uploadfile);

rename ("uploads/".$filename."", 'uploads/price.csv' );


      $barcode1 = trim($_POST['barcode']);
	$roznica1 = trim($_POST['roznica']);
	$mopt1 = trim($_POST['mopt']);
	$sopt1 = trim($_POST['sopt']);
	$kopt1 = trim($_POST['kopt']);
	$stop1 = trim($_POST['stop']);
	$kolvo1 = trim($_POST['kolvo']);
	
	$barcode = $barcode1-1;
	$roznica = $roznica1-1;
	$mopt = $mopt1-1;
	$sopt = $sopt1-1;
	$kopt = $kopt1 -1;
	$stop = $stop1 - 1;
	$kolvo = $kolvo1 - 1;
	
	



$file = fopen('uploads/price.csv', 'r');

$clear = array();
while (!feof($file)){
$arr = fgetcsv($file, '', ';', '"' );


$arr['barcode']=$arr[$barcode];
unset($arr[$barcode]);
$arr['roznica']=$arr[$roznica];
unset($arr[$roznica]);
$arr['mopt']=$arr[$mopt];
unset($arr[$mopt]);
$arr['kopt']=$arr[$kopt];
unset($arr[$kopt]);
$arr['sopt']=$arr[$sopt];
unset($arr[$sopt]);
$arr['stop']=$arr[$stop];
unset($arr[$stop]);

$arr2 = array_diff($arr, array(''));


	foreach ($arr2 as $key => $value){
		
$value = iconv('', 'UTF-8', $value);
$clear[$key] = $value;
$value = trim($value);



             



	}
$art=$clear['barcode'];
$rozn=str_replace(',','.',$clear['roznica']);
$m_opt=str_replace(',','.',$clear['mopt']);
$s_opt=str_replace(',','.',$clear['sopt']);
$k_opt=str_replace(',','.',$clear['kopt']);
$stop_opt=str_replace(',','.',$clear['stop']);

$isnum_roznica = is_numeric($rozn);
$isnum_mopt = is_numeric($m_opt);
$isnum_sopt = is_numeric($s_opt);
$isnum_kopt = is_numeric($k_opt);
$isnum_stop = is_numeric($stop_opt);

if ($isnum_roznica==true and $isnum_mopt==true and $isnum_sopt==true and $isnum_kopt==true and $isnum_stop==true){
	
        $import_file = Price::getImport_price($rozn, $art, $m_opt, $s_opt, $k_opt, $stop_opt);

	//if($import_file === true){
	//	echo "<p style= color:green;>артикул ".$art." успешно обновлен".$rozn."</p>";
		
	//} 
	//else{
		
		//echo "артикул Ошибка обновления";
                
	//} 
}
//else {
	
//	echo "Цены не являются числом ".$art."<br/>";
        
//}
}
$price_import_allert = 1;
$price = Price::get_all_cat();
$prod = Price::get_all_product();
include __DIR__. '/../views/price.php';



      
      
      
  }
}
