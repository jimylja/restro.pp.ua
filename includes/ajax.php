<?php 
require_once('functions.php'); 
$page = route(1);
$db=db_connect();

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if(isset($_POST)){
  if($_POST["function"]){
    $action=$_POST["function"];
    $answer=[];
      switch($action){
        case 'login':
          $login = clearStr($_POST['login']);
				  $password = clearStr($_POST['password']);
				  if(strlen($login) > 3 && strlen($password) > 2){
					if(login($db, $login, $password)){
            $answer['logined']=true;
            $answer['cart']='cart';
            //header("location: /");
					}else{
            $answer['logined']=false;
            //print 'Логін/Пароль неправильні';
					}
        }
        //  echo $response;
        break;
        case 'cartAdd':
          add_to_cart($_POST['productId']);
          $answer['cartAdd']=$_POST['productId'];
          break;
        case 'cartDelete':
          $answer['cartDelete']=$_POST['productId'];
          break;
        case 'getProducts':
          if (isset($_POST['category'])) { $params['category']=$_POST['category'];}
          if (isset($_POST['kitchen'])) { $params['kitchen']=$_POST['kitchen'];}
          if(isset($params) && count($params)) {
            $dishes=get_all_dishes($db, $params);
            foreach ($dishes as $key => $dish) {
                // $temp['id']='25';
                $temp["id"] = $dish['ID'];
                $temp["title"] = $dish['title'];
                $temp['price'] = $dish['price'];
                $temp["category"] = $dish['category'];
                $temp["kitchen"]  = $dish['kitchen'];
                $temp["image"]  = $dish['image'];
              $answer[$key]=$temp;
            }
          }
          
            

          // get_all_dishes($db, $params)
          // $answer['getProducts']=$_POST['productId'];
          break;    
        default:
          echo $action;          
      }	
      $response=json_encode($answer);
      echo ($response);			  
      
  }
}