<?php

class WorkWithFiles
{
    //connect to DB
    public $host = 'localhost';
    //public $host = 'http://y990514p.bget.ru/';
    public $user = 'root';
    //public $user = 'y990514p_upload';
    public $pass = '';
    //public $pass = 'babak1nA';
    public $db = 'file_upload';
    //public $db = 'y990514p_upload';
    public $link;

    public function changeHost () {
        if($_SERVER['HTTP_HOST'] != 'localhost') {

             $this->user = 'y990514p_upload';
             $this->pass = 'babak1nA';
             $this->db = 'y990514p_upload';

        }
    }

    //pagination
    public function pagination($page){
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die("Error " . mysqli_error($link));
        $show_query = "SELECT * FROM files";
        $result = mysqli_query($link, $show_query) or die("Error " . mysqli_error($link));
        $cntRows = mysqli_num_rows($result);


        if ($cntRows > 10){

            $cntNumsPagination = floor($cntRows / 10);

            ?>
            <div id="paginator" class="container">
            <ul class="pagination"><?php
                for ($i = 1; $i <= $cntNumsPagination; $i++){
                    if($i == $page) { ?>
                    <li class="active" ><a href="#"><?php echo $i ?></a></li>
                        <?php } else { ?>
                    <li><a href="#"><?php echo $i ?></a></li>
          <?php } } ?>
            </ul>
            </div>
            <?php
        }
    }

    //limitFromDB
    public function limitFromDB($page){
        if ((int)$page > 1){
            $endOffset = ((int)$page * 10) - 1;
            $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die("Error " . mysqli_error($link));
            $show_query = "SELECT * FROM files LIMIT {$endOffset}, 10";
            $result = mysqli_query($link, $show_query) or die("Error " . mysqli_error($link));
            $result = $result->fetch_all();
            $reverse = array_reverse($result);

            $this->render($reverse, $page);
        }else {
            $this->show();
        }
    }

    //insert data to DB
    public function insert($page)
    {
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die("Error " . mysqli_error($link));
        if (!empty($_FILES)) {
            $fileGet = $_FILES[0];
            $uploaddir = '../temp/';
            $uploadfile = $uploaddir . basename($fileGet['name']);
            if (copy($fileGet['tmp_name'], $uploadfile)) {

                $name = $fileGet['name'];
                $size = $fileGet['size'];
                $type = $fileGet['type'];
                $path = $uploaddir . $name;
                $insert_query = "INSERT INTO files (name , size, type, tmp_name)" .
                    "VALUES('$name', '$size', '$type', '$path')";
                mysqli_query($link, $insert_query) or die("Can't write to db" . mysqli_error($link));
            }
            $reverse = $this->getFiles();
            $reverse = array_reverse($reverse);
            $this->render($reverse, $page);
        }
    }

    //show files in DB when start a site
    public function getFiles(){
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die("Error " . mysqli_error($link));
        $show_query = "SELECT * FROM files LIMIT 10";
        $result = mysqli_query($link, $show_query) or die("Error " . mysqli_error($link));
        return $result->fetch_all();
    }

    //show files in DB when start a site if there in
    public function show(){
        $reverse = $this->getFiles();
        $reverse = array_reverse($reverse);
        $this->render($reverse, 1);
    }

    //show empty table if DB is empty
    public function showEmpty()
    { ?>
        <table class="table table-bordered table-striped">
                <tr>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Dir Name</th>
                </tr>

                <tr>
                    <td colspan="4">Table is empty</td>
                </tr>
            </table>
    <?php }

    //delete data from DB
    public function delete($id, $page)
    {
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die("Error " . mysqli_error($link));
        $delete_query = "DELETE FROM files WHERE id='{$id}'";
        $result = mysqli_query($link, $delete_query) or die("Error " . mysqli_error($link));

//        $count_query = "SELECT id FROM files ";
//        $res = mysqli_query($link, $count_query)->fetch_all();
        $res = $this->getFiles();
        $reverse = array_reverse($res);

        if (!count($res)) {
            $this->showEmpty();
        } else {
//            if ($result) {
//                echo 'true';
//            } else {
//                echo 'false';
//            };
            $this->render($reverse, $page);
        };
    }

    //render
    public function render($reverse, $page){
        ?>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Size</th>
                <th>Type</th>
                <th>Dir Name</th>
                <th colspan="2">Actions</th>
            </tr>
            <?php
            foreach ($reverse as $file) {
                ?>
                <tr>
                    <td class="id"><?php echo $file[4]; ?></td>
                    <td><?php echo $file[0]; ?></td>
                    <td><?php echo $file[1]; ?></td>
                    <td><?php echo $file[2]; ?></td>
                    <td><?php echo $file[3]; ?></td>
                    <td>
                        <a class="btn btn-primary" href="/File-Upload/temp/<?php echo $file[0] ?>"><i class="glyphicon glyphicon-download-alt"></i> Download</a>
                    </td>
                    <td>
                        <button class="delete btn btn-primary"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
        $this->pagination($page);
    }

}
