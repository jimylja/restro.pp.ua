<?php

// підключення до бд
function db_connect(){
$db=mysqli_connect("localhost", "zosh3162_restro", "w+6L3V2{2)MF", "zosh3162_restro", 3306);    
//$db=mysqli_connect("85.10.205.173", "zosh3162_restro", "w+6L3V2{2)MF", "zosh3162_restro", 3306); 
 return $db;
}


function login($db, $login, $password){
     // Вытаскиваем из БД запись, у которой логин равняеться введенному
        $login = $login;
//        $password = md5($password);
        $password = md5(md5(trim($password)));
        $sql = "SELECT id, password FROM users WHERE login='".$login."' ";
        $query = mysqli_query($db,$sql);
        $data = mysqli_fetch_assoc($query);
     // Сравниваем пароли
    if($data['password'] === $password)

    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));
        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($db, "UPDATE users SET hash='".$hash."' WHERE id='".$data['id']."'");
        // Ставим куки
        setcookie("id", $data['id'], time()+60*60*24*30,'/','restro.pp.ua');
        setcookie("hash", $hash, time()+60*60*24*30,'/','restro.pp.ua',null,true); // httponly !!!
        return true;
    }
    else

    {
        array_push($GLOBALS['err'], "Неправильний логін/пароль");
        return false;
    }

}





// Регистрация

    function register($db, $login, $password){

    // $password=$password;
    // $login=$login;
       // $email = $pdo->quote($email);
        $err = [];
        $password = md5(md5(trim($password)));
        //$password = md5($password);    
        // перевірка логіну
PC::debug(array('password' => $password));
PC::debug(array('login' => $login));
$hash = md5(generateCode(10));
    if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
    {
        $err[]="Логін має складатись тільки з букв лат. алфавіту";    

    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)

    {
        $err[]="Довжина логіну від 3 до 30 символів";
    }


    mysqli_query($db,"INSERT INTO users SET login='".$login."', password='".$password."', hash='".$hash."', role='0' ");

    if(mysqli_num_rows($query) > 0)

    {

        $err[]="Логін уже зайнятий";

        array_push($GLOBALS['err'], "Логін уже зайнятий");

    }



    if(count($err) == 0)

    {

        $login = $_POST['login'];

        $password = md5(md5(trim($_POST['password'])));

        mysqli_query($db,"INSERT INTO users SET login='".$login."', password='".$password."'");

        return true;

    }

    else

    {

      array_push($GLOBALS['err'], $err);

      return false;

    }

}







//перевірка авторизації --> повертає хеш користувача

function check($db, $cookie_id, $cookie_hash){       

        if(empty($cookie_id) || empty($cookie_hash)){

            return 0;

        } else {

             $sql = "SELECT hash, login, role FROM users WHERE id='".$cookie_id."'";

            if(!$query = mysqli_query($db, $sql)){

                return 0;

            } else {

                $row = mysqli_fetch_assoc($query);

                if(!$row){

                    return 0;

                } else {

                    $db_hash = $row['hash'];

                    if($cookie_hash == $db_hash){

                        $answer=[

                          'id' => $row['hash'],

                          'login' => $row['login'],

						  'role' => $row['role']

                        ];

                        return $answer;

                    }

                    return 0;

                }

            }

        }

    }







//отримання Url сторінки

function route($item = 1) {

    $request = explode("/", $_SERVER["REQUEST_URI"]);

    $request = isset($request[$item])?$request[$item]:null;

    return $request;

}





//очистити текст від пробілів і html

function clearStr($str){

    return trim(strip_tags($str));}



//очистити html

function clearHTML($html){

    return trim(htmlspecialchars($html));

}





// генерація hash рядка

function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}



function get_user_name($this_id) {
    $sql = "SELECT login FROM users WHERE id='".$cookie_id."'";
}

function user_logout(){
    setcookie('id', null, -1,'/','restro.pp.ua');
	setcookie('hash', null, -1,'/','restro.pp.ua');
	unset($_COOKIE['id']);
	unset($_COOKIE['hash']);	
	return true;
}





function getDishes($db){
    //$sql = "SELECT * FROM dishes";
	$now = date('Y-m-d');
	$sql = "SELECT dishes.id, title, image, categories.name, kitchens.name, price FROM dishes
	INNER JOIN categories ON categories.id=dishes.category
	INNER JOIN kitchens ON kitchens.id=dishes.kitchen
	INNER JOIN menus ON (menus.menu_date='".$now."' AND FIND_IN_SET(dishes.id, menus.menu_list))";
    $dishes = mysqli_query($db, $sql);
    	return $dishes;
}

function get_all_dishes($db){
    $sql = "SELECT dishes.id, title FROM dishes";
	$dishes = mysqli_query($db, $sql);
    return $dishes;
}




function add_to_cart($id){
	if (!empty($_COOKIE['cart'])){
		$cart= unserialize($_COOKIE['cart']);
		if (array_key_exists($id, $cart)) {$cart[$id]++;}
			else {$cart[$id]=1;}
		setcookie('cart', serialize($cart), time()+60*60*24*1, '/');					
			}
	else{
		$cart[$id]=1;
		setcookie('cart', serialize($cart), time()+60*60*24*1, '/');			
		}			
}



function cartDelete($db, $id){
    if (!empty($_COOKIE['cart'])){
        if ($id=='all'){                        //очистити всю корзину
            setcookie('cart', null, -1, '/');
            unset($_COOKIE['cart']);}
            else {
        $cart= unserialize($_COOKIE['cart']);
        if (array_key_exists($id, $cart)) {
            unset($cart[$id]);
            if( !empty($cart) ) {setcookie('cart', serialize($cart), time()+60*60*24*1, '/');}
                else {    
                    setcookie('cart', null, -1, '/');
                    unset($_COOKIE['cart']);
                    }
        }
        else {array_push($GLOBALS['err'], 'Delete from cart: товар в корзині відсутній');}                    
          }
    }
    else{array_push($GLOBALS['err'], 'Delete from cart: кукі відсутні');}           
}





function get_cart_count(){
	$count=0;
	if (!empty($_COOKIE['cart'])){
		$cart_items= unserialize($_COOKIE['cart']);
		foreach ($cart_items as $key => $value) {
			$count+=$value;
		}
	}
	return $count;
}



function fixPrice($price){
    $fixed_price = strval($price);
    return $fixed_price;
}





function getCart($db){
	$cart= unserialize($_COOKIE['cart']);
	$items = array_keys($cart);	//	получити ключі масиву, тобто id товарів
	$comma_separated = implode(",", $items); //утворюємо рядок значень розділеним комою
	$sql = 'SELECT * FROM dishes WHERE id IN ('.$comma_separated.')';
    $cart = mysqli_query($db, $sql);
   	return $cart;
}



function add_order($db, $id){
	$cart_items=getCart($db);
	$order_list=''; 
	$order_price=$_POST['order_price'];
    $order_place = $_POST['place'];
    $i=0;
	foreach ($_POST['items'] as $dish => $count) { 
        $order_list.=($i==0)?'"'.$dish.'":'.$count:',"'.$dish.'":'.$count;
        $i++;
    }	
	array_push($GLOBALS['err'], $order_list);
	$sql="INSERT INTO orders(users_id, order_list, order_price, order_location, status) VALUES (".$id.", '".$order_list."', '".$order_price."', '".$order_place."', 0)";
	array_push($GLOBALS['err'], $sql);
	$result=mysqli_query($db, $sql);
	cartDelete($db, 'all');
}



function getOrders($db){
    $query= "SELECT * FROM orders;";
	$result=mysqli_multi_query($db, $query);	
    $orders = mysqli_store_result($db); 
    return $orders;
}



function getStock($db){
	$sql = "SELECT stock.st_id, products.title, stock.pull_date, stock.quantity, products.edibility FROM stock
	INNER JOIN products ON products.pr_id=stock.product";
	$stock = mysqli_query($db, $sql);
	return $stock;
}



function getMenu($db){
	$sql = "SELECT * FROM menus";
	$menus = mysqli_query($db, $sql);
	return $menus;
}

function deleteOrder($db, $id){
    $query = "DELETE FROM orders WHERE id = '$id'";
    mysqli_query($db, $query);
}

function get_kitchens($db){
    $query="SELECT * FROM kitchens";
    $kitchens=mysqli_query($db, $query);
    return $kitchens;
}

function get_categories($db){
    $query="SELECT * FROM categories";
    $categories=mysqli_query($db, $query);
    return $categories;
}

function get_all_products($db){
    $query="SELECT * FROM products";
    $products=mysqli_query($db, $query);
    $products_names_list=[];
    foreach ($products as $key => $value) {
        $products_names_list[$value['pr_id']]=$value['title'];
    }
    $_SESSION['products_names_list']=$products_names_list;
}

//получити сумарну кількість продуктів на складі
function get_stock_summary($db){
    $sql = "SELECT product, products.title, SUM(quantity) AS total_quantity 
        FROM stock
        INNER JOIN products ON products.pr_id=stock.product  
        GROUP BY product;";  
    $stock_summary=[];
    $result=mysqli_multi_query($db, $sql);	// виконуємо запит в бд
    $stock_summary=[];
    do {
    if ($res = mysqli_store_result($db)) {
        foreach ($res as $product => $total) {
          $current_array = array('title'=>$total['title'], 'quantity' => $total['total_quantity']);		
          $stock_summary[$total['product']]=$current_array;	    
             }
    }
    } 
    while (mysqli_more_results($db) && mysqli_next_result($db));
    return $stock_summary;
}


function get_dishes_array($order_list){
    $ob=json_decode('{'.$order_list.'}');           //рядок з замовленнями представити у вигляді JSON
    $dishes_array = (array)$ob;                     
    $dishes_array = array_combine(array_keys($dishes_array), array_values($dishes_array));  //об'єднати масиви
    return $dishes_array;
}

function get_dishes_names($db) {
    $sql="Select * FROM dishes";
    $dishes_names= mysqli_query($db, $sql);
    $dishes_names_list=[];
    foreach ($dishes_names as $key => $value) {
        $dishes_names_list[$value['ID']]=$value['title'];
    }
    $_SESSION['dishes_names_list']=$dishes_names_list;
}

function add_new_dish($db){
    $title=(isset($_POST['dish_name']))?$_POST['dish_name']:'default';
    $price=(isset($_POST['dish_price']))?$_POST['dish_price']:0;
    $category=(isset($_POST['dish_category']))?$_POST['dish_category']:1;
    $kitchen=(isset($_POST['dish_kitchen']))?$_POST['dish_kitchen']:1;
    $cooking_time=(isset($_POST['cooking_time']))?$_POST['cooking_time']:30;

    $prod=[];
    foreach ($products as $key => $value) {
        $result = strpos($key, 'quantity');
        if ($result===false) {
            $item=$key[0];
            $prod[$value]=$products[$item.'_product_quantity'];
        }    
    }
    PC::debug(array('products' => $prod));

    $sql="INSERT INTO dishes SET title='".$title."', price='".$price."', category='".$category."', kitchen='".$kitchen."', cooking_time='".$cooking_time."';";
    $result=mysqli_multi_query($db, $sql);
    PC::debug(array('products' => $sql));

    $sql2="SELECT id FROM dishes ORDER BY id DESC LIMIT 1";
    $result2=mysqli_multi_query($db, $sql2);
    $query='';
    do {
        if ($res = mysqli_store_result($db)) {
            foreach ($res as $product => $total) {
               PC::debug(array('add' => $total['id']));
               foreach ($prod as $key => $value) {
                   $query.="INSERT INTO recipes SET dish_id='".$total['id'] ."', product_id='".$key."', quantity='".$value."';";
               }
                 }
        }
        }
        while (mysqli_more_results($db) && mysqli_next_result($db));
    mysqli_multi_query($db, $query);        
    PC::debug(array('products' => $query));
    return $prod;
}


//получити сумарну кількість продуктів відповідно до замовлення
function get_order_ingradients($db, $dishes_array){
    $dishes_list=implode(",", array_keys($dishes_array));                                   // сформувати рядок страв
    $sql = "SELECT * FROM recipes WHERE FIND_IN_SET(recipes.dish_id, '".$dishes_list."')";  
    $quant = mysqli_query($db, $sql);
    
    $products_summary=[];   
    foreach ($quant as $dish => $property) {
        if (array_key_exists($property['product_id'], $products_summary)) {$products_summary[$property['product_id']]+=$dishes_array[$property['dish_id']]*$property['quantity'];}
     else {$products_summary[$property['product_id']]=$dishes_array[$property['dish_id']]*$property['quantity']; }   //список і кількість потрібних продуктів що треба взяти зі складу
    }
    $products_id=array_keys($products_summary); 
    return $products_summary;
}

//підтвердити замовлення
function acceptOrder($db, $id){
    if (!isset($_POST['order_id']) || !isset($_POST['ingradients']) ){ 
    $query= "SELECT order_list FROM orders WHERE id='".$id."';";
	$result=mysqli_multi_query($db, $query);	// виконуємо запит в бд
    do {
    if ($res = mysqli_store_result($db)) {
    	$resp=mysqli_fetch_array($res);			//отримаємо масив вигляду: [0]=>"2-1;3-1;"
    }
    } 
    while (mysqli_more_results($db) && mysqli_next_result($db));

$order_list=$resp['order_list'];            // берем строку: 2-1;3-1;
$orders_list = explode(";", $order_list);   // розбиваємо її на масив [2-1][3-1]
$dishes_list='';                            // список страв
$dishes_array=[];	                        // масив замовлених страв
$query = '';
for($i = 0; $i < count($orders_list)-1; $i++){
    $order = explode("-", $orders_list[$i]);            //  формуємо масив [2][3]    
    $dishes_list .= ($i==0)?$order[0]:','.$order[0];    //  формуємо рядок '2,3'    
    $current_array = array($order[0] => $order[1]);		//  елемент асоціативного масиву [2 => 1; 3 =>1]
    $dishes_array=$dishes_array+$current_array;			//  додаємо елемент в масив замовлених страв
}

    $sql = "SELECT * FROM recipes WHERE FIND_IN_SET(recipes.dish_id, '".$dishes_list."')";  //інформація про рецепти замовлених страв 
    $quant = mysqli_query($db, $sql);   
    $products_summary=[];   
foreach ($quant as $dish => $property) {
    $products_summary[$property['product_id']]=$dishes_array[$property['dish_id']]*$property['quantity'];    //список і кількість потрібних продуктів що треба взяти зі складу
}

}
else {

$_SESSION['ingradients']=unserialize($_POST['ingradients']);    
$products_summary=$_SESSION['ingradients'];}
$products_id=array_keys($products_summary); 

   $sql = "SELECT * FROM stock 
            WHERE FIND_IN_SET(stock.product, '".$comma_separated = implode(",", $products_id)."') 
            ORDER BY product, stock.pull_date ASC";  //інформація про рецепти замовлених страв 
$stock = mysqli_query($db, $sql);


$query_res=[];
$query_del=''; $query_upd='';
foreach ($products_summary as $product => $total_quantity){
    $temp_quantity=$total_quantity;
    foreach ($stock as $stock_product => $property) {
        $query_res[$property['product']]=array($property['st_id'], $property['product'], $property['quantity'], $property['pull_date']);       
        if ($product===(integer)$property['product']){
            $temp_quantity = $property['quantity']-$temp_quantity;
            if ($temp_quantity<=0){ 
                $query_del .="DELETE FROM stock WHERE st_id=".$property['st_id'].";";
                $temp_quantity=-$temp_quantity;
                }
                else { 
                    $query_upd.="UPDATE stock SET quantity=".$temp_quantity." WHERE st_id='".$property['st_id']."';" ;
                    $temp_quantity=0;
                }               
            }    
    }
    
if($temp_quantity>0){ return $product;}
}

$query="UPDATE orders SET status='1' WHERE id='".$id."';";
$query.= $query_del.$query_upd;

$result=mysqli_multi_query($db, $query);	// виконуємо запит в бд

 PC::debug(array('query_stock' => $query));
//  PC::debug(array('product_info' => $query_res));

if(isset($_SESSION['ingradients'])) { unset($_SESSION['ingradients']); }
if(isset($_SESSION['id'])) { unset($_SESSION['id']); }

if(!empty($result)){
    return true;
}
}


//STATISTIC: dishes&profit
function get_statistic($db, $type) {
    if ($type=='dishes') {$count='count';}
    if($type=='profit'){$count='count*dishes.price';}
    $end_date=date('Y-m-d');
    $start_date='2017-01-01';
    if(isset($_POST['start_date']) && !empty($_POST['start_date'])){$start_date=$_POST['start_date'];}
    if(isset($_POST['end_date']) && !empty($_POST['start_date'])){$end_date=$_POST['end_date'];}
    
    $dish=(isset($_POST['dish_id']))?$_POST['dish_id']:'default';
    $group_by=(isset($_POST['group_by']))?$_POST['group_by']:'date';
    $response['group_by']=$_POST['group_by'];
    switch ($group_by) {
        case 'day':
            $group='DAYNAME(stats.date)';
        break;
        
        case 'mounth':
            $group='MONTHNAME(stats.date)';
        break;

        default:
            $group='stats.date';
            break;
    }    
    if ($dish=='default') {$dish_query='';}
        else {$dish_query= " AND stats.item_id=".$dish;}     
    $sql="SELECT ".$group." AS date_group, SUM(".$count.") AS total_count 
    FROM stats
    INNER JOIN dishes 
      ON dishes.id=stats.item_id AND stats.item_type='dish'".$dish_query."  
      AND (stats.date BETWEEN '".$start_date."' AND '".$end_date."')
         GROUP BY date_group
         ORDER BY date_group DESC";    
    echo "<br>";
 
    $result=mysqli_query($db, $sql);
    $count = mysqli_num_rows($result); 
    if ($count>0) {
        foreach ($result as $dish => $property) {
        $answer[]=array($property['date_group'], (int)$property['total_count']);
        }
    $answer=json_encode($answer, JSON_UNESCAPED_UNICODE); }
        else {$answer='none';} 
        //   $answer=json_encode($answer, JSON_UNESCAPED_UNICODE); 
    $response['stat_data']=$answer;
    return $response;
}

function get_statistic_stock($db){
    $query= "SELECT product, stock.pull_date AS date_group, SUM(stock.pull_quantity) AS pull_count, SUM(stock.pull_quantity-stock.quantity) AS quantity_count
     FROM stock 
     INNER JOIN products 
     ON products.pr_id=stock.product  
     AND (stock.pull_date BETWEEN '2018-09-01' AND '2018-10-07')
     GROUP BY date_group, stock.product;";

    $result=mysqli_multi_query($db, $query);	// виконуємо запит в бд
     $stock_summary=[];
     do {
     if ($res = mysqli_store_result($db)) {
         foreach ($res as $product => $total) {
              }
     }
     }
     while (mysqli_more_results($db) && mysqli_next_result($db));


    //$order_list=$resp['order_list'];    
    return $data;
}
