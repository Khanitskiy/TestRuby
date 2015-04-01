<?php

session_start();

/* Config */
include './_config.php';
	
/* Model */
include './_model.php';

/* Controler */

$model = new Model;

function myHash($var) {
    $salt  = 'skr9';
    $salt2 = 'bnrg';
    $var = crypt(md5($var,$salt),$salt2);
    return $var;
}

if(isset($_GET['ajax']) && $_POST['id']) {
	$result = $model->get_user_ajax($_POST['id']);
	echo json_encode($result);
	exit();
}

if(isset($_GET['exit']) && $_GET['exit'] == true) {
	unset($_SESSION['user']);
	header('Location: /index.php');
	exit();
}

if(isset($_SESSION['user'])) {
	
	$access = $_SESSION['user']['access'];
	
	if(isset($_POST['update']) && $_POST['update'] == 1) {
		
		$user_data['login']      = htmlspecialchars($_POST['login']);
		$user_data['password']   = myHash($_POST['password']);
		$user_data['first_name'] = htmlspecialchars($_POST['first_name']);
		$user_data['last_name']  = htmlspecialchars($_POST['last_name']);
		$user_data['city']       = (int)$_POST['city'];
		
		$result = $model->update_user($user_data);
		
		if($result) {
			$user   = $model->get_user($user_data['login']);
			$cities = $model->get_cities();
		} else {$error = 'Ошибка записи';}
		
		
		if($access > 0) {
			$users = $model->get_users();
		}
		
	} else {
		
		$user   = $model->get_user($_SESSION['user']['login']);
		$cities = $model->get_cities();
		
		if($access > 0) {
			$users = $model->get_users();
		}
		
	}
	
} else {
	header('Location: /index.php');
	exit();
}

/* View */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script src="/jquery-1.11.2.min.js"></script>
		<link type="text/css" rel="stylesheet" href="/style.css" />
		<script>
			$(document).ready(function(){ 
				
				$('.list').hide();
				$('#profile').css("color", "#CCC" );
				
				$('body').delegate('#profile', 'click', function(){
					$('.profile').show();
					$('.list').hide();
					
					$('#list').css("color", "#000" );
					$('#profile').css("color", "#CCC" );
				});
				
				$('body').delegate('#list', 'click', function(){
					$('.profile').hide();
					$('.list').show();
					$('#list').css("color", "#CCC" );
					$('#profile').css("color", "#000" );
				});
				
				$('body').delegate('tr', 'click', function(){
					
					var id = $('> .td_id', this).text()
					
					$.ajax({
						url: '/account.php/?ajax=true',
						type: 'post',
						data:  {id: id},
						success: function(data) {
							var data = jQuery.parseJSON(data);
							$('#tr_'+id+' > .td_first_name').text(data.first_name);
							$('#tr_'+id+' > .td_last_name').text(data.last_name);
							$('#tr_'+id+' > .td_city').text(data.City);
							
						}
					});
				});
				
			});
		</script>
	</head>
	<body>
		<div class="acc_block">
			<div class="menu">
				<?php if($access > 0) { ?>
				<div class="menu-left">
					<a href="javascript:void(0);" id="profile" style="float: left;">Профайл </a>
					<span style="float: left;"> | </span>
					<a href="javascript:void(0);" id="list" style="float: left;"> Список</a>
				</div>
				<?php } ?>
				<div class="menu-right"><a href="/account.php?exit=true">Выйти</a></div>
			</div>
			<div class="profile">
				<h4>Ваши данные</h4>
				<form action="/account.php" method="post">
					<input type="text" name="login" placeholder="Логин" value="<?php if(isset($user['login'])) echo $user['login'] ?>">
					<input type="password" name="password" placeholder="Пароль">
					<input type="text" name="first_name" placeholder="Имя" value="<?php if(isset($user['first_name'])) echo $user['first_name'] ?>">
					<input type="text" name="last_name" placeholder="Фамилия" value="<?php if(isset($user['last_name'])) echo $user['last_name'] ?>">
					<select name="city">
						<option value="0">Выберите город</option>
						<?php foreach($cities as $city) {
							if($user['city'] == $city['id']) {
								echo '<option selected value="'.$city['id'].'">'.$city['City'].'</option>';
							} else {
								echo '<option value="'.$city['id'].'">'.$city['City'].'</option>';
							}
						} ?>
					</select>
					<input type="submit" name="submit" value="Редактировать" id="edit_submit">
					<input type="hidden" name="update" value="1">
				</form>
				<div class="error"><?php if(isset($error)) { echo $error;}  ?></div>
			</div>
		</div>
		<?php if($access > 0) { ?>
			<div class="list" style="width: 800px; margin: 0 auto;">
				<h4>Список пользователей</h4>
				<table border="1" style="width: 800px;">
					<?php foreach($users as $user) {
						echo '<tr class="tr" id="tr_'.$user['id'].'"><td class="td_id">'.$user['id'].'</td><td class="td_login">'.$user['login'].'</td><td class="td_first_name">?</td><td class="td_last_name">?</td><td class="td_city">?</td></tr>';
					} ?>
				</table>
			</div>
			<?php } ?>
	</body>
</html>
