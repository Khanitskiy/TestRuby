<?php

if(isset($_POST['submit'])) {
	
        if($_POST['reg']) {
            
            if($_POST['login'] !== '' && $_POST['password'] !== '') {

                $login    = htmlspecialchars($_POST['login']);
                $password = myHash($_POST['password']);

                $result = $user->chek_login($login);

                if(!$result) {

                        $result = $user->add_user($login, $password, $user_type);
                        $result ? $registraited = true : $registraited = false;
                        
                } else {
                        $error['reg'] = 'Такой логин уже существует';
                }
                
            } else {
                    $error['reg'] = 'Вы не ввели Логин или пароль';
            }
            
            $form = 1;
            
        } elseif ($_POST['auth']) {
            
            if($_POST['login'] !== '' && $_POST['password'] !== '') {
		$login    = htmlspecialchars($_POST['login']);
		$password = myHash($_POST['password']);
		
		$result = $user->check_user($login, $password);
		
		if($result) {
			$_SESSION['user'] = $user->get_user($login);
			header("Location: /");
			exit();
		} else {
			$error['auth'] = 'Не верный логин или пароль';
		}
		
            } else {
                    $error['auth'] = 'Вы не ввели Логин или пароль';
            }
            
            $form = 0;
        }
}

$Page = 'login.php';