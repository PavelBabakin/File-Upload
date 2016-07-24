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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="script.js"></script>
</head>
<div class="container" id="formControl">
    <form role="form" class="form-inline" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control" type="file" name="filename">
            <button class="form-control btn btn-success" type="submit"><i class="glyphicon glyphicon-send"></i> Upload
            </button>
        </div>
    </form>
</div>
<div class="container">
    <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar"  aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<body>
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
