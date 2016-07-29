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
    <link rel="stylesheet" href="../libraries/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../libraries/jquery-3.1.0.js"></script>
    <script src="../libraries/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
</head>
<div class="container" id="formControl">
    <form id="form" class="form-inline" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control" id="kakoito" type="file" name="filename" data-url="upload.php">
            <button id="btnUpload" class="form-control btn btn-success" type="submit"><i
                    class="glyphicon glyphicon-send"></i> Upload
            </button>
            <div class="clearfix"></div>
        </div>
    </form>

    <div id="progressBar" class="progress">
        <div id="progressbar" class="progress-bar progress-bar-striped active" role="progressbar" style="width: 0%">
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="search" class="input-group c-search">
        <input type="text" class="form-control" id="contact-list-search">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-search text-muted"></span></button>
                            </span>
    </div>
</div>
<body>
<div id="wrapper">

    <div class="container">
        <div id="tableResults" class="table-responsive">
            <?php

            $workWithFiles->changeHost();

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
