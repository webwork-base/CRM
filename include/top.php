<?php echo
"

<div class =\"str\" style =\" background-color: #fbfcd4\" >
<div class=\"strcon_name_select\"><b>Сортировать по:</b></div>
<div class=\"strcon_select\">

<form action=\"index.php\" method=\"POST\">
  <select size=\"1\" name=\"selvar\"> 
                                 <option value=\"Не сортировать\">---Не сортировать---</option>
                              <option value=\"По имени\">По имени</option>
                               <option value=\"По организации\">По организации</option>



</select> 
<div class=\"strcon_tel_sel\"><input type=\"submit\" value=\"сортировать\"></div>
 </form>

  </div>
  <div class=\"strcon_search_2\"><b>Поиск по вашей базе</b></div>
 <div class=\"strcon_search_3\"><form action=\"index.php\" method=\"POST\">
 <input type=\"text\" name=\"search_line\" >
 
 <div class=\"strcon_button_search\"><input type=\"submit\" value=\"искать\"></div>
 </form></div>
</div>


<div class=\"str\" style =\" background-color: #fbfcd4\">

<div class=\"strcon_edit\"></div>
<div class=\"strcon_n\"><b>ID</b></div>
<div class=\"strcon_name\"><b>Имя</b></div>
<div class=\"strcon_org\"><b>Организация</b></div>
<div class=\"strcon_tel\"><b>Телефон</b></div>
<div class=\"strcon_men\"><b>E-mail</b></div>
<div class=\"strcon_list\">L</div>
<div class=\"strcon_komm\"><b>Комментарий</b></div>
<div class=\"strcon_date\"><b>Дата</b> </div>
<div class=\"strcon_delete\"></div>
</div>";
?>
