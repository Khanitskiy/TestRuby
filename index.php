<?php
header('Content-Type: text/html; charset=utf-8');
@session_start();
error_reporting(1);

/* Config */
include './config.php';
	
/* Function */
include './function.inc';

if($link = mysqli_connect(Core::$DB_LOCAL, Core::$DB_LOGIN, Core::$DB_PASS, Core::$DB_NAME)) {
    mysqli_set_charset($link, 'utf8');
} else {
    echo 'Ошибка соеденения';
}

$user = new Users;

if (!$user->isAuth()) {
    include 'controllers/loginController.php';
} else {
    
    if(isset($_POST['ajax']) && $_POST['ajax'] == true) {
        
        switch ($_POST["page"]) {
            case  "project":
                include 'controllers/projectController.php';
                break;
            case "task":
                include 'controllers/taskController.php';
                break;
            }
            
    } else {
        
        if($_GET["page"] == 'logout') {
            unset($_SESSION["user"]);
            session_destroy();
            header('Location: /');
            exit();
        }
        
        include 'controllers/accountController.php';
    }
}
/* View */
    include 'views/'.$Page;
?>
