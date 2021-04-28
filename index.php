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
            'fprice'=>$price,
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
    // session_unset();
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
    <link rel="stylesheet" href="assets/css/cart.css">
    <script src="https://use.fontawesome.com/ce3b7a5101.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-light clean-navbar" style="background-color: white!important;z-index: 80;">
        <div class="container"><a class="navbar-brand logo" href="#">OBS</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog.php">Category</a></li>
                    <li class="nav-item"><a class="nav-link" href="community.php">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="requestbook.php">Request</a></li>
                    <?php if(!isset($_SESSION["user"]) || $_SESSION["user"]==NULL){ ?>
                    <li class="nav-item"><a class="nav-link" href="logpage.php">LogIn/SignUp</a></li>
                    <?php }else{ ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fa fa-user" style="font-size: 17px;"></i></a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="shoppingbag.php"><i class="fa fa-cart-arrow-down" style="font-size: 17px;"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="background:#d2e5f3; z-index: 999; position: fixed; top:100px;" class="p-3">
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
    <main class="page">
        <!-- carosal -->
        <section style="margin-top:70px;">
            <div class="container" style="padding-top: 30px;">
                <div class="carousel slide carousel-fade" data-ride="carousel" id="carousel-1">
                    <div class="carousel-inner">
                        <div class="carousel-item active"><img class="w-100 d-block _fixed_slider" src="assets/img/banner/00173648-1366x379.jpeg" alt="Slide Image"></div>
                        <div class="carousel-item"><img class="w-100 d-block _fixed_slider" src="assets/img/ad/banner3.png" alt="Slide Image"></div>
                        <div class="carousel-item"><img class="w-100 d-block _fixed_slider" src="assets/img/banner/00176380-1366x379.jpeg" alt="Slide Image"></div>
                    </div>
                    <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button"
                            data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-1" data-slide-to="1"></li>
                        <li data-target="#carousel-1" data-slide-to="2"></li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- ads -->
        <section class="m-2">
            <div class="container">
                <div class="row">
                    <div class="col"><img class="w-100" src="assets/img/ad/25offads-SAI-stabilize.jpg"></div>
                    <div class="col"><img class="w-100" src="assets/img/ad/bkashoff-SAI-stabilize.jpg"></div>
                </div>
            </div>
        </section>
        <!-- new & noteworthy -->
        <section>
            <div class="container" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-7">
                        <h6>New &amp; Noteworthy</h6>
                    </div>
                    <div class="col text-right"><a class="badge badge-pill badge-warning" href="catalog.php?search=new" style="font-size: 10px;">See More&nbsp;<i class="fa fa-angle-double-right"></i></a></div>
                </div>
                <div class="row">
                    <?php
                        $viewSql = "SELECT * FROM tb_books";
                        $result = mysqli_query($conn, $viewSql);
                        $n = 1;
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            if ($n<7) {
                                $image = "bookcover/".$row['image'];
                    ?>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                        <div class="card">
                            <div class="details w-100 h-100 d-flex justify-content-center align-items-center"><a data-toggle="tooltip" data-bss-tooltip="" class="mr-4 view_details" href="bookdetails.php?book=<?php echo $row['bookid'] ?>" style="font-size: 30px;" title="Info"><i class="fas fa-stream" style="font-size: 25px;"></i></a>
                            <form action="" method="POST">
                                <!-- <a data-toggle="tooltip" data-bss-tooltip="" class="to_cart" name="add_to" href="" style="font-size: 30px;" title="To Cart"><i class="fa fa-cart-arrow-down"></i></a> -->
                                <button type='submit' class='to_cart' style="font-size: 30px; background:none; border:none;"><i class="fa fa-shopping-basket"></i></button>
                            </div>
                            <img class="card-img w-100 d-block" src="<?php echo $image; ?>" style="padding: 0.6rem;">
                            <div class="card-body" style="padding: 0rem 0.5rem;"><span class="badge badge-secondary badge-pill" style="font-size: 8px;"><?php echo $row['bookstate'] ?></span>
                                <h6 class="card-title" style="font-size: 12px;color: rgb(126,126,126);"><?php echo $row['author'] ?></h6>
                                <p class="card-text" style="font-size: 14px;"><?php echo $row['name'] ?></p>
                                <input type='hidden' name='bookid' value="<?php echo $row['bookid'] ?>" />
                                <div class="d-inline-flex">
                                    <p class="mr-2" style="padding: 0px!important;"><strong><?php if($row['price'] > 0 ){ echo "৳ $row[price]"; }else{ echo "৳ $row[obprice]"; } ?></strong></p>
                                    <p style="padding: 0px!important;font-size: 10px;color: var(--danger);"><strong><span style="text-decoration: line-through;"><?php if($row['discount']>'0')echo $row['discount'] ?></span></strong></p>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <?php
                            }
                            $n++;
                        }
                        } else {
                        echo "0 results";
                        }
                    ?>
                </div>
            </div>
        </section>
        <!-- academic -->
        <section style="margin-bottom: 1.5rem;">
            <div class="container" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-7">
                        <h6>Academic</h6>
                    </div>
                    <div class="col text-right"><a class="badge badge-pill badge-warning" href="catalog.php?search=academic" style="font-size: 10px;">See More&nbsp;<i class="fa fa-angle-double-right"></i></a></div>
                </div>
                <div class="row">
                    <?php
                        $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%Academic%' ORDER BY srl DESC";
                        $result = mysqli_query($conn, $viewSql);
                        $n = 1;
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            if ($n<7) {
                                $image = "bookcover/".$row['image'];
                    ?>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                        <div class="card">
                            <div class="details w-100 h-100 d-flex justify-content-center align-items-center"><a data-toggle="tooltip" data-bss-tooltip="" class="mr-4 view_details" href="bookdetails.php?book=<?php echo $row['bookid'] ?>" style="font-size: 30px;" title="Info"><i class="fas fa-stream"></i></a>
                            <form action="" method="POST">
                            <button type='submit' class='to_cart' style="font-size: 30px; background:none; border:none;"><i class="fa fa-shopping-basket"></i></button>
                                </div><img class="card-img w-100 d-block" src="<?php echo $image; ?>" style="padding: 0.6rem;">
                            <div class="card-body" style="padding: 0rem 0.5rem;"><span class="badge badge-secondary badge-pill" style="font-size: 8px;"><?php echo $row['bookstate'] ?></span>
                                <h6 class="card-title" style="font-size: 12px;color: rgb(126,126,126);"><?php echo $row['author'] ?></h6>
                                <p class="card-text" style="font-size: 14px;"><?php echo $row['name'] ?></p>
                                <input type='hidden' name='bookid' value="<?php echo $row['bookid'] ?>" />
                                <div class="d-inline-flex">
                                    <p class="mr-2" style="padding: 0px!important;"><strong><?php if($row['price'] > 0 ){ echo "৳ $row[price]"; }else{ echo "৳ $row[obprice]"; } ?></strong></p>
                                    <p style="padding: 0px!important;font-size: 10px;color: var(--danger);"><strong><span style="text-decoration: line-through;"><?php if($row['discount']>'0')echo $row['discount'] ?></span></strong></p>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <?php
                            }
                            $n++;
                        }
                        } else {
                        echo "0 results";
                        }
                    ?>
                </div>
            </div>
        </section>
        <!-- ads -->
        <section class="m-2">
            <div class="container">
                <div class="row">
                    <div class="col"><img class="w-100" src="assets/img/ad/banner3.png"></div>
                </div>
            </div>
        </section>
        <!-- job preparation -->
        <section>
            <div class="container" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-7">
                        <h6>Job Preparation</h6>
                    </div>
                    <div class="col text-right"><a class="badge badge-pill badge-warning" href="catalog.php?search=jobPreparation" style="font-size: 10px;">See More&nbsp;<i class="fa fa-angle-double-right"></i></a></div>
                </div>
                <div class="row">
                   <?php
                        $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%Job%' ORDER BY srl DESC";
                        $result = mysqli_query($conn, $viewSql);
                        $n = 1;
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            if ($n<7) {
                                $image = "bookcover/".$row['image'];
                    ?>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                        <div class="card">
                            <div class="details w-100 h-100 d-flex justify-content-center align-items-center"><a data-toggle="tooltip" data-bss-tooltip="" class="mr-4 view_details" href="bookdetails.php?book=<?php echo $row['bookid'] ?>" style="font-size: 30px;" title="Info"><i class="fas fa-stream"></i></a>
                            <form action="" method="POST">
                            <button type='submit' class='to_cart' style="font-size: 30px; background:none; border:none;"><i class="fa fa-shopping-basket"></i></button></div>
                            <img class="card-img w-100 d-block" src="<?php echo $image; ?>" style="padding: 0.6rem;">
                            <div class="card-body" style="padding: 0rem 0.5rem;"><span class="badge badge-secondary badge-pill" style="font-size: 8px;"><?php echo $row['bookstate'] ?></span>
                                <h6 class="card-title" style="font-size: 12px;color: rgb(126,126,126);"><?php echo $row['author'] ?></h6>
                                <p class="card-text" style="font-size: 14px;"><?php echo $row['name'] ?></p>
                                <input type='hidden' name='bookid' value="<?php echo $row['bookid'] ?>" />
                                <div class="d-inline-flex">
                                    <p class="mr-2" style="padding: 0px!important;"><strong><?php if($row['price'] > 0 ){ echo "৳ $row[price]"; }else{ echo "৳ $row[obprice]"; } ?></strong></p>
                                    <p style="padding: 0px!important;font-size: 10px;color: var(--danger);"><strong><span style="text-decoration: line-through;"><?php if($row['discount']>'0')echo $row['discount'] ?></span></strong></p>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <?php
                            }
                            $n++;
                        }
                        } else {
                        echo "0 results";
                        }
                    ?>
                </div>
            </div>
        </section>
        <!-- entertainment -->
        <section>
            <div class="container" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-7">
                        <h6>Entertainment</h6>
                    </div>
                    <div class="col text-right"><a class="badge badge-pill badge-warning" href="catalog.php?search=entertainment" style="font-size: 10px;">See More&nbsp;<i class="fa fa-angle-double-right"></i></a></div>
                </div>
                <div class="row">
                    <?php
                        $viewSql = "SELECT * FROM tb_books WHERE category NOT LIKE '%volunteer%' AND category NOT LIKE '%free%' AND category NOT LIKE '%academic%' AND category NOT LIKE '%job%' AND category NOT LIKE '%career%' AND category NOT LIKE '%business%' ORDER BY srl DESC";
                        $result = mysqli_query($conn, $viewSql);
                        $n = 1;
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            if ($n<7) {
                                $image = "bookcover/".$row['image'];
                    ?>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                        <div class="card">
                            <div class="details w-100 h-100 d-flex justify-content-center align-items-center"><a data-toggle="tooltip" data-bss-tooltip="" class="mr-4 view_details" href="bookdetails.php?book=<?php echo $row['bookid'] ?>" style="font-size: 30px;" title="Info"><i class="fas fa-stream"></i></a>
                            <form action="" method="POST">
                            <button type='submit' class='to_cart' style="font-size: 30px; background:none; border:none;"><i class="fa fa-shopping-basket"></i></button>
                            </div><img class="card-img w-100 d-block" src="<?php echo $image; ?>" style="padding: 0.6rem;">
                            <div class="card-body" style="padding: 0rem 0.5rem;"><span class="badge badge-secondary badge-pill" style="font-size: 8px;"><?php echo $row['bookstate'] ?></span>
                                <h6 class="card-title" style="font-size: 12px;color: rgb(126,126,126);"><?php echo $row['author'] ?></h6>
                                <p class="card-text" style="font-size: 14px;"><?php echo $row['name'] ?></p>
                                <input type='hidden' name='bookid' value="<?php echo $row['bookid'] ?>" />
                                <div class="d-inline-flex">
                                    <p class="mr-2" style="padding: 0px!important;"><strong><?php if($row['price'] > 0 ){ echo "৳ $row[price]"; }else{ echo "৳ $row[obprice]"; } ?></strong></p>
                                    <p style="padding: 0px!important;font-size: 10px;color: var(--danger);"><strong><span style="text-decoration: line-through;"><?php if($row['discount']>'0')echo $row['discount'] ?></span></strong></p>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <?php
                            }
                            $n++;
                        }
                        } else {
                        echo "0 results";
                        }
                    ?>
                </div>
            </div>
        </section>
        <!-- ads -->
        <section class="m-2">
            <div class="container">
                <div class="row">
                    <div class="col"><img class="w-100" src="assets/img/banner/donation%20cover.png"></div>
                </div>
            </div>
        </section>
        <!-- volunteer -->
        <section>
            <div class="container" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-7">
                        <h6>Gift From Precious Volunteers <a href=""><i class="fa fa-info-circle"></i></a> </h6>
                    </div>
                    <div class="col text-right"><a class="badge badge-pill badge-warning" href="vcatalog.php?search=volunteersBook" style="font-size: 10px;">See More&nbsp;<i class="fa fa-angle-double-right"></i></a></div>
                </div>
                <div class="row">
                    <?php
                        $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%Volunteer%' OR category LIKE '%Free%' ORDER BY srl DESC";
                        $result = mysqli_query($conn, $viewSql);
                        $n = 1;
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            if ($n<7) {
                                $image = "bookcover/".$row['image'];
                    ?>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                        <div class="card">
                            <div class="details w-100 h-100 d-flex justify-content-center align-items-center"><a data-toggle="tooltip" data-bss-tooltip="" class="view_details" href="requestorbuy.php?book=<?php echo $row['bookid'] ?>" style="font-size: 30px;" title="Buy/Request"><i class="fa fa-angellist"></i></a></div><img class="card-img w-100 d-block" src="<?php echo $image; ?>"
                                style="padding: 0.6rem;">
                            <div class="card-body" style="padding: 0rem 0.5rem;"><span class="badge badge-secondary badge-pill" style="font-size: 8px;"><?php echo $row['bookstate'] ?></span>
                                <h6 class="card-title" style="font-size: 12px;color: rgb(126,126,126);"><?php echo $row['author'] ?></h6>
                                <p class="card-text" style="font-size: 14px;"><?php echo $row['name'] ?></p>
                                <div class="d-inline-flex">
                                    <p class="mr-2" style="padding: 0px!important;"><strong><?php if($row['price'] > 0 ){ echo "৳ $row[price]"; }else{ echo "৳ $row[obprice]"; } ?></strong></p>
                                    <p style="padding: 0px!important;font-size: 10px;color: var(--danger);"><strong><span style="text-decoration: line-through;"><?php if($row['discount']>'0')echo $row['discount'] ?></span></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                            $n++;
                        }
                        } else {
                        echo "0 results";
                        }
                    ?>
                </div>
            </div>
        </section>
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
    </main>
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