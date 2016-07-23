<?php
function __autoload($class_name)
{
    include $class_name . '.php';
}
$workWithFiles = new WorkWithFiles();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
    <link rel="stylesheet" href="style.css">
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="script.js"></script>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="filename">
    <input type="submit" value="Upload">
</form>
<div id="wrapper">
<?php

$fetch = $workWithFiles->getFiles();
if (($fetch != NULL && !empty($_FILES)) || (empty($fetch) && !empty($_FILES))) {

    $workWithFiles->insert();

}

if ($fetch == NULL && empty($_FILES)) {

    $workWithFiles->showEmpty();

}

if ($fetch != NULL && empty($_FILES)) {

    $workWithFiles->show();

}
?>
</div>
</body>
</html>
