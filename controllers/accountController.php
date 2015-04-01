<?php

$account = new Account;

$result = $account->getProjects($_SESSION['user']['id']);

foreach ($result as $key=>$value) {
    $result[$key]['tasks'] = $account->getTasks($value['id']);
}

//debug($result, 0);

$Page = 'account.php';