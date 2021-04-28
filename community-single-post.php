<?php
    session_start();
    include 'db.php';
    if(isset($_GET['post']) && isset($_GET['id']))
    {
        $postID = $_GET['id'];
        $post = $_GET['post'];
        $postdetailsSQL = "SELECT * FROM tb_post WHERE srl = '$postID'";
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
        <section style="padding-top: 2rem;">
            <div class="container">
                <?php
                    $result = mysqli_query($conn, $postdetailsSQL);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $image = "assets/posts/".$row['image'];
                            $uname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `name`, `phone` FROM `tb_user` WHERE `email` = '$row[user]'"));
                ?>
                <div class="d-inline-flex"><a href="#" style="color: var(--info);font-size: 12PX;text-decoration: NONE;"><i class="fa fa-home"></i>&nbsp;Community</a>
                    <p style="font-size: 12PX;">&nbsp;/ <?php echo $row['category'];?> &nbsp;/&nbsp; <?php echo $row['title'];?> </p>
                </div>
                <div class="row" style="box-shadow: 0 5px 5px -5px rgba(182, 182, 182, 0.75);">
                    <div class="col-sm-5 text-center" style="padding-top: 2rem;"><img id="singlePostImg" class="myImg" src="<?php echo $image; ?>" alt="<?php echo $row['title'];?>" style="width:100%;max-width:300px;"></div>
                    <div class="col" style="padding-top: 2rem;border-left: 1px solid rgb(207,204,204);margin-bottom: 20px;">
                        <h5><i class="fa fa-book"></i><strong>&nbsp;<?php echo $row['title']; ?></strong><br></h5><span class="badge badge-secondary">Location &nbsp;:&nbsp; <?php echo $row['city']; ?></span>
                        <hr>
                        <h6 style="color: var(--cyan);font-size: 14px;">Posted by <strong><?php echo $uname['name']; ?></strong></h6>
                        <h6 style="color: var(--cyan);font-size: 14px;">Institution: <strong><?php echo $row['institution']; ?></strong></h6>
                        <span style="color: var(--cyan);"><i class="fa fa-phone-square" style="font-size: 21px;"></i>&nbsp;<strong>Call Seller :</strong></span><span style="margin-left: 25px;background-color: #DAE5ED;padding: 10px;"><?php echo $uname['phone']; ?></span>
                        <p
                            style="margin-top:10px"><strong style="color:var(--cyan);">Price :</strong> <?php echo $row['price']; ?></p>
                            <p><strong style="color:var(--cyan);">Description :</strong> <?php echo $row['details']; ?></p><a class="report_link" href="#" style="text-decoration: none;"><i class="fa fa-info-circle"></i>&nbsp;Report an Issue!</a>
                    </div>
                </div>
                <?php } }?>
                <!-- comment section -->
                <div>
                    <div id="disqus_thread"></div>
                    <script>
                        /**
                         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                        
                        var disqus_config = function () {
                        this.page.url = "http://localhost/obs/community-single-post.php?id=<?php echo $postID; ?>&post=<?php echo $post; ?>";  // Replace PAGE_URL with your page's canonical URL variable
                        this.page.identifier = "/obs/community-single-post.php?id=<?php echo $postID; ?>&post=<?php echo $post; ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                        };
                        
                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document,
                                s = d.createElement('script');
                            s.src = 'https://aquotefromanime.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript></div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12 mt-5">
                            <p><i class="fab fa-accusoft"></i> <strong> SIMILAR POST</strong></p>
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
                                            $viewSql1 = "SELECT * FROM tb_post WHERE srl = '$n1' ";
                                            $result1 = mysqli_query($conn, $viewSql1);
                                            if (mysqli_num_rows($result1) > 0) {
                                            while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                                                if ($n1<7) {
                                                    $image1 = "assets/posts/".$row1['image'];
                                        ?>
                                        <div class="col-sm-4 attir_style_a">
                                            <a href="community-single-post.php?id=<?php echo $row1['srl']; ?>&post=<?php echo $row1['title']; ?>">
                                                <div class="card my-2 singlepost_slide">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <img style="width: 100%; height: auto; max-width: 300px; max-height: 200px;" src="<?php echo $image1; ?>" alt="">
                                                            </div>
                                                            <div class="col">
                                                                <h6 style="font-size: 14px;" class="card-title"><?php echo $row1['title'] ?></h6>
                                                                <p style="font-size: 12px;" class="card-text">Posted by <strong><?php echo $row1['user'] ?></strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <?php 
                                                    }
                                                }
                                            }
                                            $n1 = $n1+1;
                                        } 
                                        ?>

                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="row">
                                    <?php
                                            $n1 = 7;
                                            while($n1<13){
                                            $viewSql1 = "SELECT * FROM tb_post WHERE srl = '$n1' ";
                                            $result1 = mysqli_query($conn, $viewSql1);
                                            if (mysqli_num_rows($result1) > 0) {
                                            while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                                                if ($n1<13) {
                                                    $image1 = "assets/posts/".$row1['image'];
                                        ?>
                                        <div class="col-sm-4 attir_style_a">
                                            <a href="community-single-post.php?id=<?php echo $row1['srl']; ?>&post=<?php echo $row1['title']; ?>">
                                                <div class="card my-2 singlepost_slide">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <img style="width: 100%; height: auto; max-width: 300px; max-height: 200px;" src="<?php echo $image1; ?>" alt="">
                                                            </div>
                                                            <div class="col">
                                                                <h6 style="font-size: 14px;" class="card-title"><?php echo $row1['title'] ?></h6>
                                                                <p style="font-size: 12px;" class="card-text">Posted by <strong><?php echo $row1['user'] ?></strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>                             
                                        <?php 
                                                    }
                                                }
                                            }
                                            $n1 = $n1+1;
                                        } 
                                        ?>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- ////////// -->
                    </div>
                </div>
        </section>
    </main>
    <!-- The Modal -->
    <div id="community_single_post_img_modal" class="modal_img">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>
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
        // Get the modal
        var modal = document.getElementById("community_single_post_img_modal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("singlePostImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        //For Slider
        $('#carouselExampleControls').on('slide.bs.carousel', function(e) {
            var inner = document.querySelector('.carousel-inner');
            var controls = document.querySelectorAll('.controls');
            if (e.direction === 'left') {
                controls[0].className = 'controls class-active';
            }
            if (e.direction === 'right') {
                controls[1].className = 'controls class-active'
            }

            if (e.relatedTarget == inner.lastElementChild) {
                controls[1].className = 'controls class-fade'
            }
            if (e.relatedTarget == inner.firstElementChild) {
                controls[0].className = 'controls class-fade'
            }
        })
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