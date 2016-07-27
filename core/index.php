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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../libraries/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <script rel="stylesheet" href="../libraries/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="../libraries/jquery-3.1.0.js"></script>
    <script src="../libraries/jQuery-File-Upload/jquery.ui.widget.js"></script>
    <script src="../libraries/jQuery-File-Upload/jquery.iframe-transport.js"></script>
    <script src="../libraries/jQuery-File-Upload/jquery.fileupload.js"></script>
    <script src="../js/script.js"></script>
</head>
<div class="container" id="formControl">
    <form id="form" class="form-inline" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control" id="kakoito" type="file" name="filename" data-url="upload.php">
            <button id="btnUpload" class="form-control btn btn-success" type="submit"><i class="glyphicon glyphicon-send"></i> Upload
            </button>
            <div class="clearfix"></div>
            <div class="loader"></div>
        </div>
    </form>
    <div id="progressBar" class="progress">
        <div id="progressbar" class="progress-bar progress-bar-striped active" role="progressbar"  style="width: 0%">
        </div>
    </div>
</div>
<body>
<div id="wrapper">

    <div class="container">
        <div id="tableResults" class="table-responsive">
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
</div>
</div>
</body>
</html>
