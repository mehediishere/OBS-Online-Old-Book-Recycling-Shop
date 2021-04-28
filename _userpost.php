<?php
    include 'db.php';
    $srcOutput="";
    if(isset($_GET['post']))
    {
        $postid  =  $_GET['post'];
        $deleteSql = "DELETE FROM tb_post WHERE srl='$postid'";
        $imagefile = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `image` FROM `tb_post` WHERE `srl` = '$postid'"));
        
        if($imagefile['image'] != NULL) {
            $file_to_delete = "assets/posts/".$imagefile['image'];
            unlink($file_to_delete);
        }
        
        if (mysqli_query($conn, $deleteSql)) 
        {
            $srcOutput = '<div style="color:#10AD4B;font-size:10px;"> Query successfully executed. </div>';
        }
        else
        {
            $srcOutput = '<div style="color:red;font-size:10px;"> Query failed to execute. </div>';
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
    <div class="admin_nav" style="padding: 5px;">
        <h3><i class="fa fa-leanpub"></i>&nbsp;OBS</h3>
    </div>
    <div class="grid-container">
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
            <?php include '_admin_nav.php';?>
            <div class="d-flex justify-content-around footer_side_nav"><a href="#"><i class="fa fa-envelope"></i></a><a href="#"><i class="fa fa-shopping-bag"></i></a><a href="#"><i class="fa fa-cog"></i></a><a href="#"><i class="fa fa-power-off"></i></a></div>
        </div>
        <div class="admin_input">
            <div style="padding: 20px;">
                <div class="d-block d-flex justify-content-end"><input type="search" class="w-100 form-control" style="height: 31px;"><button class="btn btn-secondary shadow-none pb-4 mr-4 src_btn_admin" type="button" style="/*height: 27px;*//*width: 129.8594px;*/">&nbsp;<i class="fa fa-search"></i></button>
                    <button
                        class="btn btn-dark shadow-none ad_arrow_btn" type="button"><i class="fa fa-angle-left" style="font-size: 20px;"></i></button><button class="btn btn-dark shadow-none ad_arrow_btn" type="button"><i class="fa fa-angle-right" style="font-size: 20px;"></i></button></div>
                <div class="table-responsive table-bordered" style="max-height: 500px;">
                    <table class="table table-bordered table-hover table-dark">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Post Title</th>
                                <th>Details</th>
                                <th>Date & Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-monospace">
                            <?php
                                $postSql = "SELECT * FROM tb_post";
                                $result = mysqli_query($conn, $postSql);
                                if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $image = "order_with_sell/".$row['image'];
                            ?>
                            <tr>
                                <td><?php echo $row['srl']; ?></td>
                                <td><?php echo $row['user']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['details']; ?></td>
                                <td><?php echo $row['submit_time']; ?></td>
                                <td><a href="?post=<?php echo $row['srl'];?>"><span class="badge badge-danger">Delete</span></a></td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <td>#</td>
                                <td>User</td>
                                <td>Post Title</td>
                                <td>Details</td>
                                <td>Date & Time</td>
                                <td>Action</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php echo $srcOutput; ?>
            <hr>
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