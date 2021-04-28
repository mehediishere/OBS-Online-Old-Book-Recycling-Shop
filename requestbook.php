<?php
    session_start();
    include'db.php';
    if(isset($_POST["book_req"]) && !empty($_SESSION["user"]))
    {
        $req = "INSERT INTO tb_req(`user`, `book`,`author`,`edition`,`bookstate`,`note`, `quantity`) VALUES ('$_SESSION[user]', '$_POST[book]', '$_POST[author]', '$_POST[edition]', '$_POST[bookstate]', '$_POST[details]', '$_POST[quantity]')";
        if(mysqli_query($conn, $req))
        {
            echo "<script>alert('Your request submitted successfully');</script>";
        }
        else{
            echo "<script>alert('Your request couldn't be processed. Please try again or contact with us.');</script>";
        }

    }elseif(isset($_POST["book_req"]) && empty($_SESSION["user"]) || !isset($_SESSION["user"])){
        echo "<script>alert('Please login to continue. Not a member yet? Join with us. We will be happy to have you.');</script>";
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
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-light clean-navbar"
        style="background-color: white!important;z-index: 80;">
        <div class="container"><a class="navbar-brand logo" href="#">OBS</a><button data-toggle="collapse"
                class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog.php">Category</a></li>
                    <li class="nav-item"><a class="nav-link" href="community.php">Community</a></li>
                    <li class="nav-item"><a class="nav-link active" href="requestbook.php">Request</a></li>
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
        <section style="margin: 1rem 0;">
            <div class="container">
                <div class="row">
                    <div class="col" style="border: 1px solid rgb(231,231,231);">
                    <form action="" method="POST">
                        <img class="w-100 shadow-sm" src="assets/img/banner/requestbook.png" style="margin-top: 1rem;">
                        <h6 style="color: var(--gray);text-align: justify;font-size: 12px;">Please fill the form &amp;
                            wait for our member call to confirm your request or keep an eye on your email.</h6>
                        <div style="margin-bottom: 1rem;">
                            <p style="margin-bottom: 0;">Book</p><input type="text" class="form-control" name="book">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <p style="margin-bottom: 0;">Author</p><input type="text" class="form-control" name="author">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <p style="margin-bottom: 0;">Book Edition</p><input type="text" class="form-control" name="edition">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <p style="margin-bottom: 0;">Quantity</p><input type="text" class="form-control" name="quantity" value="1">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <p style="margin-bottom: 0;">Book Condition</p>
                            <select class="form-control" name="bookstate">
                                <optgroup label="Please select book condition">
                                    <option value="New" selected>New</option>
                                    <option value="Old">Old</option>
                                    <option value="New/Old">New / OLD</option>
                                </optgroup>
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <p style="margin-bottom: 0;">Other Details / Your Note</p>
                            <textarea class="form-control" name="details"></textarea>
                        </div><button class="btn btn-block shadow-none request_book_btn mb-2" type="submit" name="book_req">SEND</button>
                    </div>
                    <div class="col"><img class="w-100" src="assets/img/6061208d94770d91351341cbeb1dd5a7.png" style="height: 650px;"></div>
                </div>
                    </form>
            </div>
        </section>
    </main>
    <section style="margin-top: 20px;">
        <hr>
        <div class="container" style="color: gray;">
            <div class="row">
                <div class="col d-flex justify-content-center"><img class="mr-1" src="assets/img/icon/Layer%201.png"
                        style="height: 5vh;color: #e10909;">
                    <p style="font-size: 14px;"><span><strong>HELP CENTER</strong></span><br> +8801957*204*6</p>
                </div>
                <div class="col d-flex justify-content-center"><img class="mr-1" src="assets/img/icon/Layer%203.png"
                        style="height: 5vh;color: #e10909;">
                    <p style="font-size: 14px;"><span><strong>PAY BILL</strong></span><br> Pay Cash On Delivery (Dhaka
                        Only)</p>
                </div>
                <div class="col d-flex justify-content-center"><img class="mr-1" src="assets/img/icon/Layer%205.png"
                        style="height: 5vh;color: #e10909;">
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
                    <p style="color: rgb(210,209,209);"><i class="fa fa-angle-right footer_arrow"
                            style="color: var(--blue);"></i> +880195-75*0456<br><i
                            class="fa fa-angle-right footer_arrow" style="color: var(--blue);"></i> Email :
                        obs@gmail.com<br><i class="fa fa-angle-right footer_arrow" style="color: var(--blue);"></i>
                        Office: 7th Floor Shal-Ali Plaza, Mirpur-10, Dhaka-1216.</p>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">About OBS</a></li>
                        <li><a href="contact-us.html">Contact us</a></li>
                    </ul>
                    <div style="margin-top: -15px;"><a class="mr-2 ml-3" href="#" style="font-size: 20px;"><i
                                class="fa fa-facebook-square"></i></a><a class="mr-2" href="#"
                            style="font-size: 20px;"><i class="fa fa-twitter-square"></i></a><a href="#"
                            style="font-size: 20px;"><i class="fa fa-google-plus-square"></i></a></div>
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