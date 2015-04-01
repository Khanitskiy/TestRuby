<?php

class Account {

    public function getProjects($id) {
        global $link;
        $query = "SELECT * FROM `projects` WHERE `user_id` = '".$id."'";
        $result = mysqli_query($link, $query);
        $mas = array();
        while ($res = mysqli_fetch_assoc($result)) {
            $mas[] = $res;
        }
        return $mas; 
    }
    
    public function getTasks($id) {
        global $link;
        $query = "SELECT * FROM `tasks` WHERE `project_id` = '".$id."' ORDER BY `priority` DESC ";
        $result = mysqli_query($link, $query);
        $mas = array();
        while ($res = mysqli_fetch_assoc($result)) {
            $mas[] = $res;
        }
        return $mas; 
    }
    
    function check_user($login, $password) {
        global $link;
        $query = "SELECT * FROM `users` WHERE `login` = '".$login."' && `password` = '".$password."'";
        $result = mysqli_query($link, $query);
        return $result->num_rows;
    }

    function chek_login($login) {
        global $link;
        $query = "SELECT * FROM `users` WHERE `login` = '".$login."'";
        $result = mysqli_query($link, $query);
        return $result->num_rows;
    }
    
    function get_user($login) {
        global $link;
        $query = "SELECT * FROM `users` WHERE `login` = '".$login."'";
        $result = mysqli_query($link, $query);
        return mysqli_fetch_assoc($result);
    }
    
    
    function add_user($login, $password, $user_type) {
        global $link;
        $query = "INSERT INTO `users` SET `login` = '".$login."', `password` = '".$password."'";
            $result = mysqli_query($link, $query);
            return $result;
    }
    
    /*
    public function login($login, $password) {
        $login = pg_escape_string($login);
        $password = md5($password);
        $password = pg_escape_string($password);
        $result = pg_query("SELECT * FROM upr_users WHERE \"login\"='$login' AND \"pass\"='$password'") or DIE(mysql_error());
        if (pg_num_rows($result) != 0) {
            @session_start();
            $res = pg_fetch_assoc($result);
            $_SESSION["login"] = $res["login"];
            $_SESSION["user_id"] = $res["id"];
            $_SESSION["access"] = $res["access"];
            $_SESSION["berth"] = $res["berth"];
            $_SESSION["fio"] = $res["fio"];
            return false;
        } else {
            return true;
        }
    }

    public function logout() {
        //@session_start();
        $_SESSION["login"] = "";
        $_SESSION["user_id"] = "";
        session_destroy();
    }

    public function getUsers($id = null, $name_employee = null) {
        $wh = "";
        if ($id != null) {
            $id = (int) $id;
            $wh = " WHERE upr_users.\"id\"='$id'";
        }
        
        if ($name_employee != null) {
             $wh = "WHERE login ILIKE '%$name_employee%' OR fio ILIKE '%$name_employee%' OR upr_statuses.\"name\" ILIKE '%$name_employee%'";
        }
        $result = pg_query("
                SELECT upr_users.*, upr_statuses.\"name\" AS \"berth_name\"
                FROM upr_users LEFT JOIN upr_statuses ON upr_users.\"berth\"=upr_statuses.\"id\"
                $wh 
                ORDER BY upr_users.\"id\" DESC
                ");
        $mas = array();
        $i = 0;
        while ($res = pg_fetch_assoc($result)) {
            $mas[$i] = $res;
            
            $i++;
        }        
        return $mas;
    }

    public function getUsersBerth() {
        $result = pg_query("
                SELECT *
                FROM upr_statuses WHERE \"group_id\" = 1 ");
        $mas = array();
        $i = 0;
        while ($res = pg_fetch_assoc($result)) {
            $mas[] = $res;
        }
        return $mas;
    }

    public function addUser() {
        global $config;
        if($this->isWasLogin($_POST["user_name"])) {
            return "Данный логин занят";
        }
        if($_POST["password"]=="") {
            return "Введите пожалуйста пароль";
        }
        if($_POST["password"]=="") {
            return "Введите пожалуйста пароль";
        }
        if($_POST["password"]!=$_POST["re_password"]) {
            return "Пароли не совпадают";
        }
        $pasport_1 = $config->uploadDocument("pasport_1", "userfiles/users/");
        $pasport_2 = $config->uploadDocument("pasport_2", "userfiles/users/");
        $pasport_3 = $config->uploadDocument("pasport_3", "userfiles/users/");
        $avatar = $config->uploadPhoto("userfiles/users/", "avatar");

        $_POST["user_name"] = pg_escape_string($_POST["user_name"]);
        $_POST["password"] = md5($_POST["password"]);
        $_POST["berth"] = (int) $_POST["berth"];

        $_POST["fio"] = pg_escape_string($_POST["fio"]);
        $_POST["phone_home"] = pg_escape_string($_POST["phone_home"]);
        $_POST["phone_mob"] = pg_escape_string($_POST["phone_mob"]);
        $_POST["mail"] = pg_escape_string($_POST["mail"]);
        $_POST["addrres_register"] = pg_escape_string($_POST["addrres_register"]);
        $_POST["bank_name"] = pg_escape_string($_POST["bank_name"]);
        $_POST["bank_account"] = pg_escape_string($_POST["bank_account"]);
        $_POST["addrres_live"] = pg_escape_string($_POST["addrres_live"]);
        $_POST["passport_data"] = pg_escape_string($_POST["passport_data"]);                
        $_POST["salary"] = pg_escape_string($_POST["salary"]);
        
        $_POST["date_of_birth"] = Configuration::dateToTimeshtapm($_POST["date_of_birth"]);
        $_POST["start_work"] = Configuration::dateToTimeshtapm($_POST["start_work"]);
        $_POST["fired"] = Configuration::dateToTimeshtapm($_POST["fired"]);
        
        pg_query("
                INSERT INTO upr_users 
                (
                    \"login\", \"pass\", \"berth\",
                    \"fio\", \"phone_home\", \"phone_mob\",
                    \"mail\", \"addrres_register\", \"addrres_live\",
                    \"passport_data\", \"date_of_birth\", \"start_work\",
                    \"fired\", \"salary\", \"bank_name\", \"bank_account\",
                    \"pasport_1\", \"pasport_2\", \"pasport_3\",
                    \"avatar\"                      
                ) VALUES (
                 '{$_POST["user_name"]}', '{$_POST["password"]}', 
                 '{$_POST["berth"]}', '{$_POST["fio"]}',
                 '{$_POST["phone_home"]}', '{$_POST["phone_mob"]}',
                 '{$_POST["mail"]}', '{$_POST["addrres_register"]}',
                 '{$_POST["addrres_live"]}', '{$_POST["passport_data"]}',
                 '{$_POST["date_of_birth"]}', '{$_POST["start_work"]}',
                 '{$_POST["fired"]}', '{$_POST["salary"]}','{$_POST["bank_name"]}',
                 '{$_POST["bank_account"]}', '$pasport_1', '$pasport_2', '$pasport_3', '$avatar' )
                 ");
    }
    
    public function isWasLogin($login, $uid = null) {
        $login = pg_escape_string($login);
        $wh = "";
        if($uid!=null) {
            $uid = (int)$uid;
            $wh = " AND id<>'$uid'";
        }
        $result = pg_query("
                SELECT *
                FROM upr_users
                WHERE login='$login' $wh
                ");
        if(pg_num_rows($result)!=0) {
            return true;
        } else {
            return false;
        }
    }

    public function editUser($uid) {
        global $config;

        $uid = (int) $uid;
        $user = $this->getUsers($uid);

        $pasport_1 = $config->reUploadDocument("pasport_1", "userfiles/users/", $user[0]["pasport_1"]);
        $pasport_2 = $config->reUploadDocument("pasport_2", "userfiles/users/", $user[0]["pasport_2"]);
        $pasport_3 = $config->reUploadDocument("pasport_3", "userfiles/users/", $user[0]["pasport_3"]);
        $avatar = $config->reUploadPhoto($user[0]["avatar"], "userfiles/users/", "avatar");
        
        if($this->isWasLogin($_POST["user_name"], $uid)) {
            return "Данный логин занят";
        }
        
        $_POST["user_name"] = pg_escape_string($_POST["user_name"]);

        $_POST["berth"] = (int) $_POST["berth"];

        $_POST["fio"] = pg_escape_string($_POST["fio"]);
        $_POST["phone_home"] = pg_escape_string($_POST["phone_home"]);
        $_POST["phone_mob"] = pg_escape_string($_POST["phone_mob"]);
        $_POST["mail"] = pg_escape_string($_POST["mail"]);
        $_POST["addrres_register"] = pg_escape_string($_POST["addrres_register"]);
        $_POST["bank_name"] = pg_escape_string($_POST["bank_name"]);
        $_POST["bank_account"] = pg_escape_string($_POST["bank_account"]);
        $_POST["addrres_live"] = pg_escape_string($_POST["addrres_live"]);
        $_POST["passport_data"] = pg_escape_string($_POST["passport_data"]);
        $_POST["date_of_birth"] = Configuration::dateToTimeshtapm($_POST["date_of_birth"]);
        $_POST["start_work"] = Configuration::dateToTimeshtapm($_POST["start_work"]);
        $_POST["fired"] = Configuration::dateToTimeshtapm($_POST["fired"]);
        $_POST["salary"] = pg_escape_string($_POST["salary"]);

        $pass = "";
        if ($_POST["password"] != "") {
            if ($_POST["password"]!=$_POST["re_password"]) {
                return "Пароли не совпадают";
            }
            $_POST["password"] = md5($_POST["password"]);
            $pass = ", \"pass\"='{$_POST["password"]}'";
        }
        pg_query("UPDATE upr_users SET \"login\"='{$_POST["user_name"]}'$pass, 
                 \"berth\"='{$_POST["berth"]}', \"fio\"='{$_POST["fio"]}',
                 \"phone_home\"='{$_POST["phone_home"]}', \"phone_mob\"='{$_POST["phone_mob"]}',
                 \"mail\"='{$_POST["mail"]}', \"addrres_register\"='{$_POST["addrres_register"]}',
                 \"addrres_live\"='{$_POST["addrres_live"]}', \"passport_data\"='{$_POST["passport_data"]}',    
                 \"bank_name\"='{$_POST["bank_name"]}', \"bank_account\"='{$_POST["bank_account"]}',
                 \"date_of_birth\"='{$_POST["date_of_birth"]}', \"start_work\"='{$_POST["start_work"]}',
                 \"fired\"='{$_POST["fired"]}',
                 \"salary\"='{$_POST["salary"]}', \"pasport_1\"='$pasport_1', \"pasport_2\"='$pasport_2', \"pasport_3\"='$pasport_3', \"avatar\"='$avatar' 
                  WHERE \"id\"='$uid'");
    }

    public function delUser($uid) {
        $uid = (int) $uid;
        pg_query("DELETE FROM upr_users WHERE \"id\"='$uid'");
    }

    public static function getPhoto($photo) {
        if (is_file("userfiles/users/" . $photo)) {
            return "/userfiles/users/" . $photo;
        } else {
            return "/userfiles/users/No_photo.jpg";
        }
    }
    
    public function getMailFromId($user_id) {
        $user_id = (int)$user_id;
        $result = pg_query("SELECT \"mail\" FROM upr_users WHERE \"id\"='$user_id'");
        $res = pg_fetch_assoc($result);
        return $res["mail"];
    }
     */

}
