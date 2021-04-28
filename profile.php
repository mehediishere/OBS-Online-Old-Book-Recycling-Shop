<?php
    session_start();
    include 'db.php';
    if(!isset($_SESSION["user"]) || $_SESSION["user"]==NULL){
        header("location:index.php");
    }
    if(isset($_POST['logout_btn'])){
        $_SESSION["user"]="";
        $_SESSION["username"] = "";
        $_SESSION["userphone"] = "";
        $_SESSION["useraddress"] = "";
        header("location:index.php");
    }
    if(isset($_POST['update_info']))
    {
        $filename = $_FILES["pic"]["name"];
        $tempname = $_FILES["pic"]["tmp_name"];
        $folder = "assets/img/user/" . $filename;
        if($filename != NULL)
        {
            $updateSQL = "UPDATE tb_user SET `name`='$_POST[name]', `gender`='$_POST[gender]', `occupation`='$_POST[occupation]', `email`='$_POST[email]', `email2`='$_POST[email2]', `phone`='$_POST[phone]', `phone2`='$_POST[phone2]', `address`='$_POST[address]', `address2`='$_POST[address2]', `image`='$filename' WHERE `userid`='$_POST[userid]'";
        }
        else
        {
            $updateSQL = "UPDATE tb_user SET `name`='$_POST[name]', `gender`='$_POST[gender]', `occupation`='$_POST[occupation]', `email`='$_POST[email]', `email2`='$_POST[email2]', `phone`='$_POST[phone]', `phone2`='$_POST[phone2]', `address`='$_POST[address]', `address2`='$_POST[address2]' WHERE `userid`='$_POST[userid]'";
        }

        if(mysqli_query($conn, $updateSQL))
        {
            move_uploaded_file($tempname, $folder);
            echo "<script> alert('Account info successfully updated.'); </script>";
        }
        else{ echo mysqli_error($conn); }
    }
    if(isset($_POST['create_post']))
    {
        $filename = $_FILES["postpic"]["name"];
        $tempname = $_FILES["postpic"]["tmp_name"];
        $folder = "assets/posts/" . $filename;

        $details = mysqli_real_escape_string($conn,$_POST['details']);
        
        $createPostSQL = "INSERT INTO tb_post(user, title, details, price, category, city, institution, image) VALUES ('$_SESSION[user]', '$_POST[posttitle]', '$details', '$_POST[price]' , '$_POST[category]', '$_POST[city]', '$_POST[ins]', '$filename')";
        if(mysqli_query($conn, $createPostSQL))
        {
            move_uploaded_file($tempname, $folder);
        }else{
            echo "<script> alert('Failed to create post. Please try again or contact support.'); </script>";
        }
    }
    if(isset($_POST['delete_post']))
    {
        $postid  =  $_POST['postid'];
        $postimage  =  $_POST['postimage'];
        // echo "<script> alert($postid); </script>";
        $deleteSql = "DELETE FROM tb_post WHERE `srl`='$postid'";
        if (mysqli_query($conn, $deleteSql)) 
        {
            $q1="SET @num := 0";
            $q2="UPDATE tb_post SET srl = @num := (@num+1)";
            $q3="ALTER TABLE tb_post AUTO_INCREMENT = 1";
            mysqli_query($conn,$q1);
            mysqli_query($conn,$q2);
            mysqli_query($conn,$q3);

            $file_to_delete = "assets/posts/".$postimage;
            if($postimage != NULL) {
                unlink($file_to_delete);
            }
        }

    }

    if(isset($_POST['req_form_btn']))
    {
        $bcnfname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `bookid` FROM `tb_books` WHERE `name` = '$_POST[book]'"));
        if($bcnfname['bookid'] != NULL)
        {
            $reqFormSql = "INSERT INTO `free_book_req`(user, bookid, fr_author, fr_isbn, vm_em_id, bookstate, reason) VALUES ('$_SESSION[user]', '$bcnfname[bookid]', '$_POST[author]', '$_POST[isbn]', '$_POST[vm]', '$_POST[state]', '$_POST[reason]')";
            if(mysqli_query($conn, $reqFormSql))
            {
                echo "<script> alert('Successfully placed request. We will contact with you soon.'); </script>";
            }
            else{
                echo "<script> alert('Failed request. try again or kindly contact with us.'); </script>";
            }
        }else{
            echo "<script> alert('Not found the book you are looking for. Please check category section for volunteer/free books you are requesting for. (Note: Requested book name had to be same)'); </script>";
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

<body style="background-color: #F6F6F6;">
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
                    <?php if(!isset($_SESSION["user"])){ ?>
                    <li class="nav-item"><a class="nav-link" href="logpage.php">LogIn/SignUp</a></li>
                    <?php }else{ ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fa fa-user"
                                style="font-size: 17px; color:black;"></i></a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="shoppingbag.php"><i class="fa fa-cart-arrow-down"
                                style="font-size: 17px;"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page" style="margin-top: 20px;">
        <section>
            <div class="container">
                <div class="row" style="margin-bottom: 20px;">
                    <?php 
                        $image2 = "assets/img/scenery/image1.jpg";
                        $userinfoSQL = "SELECT * FROM tb_user WHERE `email` = '$_SESSION[user]'";
                        $result = mysqli_query($conn, $userinfoSQL);
                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $image = "assets/img/user/".$row['image'];
                    ?>
                <!-- nav button -->
                    <div class="col-md-4 col-lg-3 col-xl-3 text-center"
                        style="background-color: white;margin-right: 10px;padding: 0;">
                        <div style="padding-top: 10px;"><img class="profile_img" src="<?php if($row['image'] == NULL){ echo $image2; }else{ echo $image; } ?> ">
                        </div>
                        <h6 class="badge badge-pill badge-info" style="margin-top: 5px;/*color: var(--gray);*/">
                            <strong><?php echo $row['name']; ?></strong></h6>
                            <button class="btn btn-block text-left shadow-none btn_profile" id="order_list_btn" type="button"><i
                            class="fa fa-list-alt"></i>&nbsp;Order List</button>
                            <button class="btn btn-block text-left shadow-none" id="create_post_btn" type="button"><i
                            class="fa fa-wpforms"></i>&nbsp;Create Post</button>
                            <button class="btn btn-block text-left shadow-none" id="req_book_btn" type="button"><i
                            class="fa fa-book"></i>&nbsp;Request Book</button>
                            <button class="btn btn-block text-left shadow-none" id="volunteer_btn" type="button"><i
                            class="fa fa-book"></i>&nbsp;Be A Volunteer</button>
                            <button class="btn btn-block text-left shadow-none" id="personal_info_btn"
                            type="button"><i class="fa fa-user"></i>&nbsp;Personal Information</button>
                            <button class="btn btn-block text-left shadow-none" id="update_info_btn" type="button"><i
                                class="fa fa-pencil-square-o"></i>&nbsp;Update Information</button>
                            <button class="btn btn-block text-left shadow-none" id="cng_password_btn" type="button"><i
                                class="fa fa-low-vision"></i>&nbsp;Change Password</button>
                        <form action="" method="POST">
                            <button class="btn btn-block text-left shadow-none" name="logout_btn" type="submit"><i
                                    class="fa fa-sign-out"></i>&nbsp;Log Out</button>
                        </form>
                    </div>
                    <div class="col" style="background-color: white;padding-top: 10px;">
                        <!-- display user information -->
                        <div id="page_display_info" style="display: none;">
                            <h5 style="color: var(--gray);font-size: 18px;"><i class="fa fa-th-list"></i>&nbsp;Personal
                                Information</h5>
                            <hr>
                            <p style="font-size: 14px;"><strong>Name :</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $row['name']; ?></p>
                            <p style="font-size: 14px;"><strong>Gender :</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $row['gender']; ?></p>
                            <p style="font-size: 14px;"><strong>Occupation :</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; <?php echo $row['occupation']; ?></p>
                            <p style="font-size: 14px;"><strong>Contact Number :</strong>&nbsp; <?php echo $row['phone']; ?></p>
                            <p style="font-size: 14px;"><strong>A member since :</strong>&nbsp; &nbsp;<?php echo $row['reg_date']; ?></p>
                            <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                    class="fa fa-th-list"></i>&nbsp;Contact Information</h5>
                            <hr>
                            <p style="font-size: 14px;"><strong>Email Address 1 :</strong>&nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp;<?php echo $row['email']; ?></p>
                            <p style="font-size: 14px;"><strong>Email Address 2(Optional) :</strong>&nbsp; &nbsp; &nbsp;
                                &nbsp; <?php echo $row['email2']; ?></p>
                            <p style="font-size: 14px;"><strong>Contact Number 1 :</strong>&nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $row['phone']; ?></p>
                            <p style="font-size: 14px;"><strong>Contact Number 2 (Optional) :</strong>&nbsp; &nbsp;<?php echo $row['phone2']; ?>
                            </p>
                            <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                    class="fa fa-th-list"></i>&nbsp;Residence Address</h5>
                            <hr>
                            <p style="font-size: 14px;"><strong>Address 1 :</strong>&nbsp;<?php echo $row['address']; ?></p>
                            <p style="font-size: 14px;"><strong>Address 1 :</strong>&nbsp;<?php echo $row['address2']; ?></p>
                        </div>
                        <!-- update user information -->
                        <form action="" method="POST" enctype="multipart/form-data">
                        <input type='hidden' name='userid' value="<?php echo $row['userid'] ?>" />
                        <div id="page_edit_info" style="display: none;">
                            <div>
                                <h5 style="color: var(--gray);font-size: 18px;"><iclass="fa fa-th-list"></i>&nbsp;Personal Information</h5>
                                <hr>
                                <span style="padding-top: 5px;font-size: 14px;"><strong>Name :&nbsp; &nbsp; &nbsp;
                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                        &nbsp;&nbsp;</strong><input type="text" class="form-control" placeholder="NAME"
                                        style="font-size: 10px;width: 50%;" name="name" value="<?php echo $row['name']; ?>"></span>
                                <span class="d-block" style="font-size: 14px;"><strong>Gender :&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong><input type="text"
                                        class="form-control" placeholder="GENDER"
                                        style="font-size: 10px;width: 50%;margin-bottom: 10px;" name="gender" value="<?php echo $row['gender']; ?>"
                                        autocomplete="on" minlength="4" maxlength="12"></span>
                                <span style="font-size: 14px;"><strong>Occupation :&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                        &nbsp; &nbsp; &nbsp;&nbsp;</strong><input type="text" class="form-control"
                                        placeholder="OCCUPATION" style="font-size: 10px;width: 50%;margin-bottom: 10px;"
                                        value="<?php echo $row['occupation']; ?>" autocomplete="on" minlength="4" maxlength="12" name="occupation" ></span>
                                        <p style="font-size: 14px;"><strong>Contact Number :</strong>&nbsp; <?php echo $row['phone']; ?></p>
                            </div>
                            <div style="padding-top: 20PX;">
                                <h5 style="color: var(--gray);font-size: 18px;"><i
                                        class="fa fa-th-list"></i>&nbsp;Contact Information</h5>
                                <hr><span style="padding-top: 5px;font-size: 14px;"><strong>Email Address 1 :&nbsp;
                                        &nbsp; &nbsp; &nbsp; &nbsp;</strong><input type="text" class="form-control"
                                        placeholder="EMAIL" style="font-size: 10px;width: 50%;margin-bottom: 10px;"
                                        inputmode="email" name="email" value="<?php echo $row['email']; ?>"></span>
                                <span style="font-size: 14px;"><strong>Email Address 2 :&nbsp; &nbsp; &nbsp; &nbsp;
                                        &nbsp;</strong><input type="text" class="form-control"
                                        placeholder="EMAIL (OPTIONAL)"
                                        style="font-size: 10px;width: 50%;margin-bottom: 10px;" name="email2" value="<?php echo $row['email2']; ?>"
                                        autocomplete="on" minlength="4" maxlength="12"></span><span
                                    style="font-size: 14px;"><strong>Contact Number 1 :&nbsp; &nbsp;
                                        &nbsp;</strong><input type="text" class="form-control"
                                        placeholder="PHONE NUMBER"
                                        style="font-size: 10px;width: 50%;margin-bottom: 10px;" autocomplete="on"
                                        maxlength="11" name="phone" value="<?php echo $row['phone']; ?>"></span>
                                <span style="font-size: 14px;"><strong>Contact Number 2 :&nbsp;
                                        &nbsp;&nbsp;</strong><input type="text" class="form-control"
                                        placeholder="PHONE NUMBER (OPTIONAL)"
                                        style="font-size: 10px;width: 50%;margin-bottom: 10px;"
                                        autocomplete="on" maxlength="11" name="phone2" value="<?php echo $row['phone2']; ?>"></span>
                            </div>
                            <div style="padding-top: 20PX;">
                                <h5 style="color: var(--gray);font-size: 18px;"><i
                                        class="fa fa-th-list"></i>&nbsp;Residence Information</h5>
                                <hr><span style="padding-top: 5px;font-size: 14px;"><strong>Address 1 :&nbsp; &nbsp;
                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong><input
                                        type="text" class="form-control" placeholder="Delivery Address"
                                        style="font-size: 10px;width: 50%;margin-bottom: 10px;"
                                        name="address" value="<?php echo $row['address']; ?>"></span>
                                <span style="font-size: 14px;"><strong>Address 2 :&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong><input type="text"
                                        class="form-control" placeholder="(OPTIONAL)"
                                        style="font-size: 10px;width: 50%;margin-bottom: 10px;"
                                        autocomplete="on" minlength="4" maxlength="12" name="address2" value="<?php echo $row['address2']; ?>"></span>
                            </div>
                            <div style="padding-top: 20px;">
                                <h5 style="color: var(--gray);font-size: 18px;"><i
                                        class="fa fa-th-list"></i>&nbsp;Profile Picture</h5>
                                <hr>
                                <div>
                                    <div class="container py-5">

                                        <div class="row py-4">
                                            <div class="col-lg-6 mx-auto">

                                                <!-- Upload image input-->
                                                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                                    <input id="upload" name="pic" type="file" onchange="readURL(this);"
                                                        class="form-control border-0">
                                                    <label id="upload-label" for="upload"
                                                        class="font-weight-light text-muted">Choose file</label>
                                                    <div class="input-group-append">
                                                        <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                                            <i class="fa fa-cloud-upload mr-2 text-muted"></i><small
                                                                class="text-uppercase font-weight-bold text-muted">Choose
                                                                file</small></label>
                                                    </div>
                                                </div>
                                                <!-- Uploaded image area-->
                                                <div id="display_img" style="display: none;">
                                                    <p class="text-center">Image preview</p>
                                                    <div class="image-area mt-4" style="border-color: gray;"><img
                                                            id="imageResult" style="width: 200px; height: 200px;"
                                                            src="#" alt=""
                                                            class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 20px;margin-bottom: 20px;"><button
                                    class="btn btn-success btn-sm shadow-none" type="submit" name="update_info">UPDATE</button><a
                                    class="btn btn-danger btn-sm shadow-none" role="button"
                                    href="profile.html">CANCEL</a></div>
                        </div>
                        </form>
                        <?php
                                }
                            }else{
                                echo "Contact with obs support team.";
                            }
                        ?>
                        <!-- order list -->
                        <div id="page_order_list" style="min-height: 600px;">
                            <!-- order track -->
                                <?php
                                    $n=0; $inv=0; $p=0; $c=0; $cm=0; $cn=0;
                                    $ok1 = "SELECT * FROM tb_order WHERE `useremail` = '$_SESSION[user]'";
                                    $ok2 = mysqli_query($conn, $ok1);
                                        if(mysqli_num_rows($ok2)>0){
                                            while($ok3 = mysqli_fetch_assoc($ok2)){
                                                if($ok3['invoice'] != $inv){
                                                    $n += 1;
                                                    $inv = $ok3['invoice'];
                                                    switch($ok3['status']){
                                                        case ("Processing"):
                                                            $p += 1;
                                                            break;
                                                        case ("Confirmed"):
                                                            $c += 1;
                                                            break;
                                                        case ("Completed"):
                                                            $cm += 1;
                                                            break;
                                                        case ("Canceled"):
                                                            $cn += 1;
                                                            break;
                                                        default:
                                                            break; 
                                                    }
                                                }
                                            }
                                        }
                                        $inv=0;
                                        $ok4 = "SELECT * FROM tb_order_ws WHERE `useremail` = '$_SESSION[user]'";
                                        $ok5 = mysqli_query($conn, $ok4);
                                            if(mysqli_num_rows($ok5)>0){
                                                while($ok6 = mysqli_fetch_assoc($ok5)){
                                                    if($ok6['invoice'] != $inv){
                                                        $n += 1;
                                                        $inv = $ok6['invoice'];
                                                        switch($ok6['status']){
                                                            case ("Processing"):
                                                                $p += 1;
                                                                break;
                                                            case ("Confirmed"):
                                                                $c += 1;
                                                                break;
                                                            case ("Completed"):
                                                                $cm += 1;
                                                                break;
                                                            case ("Canceled"):
                                                                $cn += 1;
                                                                break;
                                                            default:
                                                                break; 
                                                        }
                                                    }
                                                }
                                            }
                                    ?>
                                <div class="row" style="margin-left: 0.5px;">
                                    <div class="col mr-3 shadow-sm py-2" style="background-color: #F0F6FD">
                                        <span><h6>Total Order</h6></span>
                                        <span style="font-size: 20px; color: gray;"><i class="fas fa-truck-loading" style="transform: scaleX(-1);"></i>&nbsp; <?php echo $n; ?></span>
                                        <div class="float-right">
                                            <span class="badge badge-pill badge-warning">Processing : <?php echo $p;?></span>
                                            <span class="badge badge-pill badge-info">Confirmed : <?php echo $c;?></span>
                                            <span class="badge badge-pill badge-success">Completed : <?php echo $cm;?></span>
                                            <span class="badge badge-pill badge-danger">Canceled : <?php echo $cn;?></span>
                                        </div>
                                    </div>
                                </div>
                            <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                    class="fa fa-th-list"></i>&nbsp;Order List</h5>
                            <hr>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Product</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $orderQuery = "SELECT * FROM tb_order WHERE `useremail` = '$_SESSION[user]' ORDER BY srl DESC";
                                    $orderQuery2 = "SELECT * FROM tb_order_ws";
                                    
                                    $checkDuplicate = 0;
                                    $normalOrder = mysqli_query($conn, $orderQuery);
                                        if(mysqli_num_rows($normalOrder)>0){
                                            while($orderRow = mysqli_fetch_assoc($normalOrder)){
                                                if($orderRow['invoice'] != $checkDuplicate){
                                                    $checkDuplicate = $orderRow['invoice'];
                                    ?>
                                        <tr>
                                            <td><?php echo $orderRow['invoice'] ?></td>
                                            <td><?php echo $orderRow['order_time'] ?></td>
                                            <td><?php echo $orderRow['totalprice'] ?>/=</td>
                                            <td><span class="badge badge-info"
                                                    style="color: #d2d2d2;background: rgb(214,213,213);"><a href="#"
                                                        style="color: var(--dark);text-decoration: none;">Check
                                                        Details</a></span></td>
                                            <td>
                                                <span class="badge <?php if($orderRow['status']=="Canceled"){ ?>badge-danger<?php } 
                                                                        elseif($orderRow['status']=="Confirmed"){?>badge-info<?php }
                                                                        elseif($orderRow['status']=="Completed"){?>badge-success<?php } else{?>badge-warning<?php } ?>">
                                                    <?php echo $orderRow['status']; ?>
                                                <span>
                                            </td>
                                        </tr>
                                    <?php }
                                        }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                            <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                    class="fa fa-th-list"></i>&nbsp;Order List ( ৳ + Using Exchange Books)</h5>
                            <hr>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Product</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $orderQuery = "SELECT * FROM tb_order_ws WHERE `useremail` = '$_SESSION[user]' ORDER BY srl DESC";
                                    $orderQuery2 = "SELECT * FROM tb_order_ws";
                                    $checkDuplicate = 0;
                                    $normalOrder = mysqli_query($conn, $orderQuery);
                                        if(mysqli_num_rows($normalOrder)>0){
                                            while($orderRow = mysqli_fetch_assoc($normalOrder)){
                                                if($orderRow['invoice'] != $checkDuplicate){
                                                    $checkDuplicate = $orderRow['invoice'];
                                    ?>
                                        <tr>
                                            <td><?php echo $orderRow['invoice'] ?></td>
                                            <td><?php echo $orderRow['order_time'] ?></td>
                                            <td><?php echo $orderRow['totalprice'] ?>/=</td>
                                            <td><span class="badge badge-info"
                                                    style="color: #d2d2d2;background: rgb(214,213,213);"><a href="#"
                                                        style="color: var(--dark);text-decoration: none;">Check
                                                        Details</a></span></td>
                                            <td><span class="badge <?php if($orderRow['status']=="Canceled"){ ?>badge-danger<?php } 
                                                            elseif($orderRow['status']=="Confirmed"){?>badge-info<?php }
                                                            elseif($orderRow['status']=="Completed"){?>badge-success<?php } else{?>badge-warning<?php } ?>">
                                        <?php echo $orderRow['status']; ?>
                                    <span></td>
                                        </tr>
                                    <?php } } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- create post -->
                        <div id="page_create_post" style="display: none;">
                            <form action="" method="POST" enctype="multipart/form-data">
                            <div>
                                <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                        class="fa fa-pencil"></i>&nbsp;Create New Post</h5>
                                <hr><select class="form-control mb-3" name="category">
                                    <optgroup label="Select Category">
                                        <option value="NonAcademic" selected>Non Academic</option>
                                        <option value="School">School</option>
                                        <option value="College">College</option>
                                        <option value="University">University</option>
                                    </optgroup>
                                </select><input type="text" name="ins" class="form-control mb-3"
                                    placeholder="Your Institution (This will help your fellow students to search from same institute)">
                                <div class="row">
                                    <div class="col"><input type="file" name="postpic" class="form-control mb-3"><input type="text"
                                            name="price" class="form-control mb-3" placeholder="Price Ex. 299tk / Contact with me / Free">
                                            <select class="form-control mb-3" name="city">
                                                <optgroup label="Select Category">
                                                    <option value="Dhaka" selected>Dhaka</option>
                                                    <option value="Gazipur">Gazipur</option>
                                                    <option value="Chittagong">Chittagong</option>
                                                    <option value="	Comilla">Comilla</option>
                                                    <option value="	Khulna">Khulna</option>
                                                </optgroup>
                                            </select>
                                    </div>
                                    <div class="col"><input type="text" name="posttitle" class="form-control mb-3"
                                            placeholder="Title"><textarea class="form-control" spellcheck="true"
                                            rows="10" placeholder="Details" name="details"></textarea></div>
                                </div><button class="btn btn-info btn-block shadow-none mt-3"
                                    type="submit" name="create_post">POST</button>
                            </div>
                            </form>
                            <!-- <form action="" method="POST" enctype="multipart/form-data"> -->
                            <div>
                                <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                        class="fa fa-trash"></i>&nbsp;Remove Post</h5>
                                <hr>
                                <div><a class="btn shadow-none remove_btn mb-3" data-toggle="collapse"
                                        aria-expanded="false" aria-controls="collapse-1" href="#collapse-1"
                                        role="button">See Posts</a>
                                    <div class="collapse" id="collapse-1">
                                        <div>
                                            <hr>
                                            <?php 
                                                $viewPostSql = "SELECT * FROM tb_post WHERE `user`='$_SESSION[user]'";
                                                $postResult = mysqli_query($conn, $viewPostSql);
                                                if (mysqli_num_rows($postResult) > 0) {
                                                while($row = mysqli_fetch_assoc($postResult)) {
                                                    $image_src = "assets/posts/".$row['image'];
                                            ?>
                                            <div>
                                            <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="mb-3" style="padding: 0px 10px;">
                                                    <div class="row" style="border: 1px solid rgb(255,208,219);">
                                                        <div class="col-xl-9 mt-2">
                                                            <div class="d-inline-flex">
                                                            <input type="hidden" name="postid" value="<?php echo $row['srl']; ?>">
                                                            <input type="hidden" name="postimage" value="<?php echo $row['image']; ?>">
                                                                <span>
                                                                    <img src="<?php echo $image_src; ?>" style="width: 60px; height: 90px;" alt="">
                                                                </span>&nbsp;&nbsp;
                                                                <span>
                                                                    <p><strong><?php echo $row['title'] ?></strong> (Price : <?php echo $row['price'] ?>) </p>
                                                                    <p><?php echo $row['details'] ?><br></p>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col mt-2"><button class="btn btn-danger btn-block shadow-none" type="submit" name="delete_post"><i class="fa fa-trash-o"></i>&nbsp;DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                                        <?php } } ?>
                                        </div>
                                    </div>
                                </div>
                            <!-- </form> -->
                            </div>
                        </div>
                        <!-- requested book list -->
                        <div id="page_req_book" style="display: none;">
                            <div>
                                <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                        class="fa fa-th-list"></i>&nbsp;Requested Book For Availability</h5>
                                <hr>
                            </div>
                            <div style="min-height: 300px;">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#R.NO</th>
                                                <th>Book</th>
                                                <th>Author</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $orderQuery = "SELECT * FROM tb_req WHERE `user` = '$_SESSION[user]'";
                                        
                                        $normalOrder = mysqli_query($conn, $orderQuery);
                                            if(mysqli_num_rows($normalOrder)>0){
                                                while($orderRow = mysqli_fetch_assoc($normalOrder)){
                                        ?>
                                            <tr>
                                                <td><?php echo $orderRow['srl'] ?></td>
                                                <td><?php echo $orderRow['book'] ?></td>
                                                <td><?php echo $orderRow['author'] ?></td>
                                                <td><?php echo $orderRow['bookstate'] ?></td>
                                                <td><?php echo $orderRow['quantity'] ?></td>
                                                <td><?php echo $orderRow['note'] ?></td>
                                                <td>
                                                    <span class="badge <?php if($orderRow['status']=="Currently Not Available"){ ?>badge-danger<?php } 
                                                                            elseif($orderRow['status']=="Available Now"){?>badge-success<?php } else{?>badge-secondary<?php } ?>">
                                                        <?php echo $orderRow['status']; ?>
                                                    <span>
                                                </td>
                                            </tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="text-center">
                                <p>--- --------- ------&nbsp;-///- --- --------- ------</p>
                            </div>
                            <div>
                                <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                        class="fa fa-th-list"></i>&nbsp;Requested Book From VM-DN Section</h5>
                                <hr>
                            </div>
                            <div style="min-height: 300px;">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#R.NO</th>
                                                <th>Date</th>
                                                <th>Book</th>
                                                <th>Type</th>
                                                <th>VM/EM Id</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $orderQuery = "SELECT * FROM free_book_req WHERE `user` = '$_SESSION[user]'";
                                        $normalOrder = mysqli_query($conn, $orderQuery);
                                            if(mysqli_num_rows($normalOrder)>0){
                                                while($orderRow = mysqli_fetch_assoc($normalOrder)){
                                                    $bname = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `name`, `bookstate` FROM `tb_books` WHERE `bookid` = '$orderRow[bookid]'"));
                                        ?>
                                            <tr>
                                                <td><?php echo $orderRow['srl'] ?></td>
                                                <td><?php echo $orderRow['submit_time'] ?></td>
                                                <td><?php echo $bname['name'] ?></td>
                                                <td><?php if($orderRow['bookstate']!=NULL){ echo $orderRow['bookstate'];}else{ echo $bname['bookstate']; } ?></td>
                                                <td><?php echo $orderRow['vm_em_id'] ?></td>
                                                <td><?php echo $orderRow['reason'] ?></td>
                                                <td><span class="badge badge-secondary">On Review</span>
                                                </td>
                                            </tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form action="" method="POST">
                                <fieldset style="background-color: #eeeeee;padding: 10px;">
                                    <legend class="legend_attir" style="border-radius: 8px;">Request For Free /
                                        Volunteer Books :</legend><input class="form-control form-control-sm"
                                        type="text" style="width: 100%;margin-bottom: 10px;"
                                        placeholder="Book name" name="book"><input class="form-control form-control-sm" type="text"
                                        style="width: 100%;margin-bottom: 10px;"
                                        placeholder="Author name (optional)" name="author"><input class="form-control form-control-sm"
                                        type="text" style="width: 100%;margin-bottom: 10px;"
                                        placeholder="ISBN (optional)" name="isbn"><input class="form-control form-control-sm"
                                        type="text" style="width: 100%;margin-bottom: 10px;"
                                        placeholder="VM ID / EM ID (If you have any)" name="vm">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label style="color: #6c757d;">Quantity :</label>
                                                <select class="form-control form-control-sm"
                                                    id="exampleFormControlSelect1">
                                                    <option value="1">1</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label style="color: #6c757d;">Book Condition :</label>
                                                <select class="form-control form-control-sm"
                                                    id="exampleFormControlSelect1" name="state">
                                                    <option value="Any">Any</option>
                                                    <option>Old</option>
                                                    <option>New</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div><textarea class="form-control"
                                        placeholder="Kindly state your reason for request."
                                        style="margin-bottom: 10px;" name="reason"></textarea><button
                                        class="btn btn-info btn-sm shadow-none" type="submit" name="req_form_btn">SEND</button>
                                    <button class="btn btn-danger btn-sm shadow-none" type="reset">RESET</button>
                                </fieldset>
                            </form>
                        </div>
                        <!-- change password -->
                        <div id="page_cng_password" style="display: none;">
                            <div>
                                <h5 style="color: var(--gray);font-size: 18px;padding-top: 20px;"><i
                                        class="fa fa-th-list"></i>&nbsp;Change Password</h5><small>It is always
                                    recommended to use strong and non used and unique password using combination of
                                    number, letter, special character. For example : exam#ple12@kle</small>
                                <hr>
                            </div>
                            <div class="form-group">
                                <fieldset style="background-color: #eeeeee;padding: 10px;"><label
                                        style="font-size: 14px;">&nbsp;Current Password :<br></label><input
                                        class="form-control-sm form-control" type="password"
                                        style="margin-bottom: 10px;font-size: 12px;"><label
                                        style="font-size: 14px;">&nbsp;New Password :<br><small
                                            style="/*margin-bottom: 10px;*/font-size: 10px;">&nbsp;Input must contain at
                                            least one digit, one lowercase &amp; one uppercase letter and be at least
                                            6-20 characters long<br></small></label>
                                    <input class="form-control-sm form-control" type="password" required=""
                                        minlength="6" maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$"
                                        style="font-size: 12px;margin-bottom: 10px;"><label
                                        style="font-size: 14px;">&nbsp;Confirm Password :<br></label><input
                                        class="form-control-sm form-control" type="password" required="" minlength="6"
                                        maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$"
                                        style="font-size: 12px;margin-bottom: 10px;"><button
                                        class="btn btn-info btn-sm shadow-none" type="button">UPDATE</button><button
                                        class="btn btn-danger btn-sm shadow-none" type="button">CANCEL</button>
                                </fieldset>
                            </div>
                        </div>
                        <!-- volunteer page -->
                        <div id="page_volunteer" style="display: none;">
                        <?php $point = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `vm_point`, `em_point` FROM `tb_user` WHERE `email` = '$_SESSION[user]'")); ?>
                            <span
                                class="badge badge-warning border rounded-pill"
                                style="background-color: rgb(255,115,71);">Your VM Points : <?php echo $point['vm_point']; ?>
                            </span>
                            <span
                                class="badge badge-info border rounded-pill"
                                style="background-color: rgb(71, 191, 255);">Your EM Points : <?php echo $point['em_point']; ?>
                            </span>
                            <hr><img class="w-100 mb-3" src="assets/img/banner/become%20a%20volunteer.png">
                            <p class="text-justify">By donating books to OSB you can play a part in bringing the joy of
                                reading to many of people who might otherwise have no access to books. We rely on
                                donations of new/old/unwanted books from you to supply our readers with the
                                materials they need and offering people the opportunity to improve their own
                                knowledge.<br><br>Each year, donations from publishers enable us to supply up to one
                                million new books, benefiting people all over Bangladesh
                                annually. With your help we can change lives.<br><br><strong>Q.</strong> How can I send
                                books to OSB?<br><strong>A.</strong> We really appreciate if you can come over and have
                                a coffee along with us as well.<br>&nbsp; &nbsp;
                                &nbsp;If you are busy enough we can pick up for you as well. In this case there need to
                                have minimum&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;book
                                value.<br><strong>Q.</strong> Does OBS arrange any events?<br><strong>A.</strong> Yes.
                                At special occasion such as at the end of exam (SSC,<br>&nbsp; &nbsp; &nbsp; HSC), Ekuse
                                February or date on decision. Keep an eye on our website for
                                this.<br><strong>Q.</strong> How can I join Events?<br><strong>A.</strong> Just go to
                                event location and join with our other volunteers to have fun along with. You can
                                bring&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;books along with. We will evaluate book value and
                                give volunteer point if you registered.<br><br><strong><span
                                        style="text-decoration: underline;">CONTACT WITH
                                        US:</span></strong><br>+880195*752456<br>+8801836054*98<br>Email
                                : <a href="mailto:obs@gmail.com">obs@gmail.com</a><br>Office : 7th floor Sha-Ali Plaza,
                                Mirpur-10.<br><br></p>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#personal_info_btn").click(function() {
            $("#personal_info_btn").addClass("btn_profile");
            $("#update_info_btn, #order_list_btn, #req_book_btn, #cng_password_btn, #create_post_btn, #volunteer_btn")
                .removeClass("btn_profile");
            $("#page_display_info").show();
            $("#page_order_list, #page_edit_info, #page_req_book, #page_cng_password, #page_create_post, #page_volunteer")
                .hide();
        });
        $("#update_info_btn").click(function() {
            $("#update_info_btn").addClass("btn_profile");
            $("#personal_info_btn, #order_list_btn, #req_book_btn, #cng_password_btn, #create_post_btn, #volunteer_btn")
                .removeClass("btn_profile");
            $("#page_edit_info").show();
            $("#page_display_info, #page_order_list, #page_req_book, #page_cng_password, #page_create_post, #page_volunteer")
                .hide();
        });
        $("#order_list_btn").click(function() {
            $("#order_list_btn").addClass("btn_profile");
            $("#update_info_btn, #personal_info_btn, #req_book_btn, #cng_password_btn, #create_post_btn, #volunteer_btn")
                .removeClass("btn_profile");
            $("#page_order_list").show();
            $("#page_display_info, #page_edit_info, #page_req_book, #page_cng_password, #page_create_post, #page_volunteer")
                .hide();
        });
        $("#req_book_btn").click(function() {
            $("#req_book_btn").addClass("btn_profile");
            $("#update_info_btn, #order_list_btn, #personal_info_btn, #cng_password_btn, #create_post_btn, #volunteer_btn")
                .removeClass("btn_profile");
            $("#page_req_book").show();
            $("#page_edit_info, #page_order_list, #page_display_info, #page_cng_password, #page_create_post, #page_volunteer")
                .hide();
        });
        $("#cng_password_btn").click(function() {
            $("#cng_password_btn").addClass("btn_profile");
            $("#update_info_btn, #order_list_btn, #personal_info_btn, #req_book_btn, #create_post_btn, #volunteer_btn")
                .removeClass("btn_profile");
            $("#page_cng_password").show();
            $("#page_edit_info, #page_order_list, #page_display_info, #page_req_book, #page_create_post, #page_volunteer")
                .hide();
        });
        $("#create_post_btn").click(function() {
            $("#create_post_btn").addClass("btn_profile");
            $("#update_info_btn, #order_list_btn, #personal_info_btn, #req_book_btn, #cng_password_btn, #volunteer_btn")
                .removeClass("btn_profile");
            $("#page_create_post").show();
            $("#page_edit_info, #page_order_list, #page_display_info, #page_req_book, #page_cng_password, #page_volunteer")
                .hide();
        });
        $("#volunteer_btn").click(function() {
            $("#volunteer_btn").addClass("btn_profile");
            $("#update_info_btn, #order_list_btn, #personal_info_btn, #req_book_btn, #cng_password_btn, #create_post_btn")
                .removeClass("btn_profile");
            $("#page_volunteer").show();
            $("#page_edit_info, #page_order_list, #page_display_info, #page_req_book, #page_cng_password, #page_create_post")
                .hide();
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#upload").click(function() {
            $("#display_img").show();
        });
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