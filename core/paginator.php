<?php
function __autoload($class_name)
{
    include $class_name . '.php';
}

//pagination call

$workWithFiles = new WorkWithFiles();

$page = $_POST['page'];
$workWithFiles->changeHost();
$workWithFiles->limitFromDB($page);