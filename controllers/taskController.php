<?php

$task = new Task;

if($_POST['add']) {
    $name = utf_win($_POST['name']);
    $priority = $task->getHighestPriority();
    ++$priority;
    $id_new_task = $task->addTask($_POST['project_id'], $name, $priority);
    //debug($id_new_task , 1);
    $task = $task->getNewTask($id_new_task);
    //debug($task , 1);
}

if($_POST['delete']) {
    $id = (int) $_POST['task_id'];
    $result = $task->deleteTask($id);
    echo $result;
    exit();
}

if($_POST['multiple_delete']) {
    $id = (int) $_POST['project_id'];
    $form_checkbox = explode('=on&', $_POST['form_checkbox']);
    
    $form_checkbox[count($form_checkbox)-1] = str_replace ( '=on', '', $form_checkbox[count($form_checkbox)-1]);
    $result = $task->multipleDeleteTask($id, $form_checkbox);
    echo $result;
    exit();
}

if($_POST['change']) {
   
    $project_id = carveString($_POST['code'], '-', '%');
    $tasks_bufer = explode( '&' , $_POST['code']);
    
    foreach ($tasks_bufer as $value) {
        $tasks_priority[] = substr($value, strpos($value, '_')+1);
    }
    $project_id = (int) $project_id;
    $tasks_priority = array_reverse($tasks_priority);
    
    $result = $task->changePriority($project_id, $tasks_priority);
    echo $result;
    exit();
}

if($_POST['edit']) {
    $id = (int) $_POST['task_id'];
    $status = (int) $_POST['status'];
    $name = utf_win($_POST['name']);
    $result = $task->editTask($id, $name, $status);
    echo $result;
    exit();
}

$Page = 'task.php';