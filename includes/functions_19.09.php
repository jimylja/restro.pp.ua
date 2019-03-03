<?php


// підключення до бд
function db_connect(){
    //$connection = mysqli_connect('localhost', 'zosh3162_restro', 'w+6L3V2{2)MF');
    //return mysqli_select_db($connection, 'zosh3162_restro');  
 $db=mysqli_connect("localhost:3306", "zosh3162_restro", "w+6L3V2{2)MF", "zosh3162_restro"); 
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
        setcookie("id", $data['id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true); // httponly !!!
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

     //   $password=$password;
     //   $login=$login;

       // $email = $pdo->quote($email);
        $err = [];
        $password = md5(md5(trim($password)));
        //$password = md5($password);
        
        // перевірка логіну
    if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
    {
        $err[]="Логін має складатись тільки з букв лат. алфавіту";    
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[]="Довжина логіну від 3 до 30 символів";
    }

    $query = mysqli_query($db, "SELECT id FROM users WHERE login='".mysqli_real_escape_string($db, $login)."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[]="Логін уже зайнятий";
        array_push($GLOBALS['err'], "Логін уже зайнятий");
    }

    if(count($err) == 0)
    {
       // $login = $_POST['login'];
       // $password = md5(md5(trim($_POST['password'])));

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
             $sql = "SELECT hash, login FROM users WHERE id='".$cookie_id."'";
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
                          'login' => $row['login']
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
    return $request[$item];
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