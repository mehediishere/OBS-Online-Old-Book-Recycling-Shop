<?php 
    session_start();
    include 'db.php';
    $message = '<p style="color:#a5afb7;">One Step Closer To Get Your Favourite Books (⌐■_■)</p>';
    if(isset($_SESSION["user"]) && $_SESSION["user"]!=NULL)
    {
        header("location:index.php");
    }
    if(isset($_POST['login_btn']))
    {
        $email = $_POST['maillog'];
        $password = $_POST['passlog'];
        $sql = "SELECT * FROM tb_user WHERE email = '$email' AND password ='$password'";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $email2 = $row['email'];
                    $password2 = $row['password'];
                    if($email = $email2 && $password = $password2){
                        $_SESSION["user"] = $row['email'];
                        $_SESSION["username"] = $row['name'];
                        $_SESSION["userphone"] = $row['phone'];
                        $_SESSION["useraddress"] = $row['address'];
                        header("location:profile.php");
                    }
                    else{
                        echo "<script> alert('Something went wrong. $email2 && $password2'); </script>";
                    }
                }
            } else{
                $message = '<p style="color:red;">Invalid Email or Password.</p>';
            }
        } else{
            header("location:logpage.php");
        }
    }
    if(isset($_POST['signup_btn']))
    {
        $name1 = $_POST['name'];
        $address1 = $_POST['address'];
        $phone1 = $_POST['phone'];
        $email1 = $_POST['mail'];
        $password1 = $_POST['pass'];
        $confirnPassword1 = $_POST['cpass'];
        if($password1 == $confirnPassword1)
        {
            $userSQL = "INSERT INTO tb_user (name, email, phone, address, password) VALUES ('$name1', '$email1', '$phone1', '$address1', '$password1')";
            if(mysqli_query($conn, $userSQL))
            {
                $message = '<p style="color:green;">Successfully registered. Now Let&#39;s Get Started!! (☞ﾟヮﾟ)☞</p>';
                // header("location:index.php");
            }
            else{
                $message = '<p style="color:red;">Registration Failed!! You may already registered with this email.</p>';
            }
        }
        else
        {
            $message = '<p style="color:red;">Password confirmation doesn&#39;t match password.</p>';
        }
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
                    <li class="nav-item"><a class="nav-link" href="community.php">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="requestbook.php">Request</a></li>
                    <?php if(!isset($_SESSION["user"]) || $_SESSION["user"]==NULL){ ?>
                    <li class="nav-item"><a class="nav-link" style="color:black;" href="logpage.php">LogIn/SignUp</a></li>
                    <?php }else{ ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fa fa-user" style="font-size: 17px;"></i></a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="shoppingbag.php"><i class="fa fa-cart-arrow-down" style="font-size: 17px;"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page">
        <!-- log in -->
        <section style="margin-top: 20px;">
            <div id="myDIV" class="container" style="display: block;">
                <div class="row">
                    <div class="col">
                        <div class="col-lg-12 align-justify-center pr-4 pl-0 contact-form banner6">
                            <div>
                                <h2 class="mb-3 font-weight-light">Welcome</h2>
                                <h6 class="subtitle font-weight-normal"><?php echo $message; ?></h6>
                                <form class="mt-3" action="" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group"><input name="maillog" class="form-control" type="email" placeholder="Email address" required/></div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group"><input name="passlog" class="form-control" type="password" placeholder="Password" required/></div>
                                        </div>
                                        <div class="col-lg-12"><button type="submit" name="login_btn" class="btn btn-md btn-block btn-danger-gradiant1 text-white border-0 shadow-none"><span> Sign In</span></button></div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-lg-12 text-center mt-4">
                                        <h6 class="font-weight-normal">Signin with Social Accounts</h6>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6"><a href="#" class="btn btn-block bg-facebook text-white mt-3">Facebook</a></div>
                                            <div class="col-lg-6 col-md-6"><a href="#" class="btn btn-block bg-twitter text-white mt-3">Twitter</a></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center mt-4">
                                        Not a member yet? <a style="cursor: pointer;" class="text-danger" onclick="myFunction()">Join Now</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-6 logpage_img"><img src="assets/img/banner/login.jpg" style="width: 100%;" /></div>
                </div>
            </div>
        </section>
        <!-- sign up -->
        <section style="margin-top: 20px;margin-bottom: 10px;">
            <div id="myDIV2" class="container" style="display: none;">
                <div class="row">
                    <div class="col-lg-6 col-xl-6 logpage_img"><img src="assets/img/banner/signup.png" style="width: 100%;" /></div>
                    <div class="col">
                        <div class="col-lg-12 align-justify-center pr-4 pl-0 contact-form banner6">
                            <div>
                                <h2 class="mb-3 font-weight-light">Get Register For Free</h2>
                                <h6 class="subtitle font-weight-normal"><?php echo $message; ?></h6>
                                <form class="mt-3" action="" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group"><input name="name" class="form-control" type="text" placeholder="Full name" required/></div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group"><input name="address" class="form-control" type="text" placeholder="Address" required/></div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group"><input name="phone" class="form-control" type="text" placeholder="Phone" required/></div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group"><input name="mail" class="form-control" type="email" placeholder="Email address" required/></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group"><input id="password" name="pass" class="form-control" type="password" placeholder="Password" required/></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group"><input id="confirm_password" name="cpass" class="form-control" type="password" placeholder="Confirm password" required/></div>
                                        </div>
                                        <div class="col-lg-12"><button type="submit" name="signup_btn" class="btn btn-md btn-block btn-danger-gradiant2 text-white border-0 shadow-none"><span> Create Account</span></button></div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-lg-12 text-center mt-4">
                                        <h6 class="font-weight-normal">Signup with Social Accounts</h6>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6"><a href="#" class="btn btn-block bg-facebook text-white mt-3">Facebook</a></div>
                                            <div class="col-lg-6 col-md-6"><a href="#" class="btn btn-block bg-twitter text-white mt-3">Twitter</a></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center mt-4">
                                        Already have an account? <a style="cursor: pointer;" class="text-danger" onclick="myFunction()">Sign In</a></div>
                                </div>
                            </div>
                        </div>
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
        function myFunction() {
            var x = document.getElementById("myDIV");
            var y = document.getElementById("myDIV2");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        }
    </script>
    <script>
        $('#password, #confirm_password').on('keyup', function ()  {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#confirm_password').css('border-color', 'lime');
            } 
            else{
                $('#confirm_password').css('border-color', 'red');
            }
        });
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