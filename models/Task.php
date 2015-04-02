<?php

class Task {
    
    public function getHighestPriority() {
        global $link;
        $project_id = (int)$_POST['project_id'];
        $query = "SELECT priority FROM `tasks` WHERE `project_id` = '$project_id'  ORDER BY `priority` DESC LIMIT 1";
        $result = mysqli_query($link, $query);
        $res = mysqli_fetch_assoc($result);
        return $res['priority'];
    }
    
    public function addTask($project_id, $name, $priority) {
        global $link;
        $project_id = (int) $project_id;
        $name = htmlspecialchars($name);
        $query = "INSERT INTO `tasks`(`name`, `project_id`, `priority`, `status`) VALUES ( '$name', $project_id, $priority, 1)";
        $result = mysqli_query($link, $query);
        return mysqli_insert_id($link) ; 
    }
    
    public function getNewTask($id_new_project) {
        global $link;
        $query = "SELECT * FROM `tasks` WHERE `id` = '$id_new_project'";
        $result = mysqli_query($link, $query);
        $res = mysqli_fetch_assoc($result);
        return $res; 
    }
    
    public function deleteTask($id) {
        global $link;
        $query = "DELETE FROM `tasks` WHERE `id` = '$id'"; 
        $result = mysqli_query($link, $query);
        return $result;
    }
    
    public function multipleDeleteTask($id, $form_checkbox) {
        global $link;
        foreach ($form_checkbox as $value) {
            $query = "DELETE FROM `tasks` WHERE `id` = '$value'";
            $result = mysqli_query($link, $query);
        }
        return $result;
    }
    
    public function editProject($id, $name) {
        global $link;
        $name = htmlspecialchars($name);
        $query = "UPDATE `projects` SET `name`= '".$name."' WHERE `id` = '$id'"; 
        $result = mysqli_query($link, $query);
        return $result;
    }
    
    public function getTaskId($id) {
        global $link;
        $query = "SELECT id FROM `tasks` WHERE `project_id` = '$id' ORDER BY `id` DESC";
        $result = mysqli_query($link, $query);
        $mas = array();
        $i = 0;
        while ($res = mysqli_fetch_assoc($result)) {
            $mas[$i] = $res['id'];
            $i++;
        }
        return $mas;
    }
    
    public function changePriority($id, $tasks_priority) {
       global $link; 
       

       foreach ($tasks_priority as $key => $value) {
           $query = "UPDATE `tasks` SET `priority`= '$key' WHERE `id`= '$value' AND `project_id` = '$id'";
           $result = mysqli_query($link, $query);
       }
       return $result;
    }
    
    
    public function editTask($id, $name, $status) {
        global $link;
        $name = htmlspecialchars($name);
        $query = "UPDATE `tasks` SET `name`= '".$name."', `status` = '".$status."' WHERE `id` = '$id'"; 
        $result = mysqli_query($link, $query);
        return $result;
    }

}
