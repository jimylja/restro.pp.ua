<?php 
require_once('functions.php'); 
$page = route(1);
$db=db_connect();

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if(isset($_POST)){
  if($_POST["function"]){
    $function=$_POST["function"];
      switch($function){
        case 'login':
          $login = clearStr($_POST['login']);
				  $password = clearStr($_POST['password']);
				  if(strlen($login) > 3 && strlen($password) > 2){
					if(login($db, $login, $password)){
            $answer['logined']=true;
            $answer['cart']='cart';
            $response=json_encode($answer); 

            //header("location: /");
					}else{
            $answer['logined']=false;
            $response=json_encode($answer);
            //print 'Логін/Пароль неправильні';
					}
        }
         echo $response;
        break;
        case 'logout':
        
          break;
        default:
          echo 'error';
      }				  
      
  }
}