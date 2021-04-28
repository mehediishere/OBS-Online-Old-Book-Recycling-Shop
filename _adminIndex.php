<?php
    include 'db.php';
    session_start();
    $srcOutput=""; $srl="";
    $sbook     =  '';  $sauthor    = '' ; $sisbn      =  ''; $spublisher =  '';  $scategory  = '' ; $sbookstate =  '';
    $sprice     =  ''; $sobprice   =  '';  $sdiscount  = '' ; $squantity  =  ''; $sdetails   =  ''; $sbookcode ='';
    if (isset($_POST['save']))
    {
        $book      =  $_POST['inp1'];  $author    =  $_POST['inp2']; $isbn      =  $_POST['inp3'];
        $publisher =  $_POST['inp4'];  $category  =  $_POST['inp5']; $bookstate =  $_POST['inp6'];
        $price     =  $_POST['inp7'];  $discount  =  $_POST['inp8']; $quantity  =  $_POST['inp9'];
        $bookcode  =  $_POST['inp12']; $details   =  mysqli_real_escape_string($conn,$_POST['inp10']);
        $obprice = $_POST['inp13'];

        $filename = $_FILES["inp11"]["name"];
        $tempname = $_FILES["inp11"]["tmp_name"];
        $folder = "bookcover/" . $filename;

        $sql = "INSERT INTO tb_books (bookid, name, author, isbn, publisher, category, bookstate, price, obprice, discount, quantity, details, image) VALUES ('$bookcode','$book', '$author', '$isbn', '$publisher', '$category', '$bookstate', '$price', '$obprice', '$discount', '$quantity', '$details', '$filename')";
        
        if (mysqli_query($conn, $sql)) 
        {
            move_uploaded_file($tempname, $folder);
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> New data added successfully. </div>';
        }
        else
        {
            $srcOutput = '<div style="color:red;font-size:10px;"> New data failed to add. </div>';
        }
    }
    elseif (isset($_POST['update']))
    {
        $book      =  $_POST['inp1'];  $author    =  $_POST['inp2']; $isbn      =  $_POST['inp3'];
        $publisher =  $_POST['inp4'];  $category  =  $_POST['inp5']; $bookstate =  $_POST['inp6'];
        $price     =  $_POST['inp7'];  $discount  =  $_POST['inp8']; $quantity  =  $_POST['inp9'];
        $details   =  mysqli_real_escape_string($conn,$_POST['inp10']); $bookcode  =  $_POST['inp12']; 
        $obprice     =  $_POST['inp13'];

        $filename2 = $_FILES["inp11"]["name"];
        $tempname2 = $_FILES["inp11"]["tmp_name"];
        $folder2 = "bookcover/" . $filename2; //root folder destination
        // echo "$srl";
        
        if(!empty($_FILES["inp11"]["name"]))
        {
            $updateSql = "UPDATE tb_books SET name='$book', author='$author', isbn='$isbn', publisher='$publisher', category='$category', bookstate='$bookstate', price='$price', obprice='$obprice', discount='$discount', quantity='$quantity', details='$details', image='$filename2' WHERE bookid='$bookcode'";
        }
        else
        {
            $updateSql = "UPDATE tb_books SET name='$book', author='$author', isbn='$isbn', publisher='$publisher', category='$category', bookstate='$bookstate', price='$price', obprice='$obprice', discount='$discount', quantity='$quantity', details='$details' WHERE  bookid='$bookcode'";
        }

        if (mysqli_query($conn, $updateSql)) 
        {
            if(!empty($_FILES["inp11"]["name"]))
            {
                move_uploaded_file($tempname2, $folder2);
            }
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Data updated successfully. </div>';
        }
        else
        {
            $srcOutput = '<div style="color:red;font-size:10px;"> Data failed to update. </div>';
        }
    }
    elseif (isset($_POST['delete']))
    {
        $bookcode  =  $_POST['inp12'];
        $deleteSql = "DELETE FROM tb_books WHERE bookid='$bookcode'";
        if (mysqli_query($conn, $deleteSql)) 
        {
            $q1="SET @num := 0";
            $q2="UPDATE tb_books SET srl = @num := (@num+1)";
            $q3="ALTER TABLE tb_books AUTO_INCREMENT = 1";
            mysqli_query($conn,$q1);
            mysqli_query($conn,$q2);
            mysqli_query($conn,$q3);

            $file_to_delete = "bookcover/".$_SESSION['simage'];
            if($_SESSION['simage'] != NULL) {
                unlink($file_to_delete);
            }

            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Query successfully executed. </div>';
        }
        else
        {
            $srcOutput = '<div style="color:red;font-size:10px;"> Query failed to execute. </div>';
        }
    }
    elseif(isset($_POST['srcbtn']))
    {
        $srcSql = "select * from tb_books where bookid = '$_POST[src1]'";
        $result = mysqli_query($conn, $srcSql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $sbookcode  =  $row['bookid'];    $sbook =  $row['name'];           $sauthor = $row['author']; 
                $sisbn      =  $row['isbn'];      $spublisher =  $row['publisher']; $scategory  = $row['category']; 
                $sbookstate =  $row['bookstate']; $sprice =  $row['price'];         $sdiscount  = $row['discount']; 
                $squantity  =  $row['quantity'];  $sdetails   =  $row['details']; $srl =  $row['srl']; 
                $_SESSION["simage"] = $row['image']; $sobprice =  $row['obprice'];
            }
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Data Found. </div>';
        }else{
            $srcOutput = '<div style="color:red;font-size:10px;"> No Data Found. </div>';
        }
    }

    if(isset($_POST['tableSrc']))
    {
        $var = $_POST['tableSrcBox'];
        $viewSql = "SELECT * FROM tb_books where bookid LIKE '%$var%' OR name LIKE '%$var%' OR author LIKE '%$var%' OR bookstate LIKE '%$var%' OR category LIKE '%$var%'";
    }
    elseif(isset($_POST['ascBtn']))
    {
        $viewSql = "SELECT * FROM tb_books ORDER BY srl ASC";
    }
    elseif(isset($_POST['descBtn']))
    {
        $viewSql = "SELECT * FROM tb_books ORDER BY srl DESC";
    }
    else
    {
        $viewSql = "SELECT * FROM tb_books ORDER BY srl DESC";
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>OBS</title>
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
                        <div class="d-block d-flex justify-content-end">
                            <input type="search" name="tableSrcBox" placeholder="Search using book id, name, author, book state, category..." class="w-100 form-control" style="height: 31px;">
                            <button class="btn btn-secondary shadow-none pb-4 mr-4 src_btn_admin" type="submit" name="tableSrc">&nbsp;<i class="fa fa-search"></i></button>
                            <button class="btn btn-dark shadow-none ad_arrow_btn" type="submit" name="ascBtn"><i class="fas fa-angle-up" style="font-size: 20px;"></i></button>
                            <button class="btn btn-dark shadow-none ad_arrow_btn" type="submit" name="descBtn"><i class="fas fa-angle-down" style="font-size: 20px;"></i></button>
                        </div>
                    </form>
                    <div class="table-responsive table-bordered" style="max-height: 500px;">
                        <table class="table table-bordered table-hover table-dark">
                            <thead class="text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Books</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Book state</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Cover</th>
                                </tr>
                            </thead>
                            <tbody class="text-monospace">
                                <?php
                                // $viewSql = "SELECT * FROM tb_books";
                                $result = mysqli_query($conn, $viewSql);
                                if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    $image_src2 = "bookcover/".$row['image'];
                                    ?>
                                <tr>
                                <td><?php echo $row["bookid"] ?></td>
                                <td><?php echo $row["name"] ?></td>
                                <td><?php echo $row["author"] ?></td>
                                <td><?php echo $row["category"] ?></td>
                                <td><?php echo $row["bookstate"] ?></td>
                                <td><?php echo $row["price"] ?></td>
                                <td><?php echo $row["quantity"] ?></td>
                                <td><img src="<?php echo $image_src2?>" class="rounded" height="30" width="30"></td>
                                </tr>
                                <?php
                                }
                                } else { echo "No results were found!!? "; }
                                // $conn->close();
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <td>ID</td>
                                    <td>Books</td>
                                    <td>Author</td>
                                    <td>Category</td>
                                    <th>Book state</th>
                                    <td>Price</td>
                                    <td>Quantity</td>
                                    <td>Cover</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <hr>
                <div>
                    <form style="padding: 20px;" action="" method="POST">
                        <div class="d-flex ">
                            <input class="form-control w-100" type="search" name="src1" placeholder="Search using book id..." style="height: 31px;" required>
                            <button class="btn btn-secondary shadow-none pb-4 src_btn_admin " type="submit" name="srcbtn">&nbsp;<i class="fa fa-search "></i></button>
                        </div>
                    <?php echo $srcOutput?>
                    </form>

                    <form style="padding: 20px;" action="" method="POST" enctype="multipart/form-data">
                        <div class=" form-group ">
                            <input class="form-control" type="text" name="inp12" placeholder="Book Code" value="<?php echo $sbookcode ?>" required>
                            <input class="form-control" type="text" name="inp1" placeholder="Book Title" value="<?php echo $sbook ?>" required>
                            <input class="form-control" type="text" name="inp2" placeholder="Author" value="<?php echo $sauthor ?>" required>
                            <input class="form-control" type="text" name="inp3" placeholder="ISBN"value="<?php echo $sisbn ?>" >
                            <input class="form-control" type="text" name="inp4" placeholder="Publisher" value="<?php echo $spublisher ?>" required>
                            <input class="form-control" type="text" name="inp5" placeholder="Category" value="<?php echo $scategory ?>" required>
                            <input class="form-control" type="text" name="inp6" placeholder="Book Condition (Old / New / Old &amp; New /Used)" value="<?php echo $sbookstate ?>" required>
                            <input class="form-control" type="text" name="inp7" placeholder="New Book Price" value="<?php echo $sprice ?>" required>
                            <input class="form-control" type="text" name="inp13" placeholder="Old Book Price" value="<?php echo $sobprice ?>" required>
                            <input class="form-control" type="text" name="inp8" placeholder="New Book Price Before Discount"value="<?php echo $sdiscount ?>" >
                            <input class="form-control" type="text" name="inp9" placeholder="Quantity" value="<?php echo $squantity ?>" required>
                            <textarea class="form-control" name="inp10" placeholder="Details " rows="5 " style="font-size: 12px;"><?php echo $sdetails ?></textarea>
                            <input type="file" name="inp11" style="margin-top: 10px;" ><br>
                            <div class="btn-group " role="group ">
                                <button class="btn btn-danger btn-sm shadow-none mr-2 " type="submit" name="delete">DELETE</button>
                                <button class="btn btn-info btn-sm shadow-none mr-2 " type="submit">RESET</button>
                                <button class="btn btn-warning btn-sm shadow-none " type="submit" name="update">UPDATE</button></div>
                                <button class="btn btn-success btn-sm shadow-none " type="submit" name="save">INSERT</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
        </script>
        <script src="assets/js/jquery.min.js "></script>
        <script src="assets/bootstrap/js/bootstrap.min.js "></script>
        <script src="assets/js/bs-init.js "></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js "></script>
        <script src="assets/js/smoothproducts.min.js "></script>
        <script src="assets/js/theme.js "></script>
        <script src="assets/js/bootstrap-Image-Uploader.js "></script>
        <script src="assets/js/dropdown_search_style.js "></script>
        <script src="assets/js/material-Style-Ripple-Button.js "></script>
    </body>

    </html>