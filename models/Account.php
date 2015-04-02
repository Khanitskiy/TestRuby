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
}
