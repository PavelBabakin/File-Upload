<?php
function __autoload($class_name)
{
    include $class_name . '.php';
}
//upload method
$workWithFiles = new WorkWithFiles();
$workWithFiles->changeHost();
$page = $_POST['page'];
$workWithFiles->insert($page);