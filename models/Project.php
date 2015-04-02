<?php

class Project {

    public function addProject($user_id, $name ) {
        global $link;
        $name = htmlspecialchars($name);
        $query = "INSERT INTO `projects`(`name`, `user_id`) VALUES ( '$name', $user_id)";
        $result = mysqli_query($link, $query);
        return mysqli_insert_id($link); 
    }
    
    public function getNewProject($id_new_project) {
        global $link;
        $query = "SELECT * FROM `projects` WHERE `id` = '$id_new_project'";
        $result = mysqli_query($link, $query);
        $res = mysqli_fetch_assoc($result);
        return $res; 
    }
    
    public function deleteProject($id) {
        global $link;
        $query = "DELETE FROM `projects` WHERE `id` = '$id'"; 
        $result = mysqli_query($link, $query);
        return $result;
    }
    
    public function editProject($id, $name) {
        global $link;
        $name = htmlspecialchars($name);
        $query = "UPDATE `projects` SET `name`= '".$name."' WHERE `id` = '$id'"; 
        $result = mysqli_query($link, $query);
        return $result;
    }
    
}
