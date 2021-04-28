<?php
    session_start();
    include 'db.php';
    if(isset($_GET['book']))
    {
        $bookID = $_GET['book'];
        $bookdetailsSQL = "SELECT * FROM tb_books WHERE bookid = '$bookID'";
    }
    if(!empty($_SESSION['user'])){
        $user = $_SESSION['username'];
        $phone = $_SESSION['userphone'];
        $addr = $_SESSION['useraddress'];
    }else{
        $user = "As A Guest";
        $phone = "+880 ---- ------";
        $addr = "";
    }

    if(isset($_POST["req_btn"]))
    {
        $user = $_SESSION["user"];
        $bookidd = $_POST["bookid"];
        $price = $_POST["price"];
        $obprice = $_POST["obprice"];
        $vmem = $_POST["vmem"];
        $reason = $_POST["reason"];

        $freebookSQL = "INSERT INTO free_book_req(user, bookid, price, obprice, vm_em_id, reason) VALUES ('$user', '$bookidd', '$price', '$obprice', '$vmem', '$reason')";
        if(mysqli_query($conn, $freebookSQL))
        {
            header("location:vcatalog.php");
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
    <main>
        <section>
            <div class="container shadow" style="margin-top: 100px;background-color: #FFFFFF;padding: 20px;margin-bottom: 10px;">
                <div style="margin-left: 15px;margin-right: 15px;">
                    <div class="row">
                        <div class="col-md-6 col-lg-5 col-xl-4">
                        <form action="" method="POST">
                        <?php
                            $result = mysqli_query($conn, $bookdetailsSQL);
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $image = "bookcover/".$row['image'];
                        ?>
                            <div class="text-center"><img src="<?php echo $image; ?>" style="width: 100%;height: 400px;border: 1px solid rgb(231,231,231);padding: 30px;"></div><span class="badge badge-secondary"><?php echo $row['bookstate'] ?></span>
                            <h5><strong><?php echo $row['name'] ?></strong></h5>
                            <p style="font-size:14px;">By <strong style="color:rgb(68,89,108);"><?php echo $row['author'] ?></strong></p>
                            <p style="font-size:14px;">Publisher : <strong style="color:rgb(68,89,108);"><?php echo $row['publisher'] ?></strong></p>
                            <p style="font-size: 13px;">Category : <a href="" style="text-decoration: none; color: rgb(8, 140, 255);"><?php echo $row['category'] ?></a></p>
                            <div>
                            <input type='hidden' name='bookid' value="<?php echo $row['bookid'] ?>" />
                            <input type='hidden' name='price' value="<?php echo $row['price'] ?>" />
                            <input type='hidden' name='obprice' value="<?php echo $row['obprice'] ?>" />
                                <div class="d-inline-flex">
                                <p><?php echo "New : ৳ $row[price]" ?>&nbsp; &nbsp;&nbsp;</p>
                                        <p style="font-size: 12px; color:red;"><span
                                                style="text-decoration: line-through;"><?php if($row['discount']>'0')echo $row['discount'] ?></span>&nbsp; &nbsp;&nbsp;
                                        </p>
                                        <p>||&nbsp;&nbsp;&nbsp;&nbsp;<?php if($row['obprice']>'0')echo "Old : ৳ $row[obprice]" ?>&nbsp; &nbsp;&nbsp;</p>
                                </div>
                            </div>
                            <p style="color: green;"><i class="fa fa-bookmark-o"></i>&nbsp;In Stock</p><a href="#" style="color: var(--danger);font-size: 14px;"><i class="fa fa-info-circle"></i>&nbsp;Report any issue</a>
                        </div>
                        <div class="col" style="border: 1px solid rgb(231,231,231);padding: 30px;">
                            <div class="d-flex justify-content-between">
                                <h6><strong>Name :</strong> <?php echo $user; ?> </h6>
                                <h6><strong>Phone :</strong> <?php echo $phone; ?> </h6>
                            </div>
                            <h6><strong>Address :</strong></h6><p class="form-control"><?php echo $addr; ?></p>
                            <div class="d-flex justify-content-between" style="margin-top: 5px;">
                                <h6 style="margin-top: 5px;font-size: 14px;"><strong>VM ID / EM ID :</strong></h6>
                                <div><span class="badge badge-info" data-toggle="tooltip" data-bss-tooltip="" title="Contact with us / check FAQ for more info about Volunteer member (VM) id or Eligible member (EM) id." style="border-radius: 12px;">?</span></div>
                            </div><input type="text" class="form-control" name="vmem">
                            <p class="text-center" style="font-size: 12px;margin-top: 10px;margin-bottom: 0;">Or</p>
                            <h6><strong>Kindly tell us the reason for this request :</strong></h6><textarea class="form-control" name="reason"></textarea>
                            <div><button class="btn btn-info btn-sm mt-3 shadow-none" type="submit" name="req_btn" <?php if(empty($_SESSION['user']) || !isset($_SESSION['user'])){ ?>disabled <?php } ?>><i class="fa fa-paper-plane-o"></i>&nbsp;SEND</button><button class="btn btn-sm mt-3 ml-3" type="button" onclick="location.href='requestorbuy.php?book=<?php echo $row['bookid']; ?>'"><i class="fa fa-mail-forward" style="transform: rotate(180deg);"></i>&nbsp;Go Back</button></div>
                        </div>
                    </div>
                    <?php
                                }
                            } else {
                            echo "0 results";
                            }
                        ?>
                </div>
                </form>
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