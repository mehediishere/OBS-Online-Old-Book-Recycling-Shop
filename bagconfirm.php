<?php 
    session_start();
    include 'db.php';
    $output = "";
    $_SESSION['orderCNF'] = "";
    if(!isset($_SESSION["totalprice"]) || !isset($_SESSION["shopping_cart"]) || !isset($_SESSION["user"]) || $_SESSION["user"] == NULL)
    {
        header("location:shoppingbag.php");
    }
    if(isset($_POST["cnf_order"]))
    {
        $user = $_SESSION["user"];
        $note = $_POST["note"];
        $sbname = $_POST["sbname"];
        $sprice = $_POST["sprice"];
        $snote = $_POST["snote"];
        $totalprice = $_SESSION["totalprice"]+30;
        $status = "Processing";

        $filename = $_FILES["simage"]["name"];
        $tempname = $_FILES["simage"]["tmp_name"];
        $folder = "order_with_sell/" . $filename;

        $invoice = mt_rand(1,99999);
        foreach ($_SESSION["shopping_cart"] as $product)
        {
            if(!empty($sbname))
            {
                $orderSQL = "INSERT INTO tb_order_ws(invoice, useremail, bookid, bookname, bstate, quantity, price, totalprice, note, sbname, sprice, snote, simage, status) VALUES ('$invoice', '$user', '$product[bookid]', '$product[name]', '$product[bstate]', '$product[quantity]', '$product[fprice]', '$totalprice', '$note', '$sbname', '$sprice', '$snote', '$filename','$status')";
            }
            else
            {
                $orderSQL = "INSERT INTO tb_order(invoice, useremail, bookid, bookname, bstate, quantity, price, totalprice, note, status) VALUES ('$invoice', '$user', '$product[bookid]', '$product[name]', '$product[bstate]', '$product[quantity]', '$product[fprice]', '$totalprice', '$note','$status')";
            }
            
            if(mysqli_query($conn, $orderSQL))
            {
                move_uploaded_file($tempname, $folder);
                unset($_SESSION['shopping_cart'], $_SESSION['totalprice']);
                header("location:shoppingbag.php");
                $_SESSION['orderCNF'] = "<div style='color:green; margin-bottom:10px;'><i class='fa fa-check' aria-hidden='true'></i> Your order has been placed successfully. </div>";
            }
            else
            {
                $output = "<div style='color:red; margin-bottom:10px;'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> We were unable to process your order, Please try again or contact with us at <span style='color:blue;'> +8801957*20456 / obs@mail.com </span> </div>";
            }
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
                    <li class="nav-item"><a class="nav-link" href="requestbook.php">Request</a></li>
                    <?php if(!isset($_SESSION["user"]) || $_SESSION["user"]==NULL){ ?>
                    <li class="nav-item"><a class="nav-link" href="logpage.php">LogIn/SignUp</a></li>
                    <?php }else{ ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fa fa-user"
                                style="font-size: 17px;"></i></a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="shoppingbag.php"><i class="fa fa-cart-arrow-down"
                                style="font-size: 17px; color:black;"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page" style="margin-top: 2rem;">
        <section>
            <div class="container">
            <?php echo $output; ?>
                <div class="row">
                        <div class="col mr-3" style="border: 1px solid rgb(204,204,204);">
                    <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mt-2 mb-2"><a class="btn btn-outline-primary btn-block shadow-none"
                                    data-toggle="collapse" aria-expanded="false" aria-controls="collapse-1"
                                    href="#collapse-1" role="button">I Would Like To Sell/Exchange My Books</a>
                                <div class="collapse mt-2" id="collapse-1">
                                    <div class="form-group">
                                        <input class="form-control mb-2" type="text" name="sbname" placeholder="Book1, Book2, ...">
                                        <input class="form-control mb-2" type="text" name="sprice" placeholder="Expected Price. Kindly be realistic.">
                                        <textarea class="form-control mb-2" placeholder="Details / Your notes" name="snote"></textarea>
                                        <input type="file" name="simage">
                                        <br><small>Note: If there many books please take picture of them at one place at front side.</small>
                                    </div>
                                </div>
                            </div>
                            <p style="color: red;font-size: 12px;"><br>*Please fill the form &amp; wait for our member call to confirm / further discuss your request or keep an eye on your email.<br><br></p>
                        </div>
                        <div class="col" style="border: 1px solid rgb(204,204,204);">
                            <div class="row mt-2 mb-2">
                                <div class="col">
                                    <p><?php echo $_SESSION["username"]; ?></p>
                                </div>
                                <div class="col" align="right">
                                    <p>+88<?php echo $_SESSION["userphone"]; ?></p>
                                </div>
                            </div>
                            <p><?php echo $_SESSION["useraddress"]; ?></p>
                            <textarea class="form-control mb-2" placeholder="Your short note" name="note"></textarea>
                            <p>Total Amount :&nbsp;<strong>৳ <?php echo $_SESSION["totalprice"]; ?></strong></p>
                            <p>Delivery Cost (+) :&nbsp;<strong> ৳ 30 </strong></p>
                            <p style="font-size:12px;"><i class="fas fa-truck"></i>&nbsp;Cash on Delivery</p>
                            <div class="text-center"><button class="btn btn-success shadow-none mb-2" type="submit" name="cnf_order" style="background: var(--teal);" <?php if(empty($_SESSION["shopping_cart"]) || !isset($_SESSION["user"]) || isset($_SESSION["user"])==NULL){ ?> disabled <?php } ?>>Confirm Order</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
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