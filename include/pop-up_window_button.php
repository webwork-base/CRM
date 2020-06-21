<?php

 // Получаем колличество символов в комментарии, если их больше 26 выводим комментарий в всплывающем окне
$comment_upd = $buer -> comment;
    if (iconv_strlen($buer -> comment,'UTF-8') > 26)
{
	$buer -> comment = "<a href=\"#win".$buer->id.$buer ->manager."\" class=\"button button-green\">Открыть комментарий</a>
<a href=\"#x\" class=\"overlay\" id=\"win".$buer->id.$buer ->manager."\"></a>
 <div class=\"popup\">
".$buer -> comment."
<a class=\"close\" title=\"Закрыть\" href=\"#close\"></a>
     
	 </div>";
}
else {      }


// Получаем колличество символов в email, если их больше 5 выводим email в всплывающем окне
$email_upd = $buer ->email;
if (iconv_strlen($buer -> email,'UTF-8') > 5){
$buer -> email = "<a href=\"#win2".$buer->id.$buer ->manager."\" class=\"button button-blue\"><b>@</b></a>
<a href=\"#x\" class=\"overlay\" id=\"win2".$buer->id.$buer ->manager."\"></a>
 <div class=\"popup\">
".$buer -> email."
<a class=\"close\" title=\"Закрыть\" href=\"#close\"></a>
     
	 </div>";
}
else {$buer -> email = "<div class=\"mail_empty\">@</div>";}



if ($buer ->list == "обычный покупатель"){
	$listimg = "<img src=\"img/rabcon.png\" width=\"20\" height=\"20\">";
	}
	elseif ($buer ->list == "черный список"){
	$listimg = "<img src=\"img/blacklist.png\" width=\"20\" height=\"20\" >";
	}
	elseif ($buer ->list == "строитель или прораб"){
	$listimg = "<img src=\"img/work.png\" width=\"20\" height=\"20\" >";
	}
	elseif ($buer ->list == "постоянный покупатель"){
	$listimg = "<img src=\"img/vip.png\" width=\"20\" height=\"20\" >";
	
	}
	elseif ($buer ->list == "крупный оптовик"){
	$listimg = "<img src=\"img/love.gif\" width=\"20\" height=\"20\" >";
	
	}
	elseif ($buer ->list == "перевозчик"){
	$listimg = "<img src=\"img/deliveri.png\" width=\"20\" height=\"20\" >";
	
	}
	elseif ($buer ->list == "продавец"){
	$listimg = "<img src=\"img/trader.png\" width=\"20\" height=\"20\" >";
	
	}
	elseif ($buer ->list == "новая почта"){
	$listimg = "<img src=\"img/newpost.png\" width=\"20\" height=\"20\" >";
	
	}
	elseif ($buer ->list == "производитель"){
	$listimg = "<img src=\"img/proizvod.png\" width=\"20\" height=\"20\" >";
	
	}
	else { 
	}


if ($buer ->polcen == "стоп"){
    $color_polcen = '#ffb3b3';
}
elseif ($buer ->polcen == "розница"){
   $color_polcen = '#b3ff99';
}
elseif ($buer ->polcen == "мелкий опт"){
   $color_polcen = '#99c2ff';
}
elseif ($buer ->polcen == "крупный опт"){
   $color_polcen = '#ffff80';
}
else { $color_polcen = '#d6d6c2'; }