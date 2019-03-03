<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

header('Content-Type: text/html; charset=utf-8');
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once(__DIR__ . '/console/src/PhpConsole/__autoload.php'); //console
PhpConsole\Helper::register();
require_once('includes/functions.php'); 
//       PC::debug( array('status' =>array_key_exists('err', $GLOBALS)) );
 
session_start();

$title='Головна';
$GLOBALS['err']=array();	
date_default_timezone_set('Europe/Kiev');
//визначаємо URL сторінки
$page = route(1);
//$ext = route(2);
//підключаємось до б.д.
$db=db_connect();
mysqli_query($db,'SET NAMES utf8'); //UTF-8
//якщо кукі встановлені
if (isset($_COOKIE['id'])){
	$cookie_id = $_COOKIE['id'];
	$cookie_hash = $_COOKIE['hash'];
	$this_id = check($db, $cookie_id, $cookie_hash);
}
else {
	$this_id = 0;
    array_push($GLOBALS['err'], 'Кукі не встановлені');
}

if(!isset($_SESSION['dishes_names_list'])){
	get_dishes_names($db);
}

if(!isset($_SESSION['products_names_list'])){
	get_all_products($db);
}
//$tpl='404';
// визначаємо адресу сторінки на яку зайшов користвуач 
// і формуємо потрібні дані 
	switch($page){
		case 'login':
			$tpl = 'login';
			$title="Вхід";
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$login = clearStr($_POST['login']);
				$password = clearStr($_POST['password']);
				if(strlen($login) > 3 && strlen($password) > 2){
					//print $mail.' '.$password;
					if(login($db, $login, $password)){
						//	header("location: /");
					}else{
						print 'Логін/Пароль неправильні';
					}
				}
			}
			break;
		case 'logout':
			//$tpl = 'main';
			user_logout();
			header("location: /");
			break;
		case 'register':
			$title = "Реєстрація";
			$tpl = 'register';
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$password = clearStr($_POST['password']);
				$login = clearStr($_POST['login']);
				$password_double = clearStr($_POST['password_double']);
				if(!empty($login) && !empty($password) && !empty($password_double)){
					if($password != $password_double){
					}else{
						if(register($db, $login, $password)){
							header('location: /login');
						}else{
							print 'Реєстрація невдала';
						}
					}
				} else {print 'Заповніть усі поля';}
			}
			break;
		case 'user': 
			$tpl = 'user';
			break;
		case 'dish':
			$tpl = 'dish';
			break;
		case 'dishes':
			$tpl = 'dishes';
			break;
		case 'order': 
			$tpl = 'order';
			$title = "Замовлення";		
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id =$_POST['ID'];									//	ід користувача з форми	
			$action = $_POST['action'];							// 	визначаємо яку дію виконати з замовленням					
			if ($action=='add') {add_order($db, $id);}			//	викликаємо дію
				elseif ($action=='remove') {remove_order($db, $id);}
			}	
		break;
		case 'cart':	// для../cart/?add=12 	// дія $action=add		// id страви $id=12
			$id = reset($_GET);
			$title = "Кошик";		
			$action = key($_GET);			
                switch($action){
                    case 'add':
                        //додавання товару в кошик
                        add_to_cart($id);
                        //$tpl = 'main';
                        header("location: /");
                        break;
                    case 'delete':
                        cartDelete($db, $id);
                        header("location: /cart");
                        break;  
                    default:
                        $tpl = 'cart';
                        //відобразити сторінку кошика
                        
                }
			break;

      case 'stock':
            $tpl = 'stock';
            break;
		case 'admin':
			$tpl = 'admin';	
			$title = "Адміністратор";
			$sub_page = route(2);
			$sub_page=strtok($sub_page, '?');
			switch($sub_page){
			case 'orders':
				$title = "Управл. замовл.";
				$id = reset($_GET);
				$action = key($_GET);
				$tpl = 'orders';
				if($_SERVER['REQUEST_METHOD'] == 'POST'){ //підтвердження замовлення
					$_SESSION['id']=$_POST['order_id'];
					$_SESSION['ingradients']=unserialize($_POST['ingradients']); 
					unset($_POST);
					$aсcept=acceptOrder($db, $_SESSION['id']);
					header("location: /admin/orders");
				}
				else{		
			 	switch($action){
				case 'add':
					$aсcept=acceptOrder($db, $id);
					//header("location: /orders");
				break;	
				case 'delete':             
							deleteOrder($db, $id);
          	//$tpl = 'orders';
					//  	header("location: /orders");
				break;

				default:
					$tpl = 'orders';
				}	
			}
			break;

			case 'dishes':
				$tpl='admin_dishes';
				$sub_page_3 = route(3);
				switch($sub_page_3){
				case 'add':
					$tpl='add_dish';
					$title = "Додати нову страву";
					if($_SERVER['REQUEST_METHOD'] == 'POST'){
						if(isset($_POST['add_new_dish'])){
									$new=add_new_dish($db);
						}
					}
				break;
				}


			
				break;
				case 'stock':
					$tpl = 'stock';
				break;
				case 'menu':
					$tpl = 'menu';
				break;
				case 'statistic':
				$tpl = 'statistic';
				$sub_page_3 = route(3);		
				switch($sub_page_3){
					case 'dishes_stat':
					$tpl='dishes_stat';
					$title='Статистика за кількістю замовлень';
					if($_SERVER['REQUEST_METHOD'] == 'POST'){
						if(isset($_POST['product_filter_form'])){
							$products_stats=get_statistic($db, 'dishes');
					}}
					break;

					case 'profit_stat':
					$tpl='profit_stat';
					$title='Статистика за прибутками';	
					if($_SERVER['REQUEST_METHOD'] == 'POST'){
						if(isset($_POST['product_filter_form'])){
							$products_stats=get_statistic($db, 'profit');
					}}
					break;

					case 'stock_stat':
					$tpl='stock_stat';
					$title='Статистика за продуктами';	
					if($_SERVER['REQUEST_METHOD'] == 'POST'){
						if(isset($_POST['product_filter_form'])){
							$products_stats=get_statistic_stock($db);
					}}
					break;

					default:
					$tpl='404';
				}

				//$products_stats=get_products_statistic($db);

				break;
			$action = key(reset($_GET));			
			switch($action){
				case 'add':
					add_to_orders($db, $id);
				case 'delete':		
				break;
				default:
				  $tpl = 'admin';
				 //відобразити сторінку кошика	
			}
					
				break;
				case 'stock':
						//сторінка складу товарів
				break;
				case 'product':
						//сторінка складу товарів
				break;
				default:
					 $tpl = 'admin' ;}
				break;
		default:
		if(empty($page)){$tpl='main';}
			else {$tpl='404';}
			}
//виклик шаблонізатора
include_once(ROOT.'/templates/index.php');
?>
