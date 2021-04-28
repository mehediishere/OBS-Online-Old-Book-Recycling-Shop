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
    if(isset($_GET['search']))
    {
        $src=$_GET['search'];
        if($src=="new")
        {
            $viewSql = "SELECT * FROM tb_books WHERE category NOT LIKE '%volunteer%' OR category NOT LIKE '%free%'";
        }elseif($src=="academic")
        {
            $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%academic%' AND category NOT LIKE '%volunteer%' ORDER BY srl DESC";
        }elseif($src=="cooking")
        {
            $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%cook%' AND category NOT LIKE '%volunteer%' ORDER BY srl DESC";
        }
        elseif($src=="jobPreparation")
        {
            $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%job%' AND category NOT LIKE '%volunteer%' ORDER BY srl DESC";
        }elseif($src=="entertainment")
        {
            $viewSql = "SELECT * FROM tb_books WHERE category NOT LIKE '%volunteer%' OR category NOT LIKE '%free%' AND category NOT LIKE '%academic%' AND category NOT LIKE '%job%' AND category NOT LIKE '%career%' AND category NOT LIKE '%business%' ORDER BY srl DESC";
        }elseif($src=="careerAndBusiness")
        {
            $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%career%' OR category LIKE '%business%' AND category NOT LIKE '%volunteer%' ORDER BY srl DESC";
        }elseif($src=="technology")
        {
            $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%technology%' AND category NOT LIKE '%volunteer%' ORDER BY srl DESC";
        }elseif($src=="volunteer")
        {
            $viewSql = "SELECT * FROM tb_books WHERE category LIKE '%volunteer%' OR category LIKE '%free%' ORDER BY srl DESC";
        }else
        {
            $viewSql = "SELECT * FROM tb_books";
        }
    }else
    {
        $viewSql = "SELECT * FROM tb_books WHERE category NOT LIKE '%volunteer%' AND category NOT LIKE '%free%'";
    }
    if(isset($_POST['srcbtn']))
    {
        $srcText = $_POST['src'];
        $viewSql = "SELECT * FROM tb_books WHERE name LIKE '%$srcText%' OR author LIKE '%$srcText%' OR category LIKE '%$srcText%' OR bookstate LIKE '%$srcText%' OR publisher LIKE '%$srcText%'";
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
                    <li class="nav-item"><a class="nav-link active" href="catalog.php">Category</a></li>
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
    <main class="page" style="padding-top: 100px;">
        <!-- search section -->
        <section>
            <div class="container">
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" name="src" class="form-control shadow-none" placeholder="Try to search using title, author, genres" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary shadow-none" type="submit" name="srcbtn">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- ads -->
        <section style="margin-bottom: 30px;">
            <div class="container">
                <div class="row">
                    <div class="col"><img class="w-100" src="assets/img/banner/00173648-1366x379.jpeg"></div>
                    <div class="col"><img class="w-100" src="assets/img/banner/00176380-1366x379.jpeg"></div>
                </div>
            </div>
        </section>
        <!-- books -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-xl-3" style="margin-right: 10px;padding: 20px;border: 1px solid rgb(213,197,197);box-shadow: 5px 0px 10px -7px rgba(0,0,0,0.75)!important;">
                        <div>
                            <h6 style="color: rgba(33,37,41,0.8);"><strong>EDUCATION &amp; STUDY GUIDE</strong></h6>
                            <hr>
                        </div><a class="category_link d-flex" href="catalog.php?search=academic"><i class="fa fa-book"></i>&nbsp;Academic</a><a class="category_link d-flex" href="catalog.php?search=jobPreparation"><i class="fa fa-book"></i>&nbsp;Job Preparation</a>
                        <a class="category_link d-flex" href="catalog.php?search=careerAndBusiness"><i class="fa fa-book"></i>&nbsp;Career &amp; Business</a><a class="category_link d-flex" href="catalog.php?search=technology"><i class="fa fa-book"></i>&nbsp;Technology</a>
                        <div>
                            <h6 style="margin-top: 20px;color: rgba(33,37,41,0.8);"><strong>PASTIME</strong></h6>
                            <hr>
                        </div><a class="category_link d-flex" href="#"><i class="fa fa-book"></i>&nbsp;Poetry</a><a class="category_link d-flex" href="#"><i class="fa fa-book"></i>&nbsp;Novel</a>
                        <a
                            class="category_link d-flex" href="catalog.php?search=entertainment"><i class="fa fa-book"></i>&nbsp;Drama</a><a class="category_link d-flex" href="#"><i class="fa fa-book"></i>&nbsp;Horror</a><a class="category_link d-flex" href="#"><i class="fa fa-book"></i>&nbsp;Crime</a><a class="category_link d-flex"
                                href="catalog.php?search=cooking"><i class="fa fa-book"></i>&nbsp;Cooking</a><a class="category_link d-flex" href="#"><i class="fa fa-book"></i>&nbsp;Children's</a><a class="category_link d-flex" href="#"><i class="fa fa-book"></i>&nbsp;Arts &amp; Graphics</a>
                            <a
                                class="category_link d-flex" href="#"><i class="fa fa-book"></i>&nbsp;Fantasy &amp; Mystery</a><a class="category_link d-flex" href="#"><i class="fa fa-book"></i>&nbsp;Biography &amp; History</a>
                                <hr>
                                <a class="category_link d-flex" href="vcatalog.php?search=volunteer"><i class="fa fa-book"></i>&nbsp;Books From D&VM</a>
                    </div>
                    <div class="col" style="padding: 20px;/*box-shadow: -5px 0px 10px -7px rgba(0,0,0,0.75)!important;*/border: 1px solid rgb(213,197,197);">
                        <div class="row">
                            <?php
                                // $viewSql = "SELECT * FROM tb_books where category not like '%volunteer%'";
                                $result = mysqli_query($conn, $viewSql);
                                $n = 1;
                                if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                    if ($n<50) {
                                        $image = "bookcover/".$row['image'];
                            ?>
                            <div class="col-12 col-md-6 col-lg-4" style="margin-bottom: 10px;">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="" method="POST">
                                        <div><img class="_catalog_image rounded mx-auto d-block" src="<?php echo $image; ?>"></div>
                                        <h6 class="card-title" style="text-align: center;"><?php echo $row['name'] ?></h6>
                                        <h6 class="text-center text-muted card-subtitle mb-2"><?php echo $row['author'] ?><br></h6>
                                        <div class="_price_text">
                                            <p class="text-left" style="font-size: 13px;color: rgb(255,0,0);"><span style="text-decoration: line-through;"><?php if($row['discount']>'0')echo $row['discount']; else echo "..."; ?></span></p>
                                            <p class="text-left _float_r"><?php if($row['price'] > 0 ){ echo "৳ $row[price]"; }else{ echo "৳ $row[obprice]"; } ?></p>
                                        </div>
                                        <input type='hidden' name='bookid' value="<?php echo $row['bookid'] ?>" />
                                        <div class="_inline mb-1"><span class="badge badge-secondary"><?php echo $row['bookstate'] ?></span></div>
                                        <div class="row">
                                            <div class="col"><button class="btn btn-warning btn-block btn-sm shadow-none" type="button" onclick="window.location.href='bookdetails.php?book=<?php echo $row['bookid'] ?>';"><i class="fas fa-stream"></i>Details</button></div>
                                            <div class="col"><button class="btn btn-success btn-block btn-sm shadow-none" type="submit"><i class="fas fa-cart-arrow-down"></i>Cart</button></div>
                                        </div>
                                        </form>
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
                        <div class="d-block d-flex justify-content-end"><button class="btn btn-dark shadow-none parallelogram_btn mr-4" type="button">NEXT</button><button class="btn btn-dark shadow-none mr-2" type="button"><i class="fa fa-angle-left" style="font-size: 20px;"></i></button><input type="search"
                                class="form-control shadow-none" style="width: 10%;" inputmode="numeric" value="1"><button class="btn btn-dark shadow-none mr-2 ml-2" type="button"><i class="fa fa-angle-right" style="font-size: 20px;"></i></button><small style="margin-top: 8px;">of ---</small></div>
                    </div>
                </div>
            </div>
        </section>
        <hr>
    </main>
    <section style="margin-top: 20px;">
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