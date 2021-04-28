<?php
    session_start();
    include 'db.php';
    $postType = "All";
    if(isset($_GET['category']))
    {
        $category = $_GET['category'];
        if($category == "University")
        {
            $postType = "University";
            $viewSql = "SELECT * FROM tb_post WHERE category = 'University'";
        }
        elseif($category == "College")
        {
            $postType = "College";
            $viewSql = "SELECT * FROM tb_post WHERE category = 'College'";
        }
        elseif($category == "School")
        {
            $postType = "School";
            $viewSql = "SELECT * FROM tb_post WHERE category = 'School'";
        }
        elseif($category == "NonAcademic")
        {
            $postType = "NonAcademic";
            $viewSql = "SELECT * FROM tb_post WHERE category = 'NonAcademic'";
        }
        elseif($category == "All")
        {
            $viewSql = "SELECT * FROM tb_post";
        }
        else{
            $viewSql = "SELECT * FROM tb_post";
        }
    }else
    {
        $viewSql = "SELECT * FROM tb_post";
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
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-light clean-navbar" style="background-color: white!important;z-index: 80;">
        <div class="container"><a class="navbar-brand logo" href="#">OBS</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog.php">Category</a></li>
                    <li class="nav-item"><a class="nav-link active" href="community.php">Community</a></li>
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
    <main class="page">
        <section>
            <div class="container">
                <div>
                    <form class="search-form">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div><input class="form-control" type="text" placeholder="I am looking for..">
                            <div class="input-group-append"><button class="btn btn-light shadow-none" type="button" style="border: 0.5px solid gray!important;">Search </button></div>
                        </div>
                    </form>
                </div>
                <div class="mb-5 ads_community_top"><img class="w-100" src="assets/img/ad/0193e2e7a9e0158d273b42da6d270854.jpg"></div>
                <div>
                    <div class="row">
                        <div class="col-sm-12 col-md-9 col-lg-8" style="border: 1px solid rgb(231,231,231);padding-top: 15px;">
                            <div>
                                <form action="" method="GET">
                                    <a href="community.php?category=All" style="padding-right: 10%;font-size: 14px;color: var(--cyan);">All Post</a>
                                    <a href="community.php?category=School" style="padding-right: 10%;font-size: 14px;color: var(--cyan);">Schools Post</a>
                                    <a href="community.php?category=College" style="padding-right: 10%;font-size: 14px;color: var(--cyan);">Colleges Post</a>
                                    <a href="community.php?category=University" style="padding-right: 10%;font-size: 14px;color: var(--cyan);">Universityls Post</a>
                                    <a href="community.php?category=NonAcademic" style="padding-right: 10%;font-size: 14px;color: var(--cyan);">NonAcademic Post</a>
                                </form>
                                <p
                                    style="padding-top:10px"><i class="fab fa-accusoft"></i> <b><?php echo $postType; ?> : Recent Posts</b></p>
                                    <hr>
                                    <div>
                                    <?php
                                        // $viewSql = "SELECT * FROM tb_post WHERE category = 'University'";
                                        $result = mysqli_query($conn, $viewSql);
                                        if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $image_src = "assets/posts/".$row['image'];
                                            $uname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `name` FROM `tb_user` WHERE `email` = '$row[user]'"));
                                    ?>
                                        <a style="text-decoration: none; color:black" href="community-single-post.php?id=<?php echo $row['srl']; ?>&post=<?php echo $row['title']; ?>">
                                            <div class="row row_post">
                                                <div class="col-7 col-sm-4 col-xl-3 text-center"><img src="<?php echo $image_src; ?>" style="height: 100px;width: 120px;" /></div>
                                                <div class="col offset-xl-0">
                                                    <h6><?php echo $row['title']; ?><span class="ml-3" style="font-size:10px;"><?php echo $row['submit_time']; ?></span></h6>
                                                    <h6 style="font-size: 13px;">Posted by <strong><?php echo $uname['name']; ?></strong></h6>
                                                    <h6 class="light-text" style="font-size: 13px;">Location: <?php echo $row['city']; ?></h6>
                                                </div>
                                            </div>
                                        </a>
                                        <?php } } ?>
                                    </div>
                            </div>
                            <!-- pagination -->
                            <div style="margin-top: 15px;">
                                <nav>
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-4 ads_community_side"><img class="w-100" src="assets/img/ad/book-fair-poster__front.png"><img class="w-100 mt-3" src="assets/img/ad/b6a0ad8243242657037c8fa2a048e830.png"></div>
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