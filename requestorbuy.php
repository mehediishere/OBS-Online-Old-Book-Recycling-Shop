<?php
    session_start();
    include'db.php';
    $status="";
    if (isset($_POST['bookid']) && $_POST['bookid']!=""){
        $bookid = $_POST['bookid'];
        $result = mysqli_query($conn,"SELECT * FROM `tb_books` WHERE `bookid`='$bookid'");
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $bookid = $row['bookid'];
        $price = $row['price'];
        $obprice = $row['obprice'];
        $image = "bookcover/".$row['image'];
    
        $cartArray = array(
            $bookid=>array(
            'name'=>$name,
            'bookid'=>$bookid,
            'price'=>$price,
            'obprice'=>$obprice,
            'quantity'=>1,
            'bstate'=>"NEW",
            'image'=>$image)
        );
    
        if(empty($_SESSION["shopping_cart"])) 
        {
            $_SESSION["shopping_cart"] = $cartArray;
            // $status = "<div class='box'>Product is added to your cart!</div>";
        }
        else
        {
            $array_keys = array_keys($_SESSION["shopping_cart"]);
            if(in_array($bookid,$array_keys)) {
                // $status = "<div class='box' style='color:red;'>Product is already added to your cart!</div>";	
            } else {
            $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
            // $status = "<div class='box'>Product is added to your cart!</div>";
            }
        }
    }
    if(isset($_GET['book']))
    {
        $bookID = $_GET['book'];
        $bookdetailsSQL = "SELECT * FROM tb_books WHERE bookid = '$bookID' AND category LIKE '%volunteer%'";
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
    <link rel="stylesheet" href="assets/css/cart.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://use.fontawesome.com/ce3b7a5101.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-light clean-navbar" style="background-color: white!important;z-index: 80;">
        <div class="container"><a class="navbar-brand logo" href="#">OBS</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog.php">Category</a></li>
                    <li class="nav-item"><a class="nav-link" href="community.php">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="requestbook.php">Request</a></li>
                    <?php if(!isset($_SESSION["user"])|| $_SESSION["user"]==NULL){ ?>
                    <li class="nav-item"><a class="nav-link" href="logpage.php">LogIn/SignUp</a></li>
                    <?php }else{ ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fa fa-user" style="font-size: 17px;"></i></a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="shoppingbag.php"><i class="fa fa-cart-arrow-down" style="font-size: 17px;"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="background:#d2e5f3; z-index: 9; position: fixed; top:100px;" class="p-3">
        <?php
			if(!empty($_SESSION["shopping_cart"])) {
			$cart_count = count(array_keys($_SESSION["shopping_cart"]));
		?>
        <div class="cart_div">
            <a href="shoppingbag.php"><img src="assets/img/icon/cart-icon.png" /><span><?php echo $cart_count; ?></span></a>
        </div>
        <?php
            }else{ ?>
                <div class="cart_div">
                    <a href="shoppingbag.php"><img src="assets/img/icon/cart-icon.png" /><span>0</span></a>
                </div>
            <?php }
        ?>
        <p> <?php echo $status; ?> </p>
    </div>
    <main>
        <section>
            <div class="container shadow" style="margin-top: 100px;background-color: #FFFFFF;padding: 20px;">
                <div style="margin-left: 15px;margin-right: 15px;">
                    <div class="row">
                        <?php
                            $result = mysqli_query($conn, $bookdetailsSQL);
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $image = "bookcover/".$row['image'];
                        ?>
                        <div class="col-md-6 col-lg-5 col-xl-4">
                            <div class="text-center"><img src="<?php echo $image; ?>" style="width: 100%;height: 400px;border: 1px solid rgb(231,231,231);padding: 30px;"></div>
                        </div>
                        <div class="col"><span class="badge badge-secondary"><?php echo $row['bookstate'] ?></span>
                        <form action="" method="POST">
                            <h5><strong><?php echo $row['name'] ?></strong></h5>
                            <p style="font-size:14px;">By <strong style="color:rgb(68,89,108);"><?php echo $row['author'] ?></strong></p>
                            <p style="font-size:14px;">Publisher : <strong style="color:rgb(68,89,108);"><?php echo $row['publisher'] ?></strong></p>
                            <p style="font-size: 13px;">Category : <a href="" style="text-decoration: none; color: rgb(8, 140, 255);"><?php echo $row['category'] ?></a></p>
                            <div>
                                <div class="d-inline-flex">
                                <p><?php echo "New : ৳ $row[price]" ?>&nbsp; &nbsp;&nbsp;</p>
                                        <p style="font-size: 12px; color:red;"><span
                                                style="text-decoration: line-through;"><?php if($row['discount']>'0')echo $row['discount'] ?></span>&nbsp; &nbsp;&nbsp;
                                        </p>
                                        <p>||&nbsp;&nbsp;&nbsp;&nbsp;<?php if($row['obprice']>'0')echo "Old : ৳ $row[obprice]" ?>&nbsp; &nbsp;&nbsp;</p>
                                </div>
                            </div>
                            <input type='hidden' name='bookid' value="<?php echo $row['bookid'] ?>" />
                            <p style="color: green;"><i class="fa fa-bookmark-o"></i>&nbsp;In Stock</p>
                            <div style="margin-bottom: 15px;"><button class="btn btn-success btn-sm shadow-none mr-2" type="submit"><i class="fa fa-cart-arrow-down"></i>&nbsp;Add to Cart</button>
                                <a class="btn btn-info btn-sm shadow-none" role="button" href="requestorbuytorequest.php?book=<?php echo $row['bookid'] ?>"><i class="fa fa-hand-peace-o"></i>&nbsp;Request</a>
                            </div><a href="#" style="color: var(--danger);font-size: 14px;"><i class="fa fa-info-circle"></i>&nbsp;Report any issue</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div style="margin: 15px;">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation" ><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1">Summary</a></li>
                        <li class="nav-item" role="presentation" ><a class="nav-link" role="tab" data-toggle="tab" href="#tab-2">Author</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="tab-1">
                        <table class="table table-bordered mt-3 mb-3">
                                <tbody style="font-size: 0.9rem;">
                                  <tr>
                                    <td style="background-color: #F1F2F4; width: 20%;">Title</td>
                                    <td><a href="" style="color:#4d94ff;"><?php echo $row['name'] ?></a></td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #F1F2F4; width: 20%;">Author</td>
                                    <td><a href="" style="color:#4d94ff;"><?php echo $row['author'] ?></a></td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #F1F2F4; width: 20%;">Publisher</td>
                                    <td><a href="" style="color:#4d94ff;"><?php echo $row['publisher'] ?></a></td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #F1F2F4; width: 20%;">ISBN</td>
                                    <td style="color:#4d94ff;"><?php echo $row['isbn'] ?></td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #F1F2F4; width: 20%;">Category</td>
                                    <td><a href="" style="color:#4d94ff;"><?php echo $row['category'] ?></a></td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #F1F2F4; width: 20%;">About This Book</td>
                                    <td><?php echo $row['details'] ?></td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" role="tabpanel" id="tab-2">
                        <?php
                            $authorSQL = "SELECT * FROM tb_author WHERE name = '$row[author]'";
                            $resultAuthor = mysqli_query($conn, $authorSQL);
                            if (mysqli_num_rows($resultAuthor) > 0) {
                                while($authorRow = mysqli_fetch_assoc($resultAuthor)) {
                                ?>
                                    <table class="table table-bordered mt-3 mb-3">
                                    <tbody style="font-size: 0.9rem;">
                                      <tr>
                                        <td style="background-color: #F1F2F4; width: 20%;"><?php echo $authorRow['name'] ?></td>
                                        <td><img src="<?php echo "author/".$authorRow['image'] ?>" style="width: 150px;height: 200px;border: 1px solid rgb(231,231,231);padding: 3px;"></td>
                                      </tr>
                                      <tr>
                                        <td style="background-color: #F1F2F4; width: 20%;">About Author</td>
                                        <td><?php echo $authorRow['details'] ?></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                <?php
                                }
                            } else {?>
                                <table class="table table-bordered mt-3 mb-3">
                                <tbody style="font-size: 0.9rem;">
                                  <tr>
                                    <td style="background-color: #F1F2F4; width: 20%;"><?php echo $row['author'] ?></td>
                                    <td><img src="" style="width: 150px;height: 200px;border: 1px solid rgb(231,231,231);padding: 3px;"></td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #F1F2F4; width: 20%;">About Author</td>
                                    <td>Will be added soon. Stay in touch</td>
                                  </tr>
                                </tbody>
                              </table>
                            <?php 
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                                }
                            } else {
                            echo "0 results";
                            }
                        ?>
            </div>
        </section>
        <section>
            <div class="container" style="margin-top: 10px;background-color: #FFFFFF;padding: 20px;margin-bottom: 10px;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12 mt-5">
                                <p><i class="fab fa-accusoft"></i> <strong> More Books For You</strong></p>
                                <div class="text-right">
                                    <a style="text-shadow: none;" class="btn btn-light btn-info" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <i class="controls class-fade"><<</i>
                                    </a>
                                    <a class="btn btn-light btn-info" href="#carouselExampleControls" role="button" data-slide="next">
                                        <i class="controls class-active">>></i>
                                    </a>
                                </div>
                            </div>

                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">

                                    <div class="carousel-item active">
                                        <div class="row">
                                        <?php
                                                $n1 = 1;
                                                while($n1<7){
                                                $randNum = mt_rand(1,35);
                                                $viewSql1 = "SELECT * FROM tb_books WHERE srl = '$randNum' ";
                                                $result1 = mysqli_query($conn, $viewSql1);
                                                if (mysqli_num_rows($result1) > 0) {
                                                while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                                                    if ($n1<7) {
                                                        $image1 = "bookcover/".$row1['image'];
                                            ?>
                                            <div class="col-sm-4 attir_style_a">
                                                <a href="bookdetails.php?book=<?php echo $row1['bookid'] ?>">
                                                    <div class="card my-2 singlepost_slide">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <img style="width: 100%; height: auto; max-width: 300px; max-height: 200px;"
                                                                        src="<?php echo $image1; ?>" alt="">
                                                                </div>
                                                                <div class="col">
                                                                    <h6 style="font-size: 14px;" class="card-title">
                                                                    <?php echo $row1['name'] ?></h6>
                                                                    <p style="font-size: 12px;" class="card-text">
                                                                    By <strong><?php echo $row1['author'] ?></strong></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                                    }
                                                    $n1++;
                                                }
                                                } else {
                                                echo "0 results";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <div class="row">
                                        <?php
                                                $n1 = 1;
                                                while($n1<7){
                                                $randNum = mt_rand(1,35);
                                                $viewSql1 = "SELECT * FROM tb_books WHERE srl = '$randNum' ";
                                                $result1 = mysqli_query($conn, $viewSql1);
                                                if (mysqli_num_rows($result1) > 0) {
                                                while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                                                    if ($n1<7) {
                                                        $image1 = "bookcover/".$row1['image'];
                                            ?>
                                            <div class="col-sm-4 attir_style_a">
                                                <a href="bookdetails.php?book=<?php echo $row1['bookid'] ?>">
                                                    <div class="card my-2 singlepost_slide">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <img style="width: 100%; height: auto; max-width: 300px; max-height: 200px;"
                                                                        src="<?php echo $image1; ?>" alt="">
                                                                </div>
                                                                <div class="col">
                                                                    <h6 style="font-size: 14px;" class="card-title">
                                                                    <?php echo $row1['name'] ?></h6>
                                                                    <p style="font-size: 12px;" class="card-text">
                                                                    By <strong><?php echo $row1['author'] ?></strong></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                                    }
                                                    $n1++;
                                                }
                                                } else {
                                                echo "0 results";
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <div class="row">
                                        <?php
                                                $n1 = 1;
                                                while($n1<7){
                                                $randNum = mt_rand(1,35);
                                                $viewSql1 = "SELECT * FROM tb_books WHERE srl = '$randNum' ";
                                                $result1 = mysqli_query($conn, $viewSql1);
                                                if (mysqli_num_rows($result1) > 0) {
                                                while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                                                    if ($n1<7) {
                                                        $image1 = "bookcover/".$row1['image'];
                                            ?>
                                            <div class="col-sm-4 attir_style_a">
                                                <a href="bookdetails.php?book=<?php echo $row1['bookid'] ?>">
                                                    <div class="card my-2 singlepost_slide">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <img style="width: 100%; height: auto; max-width: 300px; max-height: 200px;"
                                                                        src="<?php echo $image1; ?>" alt="">
                                                                </div>
                                                                <div class="col">
                                                                    <h6 style="font-size: 14px;" class="card-title">
                                                                    <?php echo $row1['name'] ?></h6>
                                                                    <p style="font-size: 12px;" class="card-text">
                                                                    By <strong><?php echo $row1['author'] ?></strong></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                                    }
                                                    $n1++;
                                                }
                                                } else {
                                                echo "0 results";
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!-- ////////// -->
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <section style="margin-top: 20px;">
        <hr>
        <div class="container" style="color: gray;">
            <div class="row">
                <div class="col d-flex justify-content-center"><img class="mr-1" src="assets/img/icon/Layer%201.png" style="height: 5vh;color: #e10909;">
                    <p style="font-size: 14px;"><span><strong>HELP CENTER</strong></span><br> +8801957*204*6</p>
                </div>
                <div class="col d-flex justify-content-center"><img class="mr-1" src="assets/img/icon/Layer%203.png" style="height: 5vh;color: #e10909;">
                    <p style="font-size: 14px;"><span><strong>PAY BILL</strong></span><br> Pay Cash On Delivery (Dhaka Only)</p>
                </div>
                <div class="col d-flex justify-content-center"><img class="mr-1" src="assets/img/icon/Layer%205.png" style="height: 5vh;color: #e10909;">
                    <p style="font-size: 14px;"><span><strong>SERVICE</strong></span><br>All Over Bangladesh</p>
                </div>
            </div>
        </div>
    </section>
    <footer class="page-footer dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>OBS</h5>
                    <p style="color: rgb(210,209,209);"><i class="fa fa-angle-right footer_arrow" style="color: var(--blue);"></i> +880195-75*0456<br><i class="fa fa-angle-right footer_arrow" style="color: var(--blue);"></i> Email : obs@gmail.com<br><i class="fa fa-angle-right footer_arrow"
                            style="color: var(--blue);"></i> Office: 7th Floor Shal-Ali Plaza, Mirpur-10, Dhaka-1216.</p>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">About OBS</a></li>
                        <li><a href="contact-us.html">Contact us</a></li>
                    </ul>
                    <div style="margin-top: -15px;"><a class="mr-2 ml-3" href="#" style="font-size: 20px;"><i class="fa fa-facebook-square"></i></a><a class="mr-2" href="#" style="font-size: 20px;"><i class="fa fa-twitter-square"></i></a><a href="#" style="font-size: 20px;"><i class="fa fa-google-plus-square"></i></a></div>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2020 Copyright Text</p>
        </div>
    </footer>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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