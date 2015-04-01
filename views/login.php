<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>TODO LIST</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="/style/bootstrap.css">
        <link rel="stylesheet" href="/style/bootstrap-theme.css">
        <link type="text/css" rel="stylesheet" href="style/default.css" />
        <script src="/script/jquery-1.11.2.min.js"></script>
        <script src="/script/bootstrap.js"></script> 
        <script>
            $(document).delegate("#reg", "click", function () {
                $(".reg_block").show();
                $(".auth_block").hide()
            })
            
            $(document).delegate("#auth", "click", function () {
                $(".auth_block").show()
                $(".reg_block").hide();
            })  
        </script>
    </head>
    <body>
        <div class="auth_block" <?= !$form ? 'style="display: blok"' : 'style="display: none"' ?>>
            <h4>Авторизируйтесь</h4>
            <form method="post">
                <input type="hidden" name="auth" value="true">
                <input type="text" class="form-control log_input" name="login" placeholder="Логин">
                <input type="password" class="form-control log_input" name="password" placeholder="Пароль">
                <a href="javascript:void(0)" id="reg" >Зарегестрироваться</a>
                <input type="submit" class="btn btn-default" name="submit" value="Войти" id="auth_submit">
                <div class="error"><?php if(isset($error['auth'])) { echo $error['auth'];}  ?></div>
            </form>
        </div>
        <div class="reg_block" <?= $form ? 'style="display: blok"' : 'style="display: none"' ?>>
            <h4>Заполните все поля</h4>
            <form method="post">
                <input type="hidden" name="reg" value="reg">
                <input type="text" class="form-control log_input" name="login" placeholder="Ваш логин">
                <input type="password" class="form-control log_input" name="password" placeholder="Ваш пароль">
                <a href="javascript:void(0)" id="auth" >Авторизироваться</a>
                <input type="submit" class="btn btn-default" name="submit" value="Отправить" id="reg_submit">
                <div class="error"><?php if(isset($error['reg'])) { echo $error['reg'];}  ?></div>
            </form>

        </div>
        <div class="reg_answer <?php if(!$registraited) echo 'display_none'; ?>">
                <h3>Вы успешно зарегестрированны! <a href="/index.php">Авторизируйтесь</a></h3>
        </div>
    </body>
</html>