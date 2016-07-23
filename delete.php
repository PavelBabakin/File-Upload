<?php
function __autoload($class_name)
{
    include $class_name . '.php';
}

$workWithFiles = new WorkWithFiles();

$id = $_POST['id'];

$workWithFiles->delete($id);