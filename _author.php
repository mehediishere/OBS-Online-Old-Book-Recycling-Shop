<?php
    include 'db.php';
    session_start();
    $srcOutput = ""; 
    $sid  =  ''; $sauthor =  ''; $sdetails = '';

    if (isset($_POST['save'])) {
        $id =  $_POST['inp1a'];
        $author =  $_POST['inp2a'];

        $a_filename = $_FILES["inp4a"]["name"];
        $a_tempname = $_FILES["inp4a"]["tmp_name"];
        $a_folder = "author/" . $a_filename;
        $details =  mysqli_real_escape_string($conn,$_POST['inp3a']);
        $sql = "INSERT INTO tb_author (id, name, details, image) VALUES ('$id','$author','$details','$a_filename')";

        if (mysqli_query($conn, $sql)) {
            move_uploaded_file($a_tempname, $a_folder);
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> New data added successfully. </div>';
        } else {
            $srcOutput = '<div style="color:red;font-size:10px;"> New data failed to add. </div>';
        }
    }
    elseif (isset($_POST['update'])) {
        $id =  $_POST['inp1a'];
        $author =  $_POST['inp2a'];
        $details =  mysqli_real_escape_string($conn,$_POST['inp3a']);
        $filename2 = $_FILES["inp4a"]["name"];
        $tempname2 = $_FILES["inp4a"]["tmp_name"];
        $folder2 = "author/" . $filename2; //root folder destination
        if (!empty($_FILES["inp4a"]["name"])) {
            $updateSql = "UPDATE tb_author SET name='$author', details='$details', image='$filename2' WHERE id='$id'";
        } else {
            $updateSql = "UPDATE tb_author SET name='$author', details='$details' WHERE  id='$id'";
        }

        if (mysqli_query($conn, $updateSql)) {
            if (!empty($_FILES["inp4a"]["name"])) {
                move_uploaded_file($tempname2, $folder2);
            }
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Data updated successfully. </div>';
        } 
        else {
            $srcOutput = '<div style="color:red;font-size:10px;"> Data failed to update. </div>';
        }
    } 
    elseif (isset($_POST['delete'])) {
        $id  =  $_POST['inp1a'];
        $deleteSql = "DELETE FROM tb_author WHERE id='$id'";
        if (mysqli_query($conn, $deleteSql)) {
            $q1 = "SET @num := 0";
            $q2 = "UPDATE tb_author SET srl = @num := (@num+1)";
            $q3 = "ALTER TABLE tb_author AUTO_INCREMENT = 1";
            mysqli_query($conn, $q1);
            mysqli_query($conn, $q2);
            mysqli_query($conn, $q3);

            $file_to_delete = "author/" . $_SESSION['simage'];
            unlink($file_to_delete);

            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Query successfully executed. </div>';
        } else {
            $srcOutput = '<div style="color:red;font-size:10px;"> Query failed to execute. </div>';
        }
    } 
    elseif (isset($_POST['srcbtn'])) {
        $srcSql = "select * from tb_author where id = '$_POST[srcbox]'";
        $result = mysqli_query($conn, $srcSql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $sid  =  $row['id'];
                $sauthor =  $row['name'];
                $sdetails = $row['details'];
                $_SESSION["simage"] = $row['image'];
            }
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Data Found. </div>';
        } else {
            $srcOutput = '<div style="color:red;font-size:10px;"> No Data Found. </div>';
        }
    }

    if (isset($_POST['tableSrc'])) {
        $var = $_POST['tableSrcBox'];
        $viewSql = "SELECT * FROM tb_author where id LIKE '%$var%' OR name LIKE '%$var%' OR details LIKE '%$var%'";
    } 
    elseif (isset($_POST['ascBtn'])) {
        $viewSql = "SELECT * FROM tb_author ORDER BY srl ASC";
    } 
    elseif (isset($_POST['descBtn'])) {
        $viewSql = "SELECT * FROM tb_author ORDER BY srl DESC";
    } 
    else {
        $viewSql = "SELECT * FROM tb_author ORDER BY srl DESC";
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>OSB</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/materialRippleButton.css">
    <link rel="stylesheet" href="assets/css/adminStyle.css">
    <link rel="stylesheet" href="assets/css/community_single_post.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/imageUpload.css">
    <link rel="stylesheet" href="assets/css/registrationForm.css">
    <link rel="stylesheet" href="assets/css/searchForm.css">
    <link rel="stylesheet" href="assets/css/smoothproducts.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://use.fontawesome.com/ce3b7a5101.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <div class="admin_nav" style="padding: 5px;">
        <h3><i class="fa fa-leanpub"></i>&nbsp;OBS</h3>
    </div>
    <div class="grid-container">
        <div class="admin_nav grid-child" style="height: 100%;">
            <div class="row w-100" style="margin-bottom: -20px;padding-left: 10px;">
                <div class="col-xl-4"><img src="assets/img/avatars/mehedi.jpg"></div>
                <div class="col-xl-8">
                    <p>
                        <strong>Mehedi Hasan</strong><br>
                        <span style="font-size:12px; color:#D6D6D6;">Admin</span> <br>
                        <i class="fas fa-circle mr-2" style="color: var(--teal);font-size: 8px;"></i><span style="font-size:10px;">Online</span>
                    </p>
                </div>
            </div>
            <hr>
            <?php include '_admin_nav.php';?>
            <div class="d-flex justify-content-around footer_side_nav"><a href="#"><i class="fa fa-envelope"></i></a><a href="#"><i class="fa fa-shopping-bag"></i></a><a href="#"><i class="fa fa-cog"></i></a><a href="#"><i class="fa fa-power-off"></i></a></div>
        </div>
        <div class="admin_input">
            <div style="padding: 20px;">
                <form action="" method="POST">
                    <div class="d-block d-flex justify-content-end"><input type="search" name="tableSrcBox" class="w-100 form-control" style="height: 31px;"><button class="btn btn-secondary shadow-none pb-4 mr-4 src_btn_admin" type="submit" name="tableSrc">&nbsp;<i class="fa fa-search"></i></button>
                        <button class="btn btn-dark shadow-none ad_arrow_btn" type="submit" name="ascBtn"><i class="fas fa-angle-up" style="font-size: 20px;"></i></button><button class="btn btn-dark shadow-none ad_arrow_btn" type="submit" name="descBtn"><i class="fas fa-angle-down" style="font-size: 20px;"></i></button>
                    </div>
                </form>
                <div class="table-responsive table-bordered" style="max-height: 500px;">
                    <table class="table table-bordered table-hover table-dark">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Author</th>
                                <th>Details</th>
                                <td>Image</td>
                            </tr>
                        </thead>
                        <tbody class="text-monospace">
                            <?php
                            $result = mysqli_query($conn, $viewSql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $image_src = "author/" . $row['image'];
                            ?>
                                    <tr>
                                        <td><?php echo $row["id"] ?></td>
                                        <td><?php echo $row["name"] ?></td>
                                        <td><?php echo substr($row['details'], 0,150);if(strlen($row['details']) >"150")echo ".."; ?></td>
                                        <td><img src="<?php echo $image_src ?>" class="rounded" height="30" width="30"></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "No results were found!!? ";
                            }
                            // $conn->close();
                            ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <td>ID</td>
                                <td>Author</td>
                                <td>Details</td>
                                <td>Image</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <hr>
            <div>
                <form style="padding: 20px;" action="" method="POST">
                    <div class="d-flex">
                        <input class="form-control w-100" type="search" style="height: 31px;" name="srcbox">
                        <button class="btn btn-secondary shadow-none pb-4 src_btn_admin" type="submit" name="srcbtn">&nbsp;<i class="fa fa-search"></i></button>
                    </div>
                    <?php echo $srcOutput ?>
                </form>
                <form style="padding: 20px;" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="ID" name="inp1a" value="<?php echo "$sid" ?>">
                        <input class="form-control" type="text" placeholder="Author" name="inp2a" value="<?php echo "$sauthor" ?>">
                        <textarea class="form-control" placeholder="Details" rows="5" style="font-size: 12px;" name="inp3a"><?php echo "$sdetails" ?></textarea>
                        <input type="file" name="inp4a" style="margin-top: 10px;"><br>
                        <div class="btn-group" role="group">
                            <button class="btn btn-danger btn-sm shadow-none mr-2" type="submit" name="delete">DELETE</button>
                            <button class="btn btn-info btn-sm shadow-none mr-2" type="submit">RESET</button>
                            <button class="btn btn-warning btn-sm shadow-none mr-2" type="submit" name="update">UPDATE</button>
                            <button class="btn btn-success btn-sm shadow-none" type="submit" name="save">INSERT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/bootstrap-Image-Uploader.js"></script>
    <script src="assets/js/dropdown_search_style.js"></script>
    <script src="assets/js/material-Style-Ripple-Button.js"></script>
</body>

</html>