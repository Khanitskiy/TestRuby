<?php

$project = new Project;

if($_POST['add']) {
    $name = utf_win($_POST['name']);
    $id_new_project = $project->addProject($_SESSION['user']['id'], $name);
    $result = $project->getNewProject($id_new_project);
    //debug($result , 1);
}

if($_POST['delete']) {
    $id = (int) $_POST['delete_id'];
    $result = $project->deleteProject($id);
    echo $result;
    exit();
}

if($_POST['edit']) {
    $id = (int) $_POST['project_id'];
    $name = utf_win($_POST['name']);
    $result = $project->editProject($id, $name);
    echo $result;
    exit();
}

$Page = 'todo_tamplate.php';