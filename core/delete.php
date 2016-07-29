<?php
function __autoload($class_name)
{
    include $class_name . '.php';
}

//delete method

$workWithFiles = new WorkWithFiles();

$id = $_POST['id'];
$page = $_POST['page'];
$workWithFiles->changeHost();
$workWithFiles->delete($id, $page);