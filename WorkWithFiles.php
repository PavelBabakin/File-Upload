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

    //insert data to DB
    public function insert()
    {
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die("Error " . mysqli_error($link));
        if (!empty($_FILES)) {
            $uploaddir = __DIR__ . '/temp/';
            $uploadfile = $uploaddir . basename($_FILES['filename']['name']);
            if (copy($_FILES['filename']['tmp_name'], $uploadfile)) {
                $name = $_FILES['filename']['name'];
                $size = $_FILES['filename']['size'];
                $type = $_FILES['filename']['type'];
                $path = $uploaddir . $name;
                $insert_query = "INSERT INTO files (name , size, type, tmp_name)" .
                    "VALUES('$name', '$size', '$type', '$path')";
                mysqli_query($link, $insert_query) or die("Can't write to db" . mysqli_error($link));
            }

            ?>
            <div class="container">
            <div class="table-responsive">
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
                    $reverse = $this->getFiles();
                    $reverse = array_reverse($reverse);
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
                            <td class="delete">
                                <button class="delete btn btn-primary"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            </div>
            <?php
        }
    }

    //show files in DB when start a site
    public function getFiles()
    {
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die("Error " . mysqli_error($link));
        $show_query = "SELECT * FROM files";
        $result = mysqli_query($link, $show_query) or die("Error " . mysqli_error($link));
        return $result->fetch_all();
    }

    //show files in DB when start a site if theire in
    public function show()
    {
        ?>
        <div class="container">
        <div class="table-responsive">
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
                $reverse = $this->getFiles();
                $reverse = array_reverse($reverse);
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
        </div>
        </div>
        <?php
    }

    //show empty table if DB is empty
    public function showEmpty()
    { ?>
        <div class="container">
        <div class="table-responsive">
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
        </div>
        </div>
    <?php }

    //delete data from DB
    public function delete($id)
    {
        $id = $_POST['id'];
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db) or die("Error " . mysqli_error($link));
        $delete_query = "DELETE FROM files WHERE id='{$id}'";
        $result = mysqli_query($link, $delete_query) or die("Error " . mysqli_error($link));

        $count_query = "SELECT id FROM files";
        $res = mysqli_query($link, $count_query)->fetch_all();

        if (!count($res)) {
            $this->showEmpty();
        } else {
            if ($result) {
                echo 'true';
            } else {
                echo 'false';
            };
        };
    }

}
