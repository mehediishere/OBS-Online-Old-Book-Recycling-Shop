<?php
    session_start();
    include 'db.php';
    $srcOutput="";
    $name=""; $gender=""; $occupation=""; $phone=""; $phone2=""; $address=""; $address2=""; $vm=""; $em="";
    $email=""; $email2=""; $userid="";
    
    if(isset($_GET['user']))
    {
        $userid = $_GET['user'];
        $srcSql = "SELECT * FROM tb_user WHERE userid = '$_GET[user]'";
        $result = mysqli_query($conn, $srcSql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $name=$row['name']; $gender=$row['gender']; $occupation=$row['occupation']; 
                $phone=$row['phone']; $phone2=$row['phone2']; 
                $address=$row['address']; $address2=$row['address2']; $vm=$row['vm_point']; 
                $em=$row['em_point']; $email=$row['email']; $email2=$row['email2'];
            }
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Data Found. </div>';
        }else{
            $srcOutput = '<div style="color:red;font-size:10px;"> No Data Found. </div>';
        }
    }
    
    if(isset($_POST['reset_btn']))
    {
        header("location:_users.php");
    }

    if(isset($_POST['delete_btn']))
    {
        $deleteSql = "DELETE FROM tb_user WHERE userid='$userid'";
        if (mysqli_query($conn, $deleteSql)) 
        {
            $q1="SET @num := 0";
            $q2="UPDATE tb_user SET userid = @num := (@num+1)";
            $q3="ALTER TABLE tb_user AUTO_INCREMENT = 1";
            mysqli_query($conn,$q1);
            mysqli_query($conn,$q2);
            mysqli_query($conn,$q3);

            header("location:_users.php");

            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Query successfully executed. </div>';
        }
        else
        {
            $srcOutput = '<div style="color:red;font-size:10px;"> Query failed to execute. </div>';
        }
    }

    if(isset($_POST['save_btn']))
    {
        $name=$_POST['inp1']; $gender=$_POST['inp2']; $occupation=$_POST['inp3']; 
        $phone=$_POST['inp4']; $phone2=$_POST['inp5']; $email=$_POST['inp6']; $email2=$_POST['inp7']; 
        $address=$_POST['inp8']; $address2=$_POST['inp9']; 
        $vm_point=$_POST['inp10']; $em_point=$_POST['inp11'];

        $updateSql = "UPDATE tb_user SET name='$name', gender='$gender', occupation='$occupation', phone='$phone', phone2='$phone2', email='$email', email2='$email2', address='$address', address2='$address2', vm_point='$vm_point', em_point='$em_point' WHERE userid='$userid'";
        if(mysqli_query($conn, $updateSql))
        {
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Data Successfully Updated. </div>';
        }else{
            $srcOutput = '<div style="color:red;font-size:10px;"> Data Failed To Update. </div>';
            echo("Error description: " . mysqli_error($conn));
        }
    }

    if(isset($_POST['src_btn']))
    {
        $var = $_POST['src_text'];
        $viewSql = "SELECT * FROM tb_user where userid LIKE '%$var%' OR name LIKE '%$var%' OR phone LIKE '%$var%' OR email LIKE '%$var%'";
    }elseif(isset($_POST['ascBtn']))
    {
        $viewSql = "SELECT * FROM tb_user ORDER BY userid ASC";
    }elseif(isset($_POST['descBtn']))
    {
        $viewSql = "SELECT * FROM tb_user ORDER BY userid DESC";
    }else
    {
        $viewSql = "SELECT * FROM tb_user";
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
    <div class="admin_nav" style="padding: 5px;">
        <h3><i class="fa fa-leanpub"></i>&nbsp;OBS</h3>
    </div>
    <div class="grid-container">
        <!-- navigation -->
        <div class="admin_nav grid-child" style="height: 100%;">
            <div class="row w-100" style="margin-bottom: -20px;padding-left: 10px;">
                <div class="col-xl-4"><img src="assets/img/avatars/mehedi.jpg"></div>
                <div class="col-xl-8">
                    <p>
                        <strong>Mehedi Hasan</strong><br>
                        <span style="font-size:12px; color:#D6D6D6;">Admin</span> <br>
                        <i class="fas fa-circle mr-2" style="color: var(--teal);font-size: 8px;"></i><span style="font-size:10px;">Online</span>
                    </p>
                </div>
            </div>
            <hr>
            <?php include '_admin_nav.php'; ?>
            <div class="d-flex justify-content-around footer_side_nav"><a href="#"><i class="fa fa-envelope"></i></a><a href="#"><i class="fa fa-shopping-bag"></i></a><a href="#"><i class="fa fa-cog"></i></a><a href="#"><i class="fa fa-power-off"></i></a></div>
        </div>
        
        <div class="admin_input">
            <div style="padding: 20px;">
            <form action="" method="POST">
                <div class="d-block d-flex justify-content-end"><input type="search" name="src_text" class="w-100 form-control" style="height: 31px;"><button class="btn btn-secondary shadow-none pb-4 mr-4 src_btn_admin" type="submit" name="src_btn">&nbsp;<i class="fa fa-search"></i></button><button class="btn btn-dark shadow-none ad_arrow_btn"
                        type="submit" name="ascBtn"><i class="fas fa-angle-up" style="font-size: 20px;"></i></button><button class="btn btn-dark shadow-none ad_arrow_btn" type="submit" name="descBtn"><i class="fas fa-angle-down" style="font-size: 20px;"></i></button>
                </div>
            </form>
                <div class="table-responsive table-bordered" style="max-height: 500px;">
                    <table class="table table-bordered table-hover table-dark">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody class="text-monospace">
                            <?php
                                // $viewSql = "SELECT * FROM tb_user";
                                $result = mysqli_query($conn, $viewSql);
                                if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $image_src = "assets/img/user/".$row['image'];
                            ?>
                            <tr>
                                <td><?php echo $row['userid']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><a href="?user=<?php echo $row['userid']; ?>" style="color:#FFB765;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <td>ID</td>
                                <td>User Name</td>
                                <td>Phone</td>
                                <td>Email</td>
                                <th>Edit</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <hr>
            <div>
                <form style="padding: 20px;" action="" method="POST">
                    <div class="form-group">
                        <?php echo "User Id : $userid ".$srcOutput; ?>
                        <input type="hidden" value="<?php echo $userid; ?> " name="inp12">
                        <input class="form-control" type="text" placeholder="User Name" value="<?php echo $name; ?> " name="inp1">
                        <input class="form-control" type="text" placeholder="Gender" value="<?php echo $gender; ?> " name="inp2">
                        <input class="form-control" type="text" placeholder="Occupation" value="<?php echo $occupation; ?> " name="inp3">
                        <input class="form-control" type="text" placeholder="Phone 1" value="<?php echo $phone;?> " name="inp4">
                        <input class="form-control" type="text" placeholder="Phone 2" value="<?php echo $phone2;?> " name="inp5">
                        <input class="form-control" type="text" placeholder="Email 1" value="<?php echo $email;?> " name="inp6">
                        <input class="form-control" type="text" placeholder="Email 2" value="<?php echo $email2;?> " name="inp7">
                        <input class="form-control" type="text" placeholder="Address 1" value="<?php echo $address;?> " name="inp8">
                        <input class="form-control" type="text" placeholder="Address 2" value="<?php echo $address2;?> " name="inp9">
                        <input class="form-control" type="text" placeholder="VM Point" value="<?php echo $vm;?> " name="inp10">
                        <input class="form-control" type="text" placeholder="EM Point" value="<?php echo $em;?> " name="inp11">
                        <div class="btn-group" role="group">
                            <button class="btn btn-danger btn-sm shadow-none mr-2" type="submit" name="delete_btn">DELETE</button>
                            <button class="btn btn-info btn-sm shadow-none mr-2" type="submit" name="reset_btn">RESET</button>
                            <button class="btn btn-success btn-sm shadow-none" type="submit" name="save_btn">SAVE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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