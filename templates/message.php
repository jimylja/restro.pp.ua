<?php 

// system messages template 



$status=(!empty($GLOBALS['err'] ))?'status_bad':'status_good';

$status='status_good';

echo '<div class="system_info '.$status.'">';





echo "Домен:      --> ".ROOT;



echo "<br>Cookie -->";

echo "<strong>CART: </strong>";

if (!empty($_COOKIE['cart'] )) {

print_r (unserialize($_COOKIE['cart']));

//print_r($_COOKIE);

}

echo "<strong>  USER: </strong> (id:".$_COOKIE['id'].') =>'.$this_id['login'];





echo "<br>Шаблон --> <strong>tempates/".$tpl.".php</strong>. (генератор: tempates/index.php)<br>";



/*Масив повідомлень*/

if (!empty($GLOBALS['err'] )) {

	echo "<strong>Помилки</strong>: ";

	print_r(	$GLOBALS['err'] );

}

echo "</br>POST: ";

print_r($_POST);



echo "<a href=\"https://drive.google.com/open?id=0BzOnVqz0EfUCMFJmS3lvbE91S0F1VVBuemdvX3dfT0lEVVlV\"> Структура БД </a>";
echo "<a href='https://restro.pp.ua/MVC.png'>MVC </a>";

echo "</div>";

echo "<div class='switcher'>info</div>";