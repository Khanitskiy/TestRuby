<?php

class Users {

    public function isAuth($redirect = false, $page = "/login.html") {
        if (isset($_SESSION["user"])) {
            return $_SESSION["user"];
        } else {
            return false;
        }
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
}
