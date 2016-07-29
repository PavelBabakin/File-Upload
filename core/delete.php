<?php
function __autoload($class_name)
{
    include $class_name . '.php';
}

//delete method

$workWithFiles = new WorkWithFiles();

$id = $_POST['id'];
$workWithFiles->changeHost();
$workWithFiles->delete($id);