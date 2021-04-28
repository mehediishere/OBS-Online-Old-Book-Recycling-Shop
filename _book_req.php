<?php 
    include 'db.php';
    $ord = "All";
    if(isset($_POST['reqUpdate']))
    {
        $updateOrderSQL = "UPDATE tb_req SET `status`='$_POST[reqStatus]' WHERE `srl`='$_POST[invoice]'";
        mysqli_query($conn, $updateOrderSQL);
    }

    if(isset($_GET['request']))
    {
        if($_GET['request']=="all"){
            $ord = "All";
            $orderSql = "SELECT * FROM tb_req";
        }elseif($_GET['request']=="processing"){
            $ord = "On Review";
            $orderSql = "SELECT * FROM tb_req WHERE `status`='On Review'";
        }
        elseif($_GET['request']=="completed"){
            $ord = "Available Now";
            $orderSql = "SELECT * FROM tb_req WHERE `status`='Available Now'";
        }
        elseif($_GET['request']=="canceled"){
            $ord = "Currently Not Available";
            $orderSql = "SELECT * FROM tb_req WHERE `status`='Currently Not Available'";
        }else{
            $orderSql = "SELECT * FROM tb_req";
        }
    }else{
        $orderSql = "SELECT * FROM tb_req";
    }

    if(isset($_POST['src_btn']))
    {
        $var = $_POST['src_text'];
        $orderSql = "SELECT * FROM tb_req where srl LIKE '%$var%' OR user LIKE '%$var%' OR `status` LIKE '%$var%' OR book LIKE '%$var%' OR author LIKE '%$var%' OR bookstate LIKE '%$var%' OR note LIKE '%$var%'";
    }

    if(isset($_POST['reqUpdate']))
    {
        $updateOrderSQL = "UPDATE tb_req SET `status`='$_POST[reqStatus]' WHERE `srl`='$_POST[invoice]'";
        mysqli_query($conn, $updateOrderSQL);
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
    <link rel="stylesheet" href="assets/css/invoiceStyle.css">
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
                <form action="" method="POST">
                <div class="d-block d-flex justify-content-end">
                    <input type="search" class="w-100 form-control" style="height: 31px;" name="src_text">
                    <button class="btn btn-secondary shadow-none pb-4 mr-4 src_btn_admin" type="submit" name="src_btn">&nbsp;<i class="fa fa-search"></i></button>
                    <div class="dropdown mr-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="orderTable01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Request: <?php echo $ord; ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="?request=all">All</a>
                            <a class="dropdown-item" href="?request=processing">On Review</a>
                            <a class="dropdown-item" href="?request=completed">Available Now</a>
                            <a class="dropdown-item" href="?request=canceled">Currently Not Available</a>
                        </div>
                    </div>
                    <button class="btn btn-dark shadow-none ad_arrow_btn" type="submit" name="ascBtn"><i class="fas fa-angle-up" style="font-size: 20px;"></i></button>
                    <button class="btn btn-dark shadow-none ad_arrow_btn" type="submit" name="descBtn"><i class="fas fa-angle-down" style="font-size: 20px;"></i></button>
                </div>
                </form>
                <div class="table-responsive table-bordered" style="max-height: 500px;">
                    <table class="table table-bordered table-hover table-dark">
                        <thead class="text-center">
                            <tr>
                                <th>#R.NO</th>
                                <th>User</th>
                                <th>Book</th>
                                <th>Author</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Status</th>
                             </tr>
                        </thead>
                        <tbody class="text-monospace">
                        <?php
                            // $orderQuery = "SELECT * FROM tb_req";
                            
                            $normalRequest = mysqli_query($conn, $orderSql);
                                if(mysqli_num_rows($normalRequest)>0){
                                    while($reqRow = mysqli_fetch_assoc($normalRequest)){
                            ?>
                                <tr>
                                    <td><?php echo $reqRow['srl'] ?></td>
                                    <td><?php echo $reqRow['user'] ?></td>
                                    <td><?php echo $reqRow['book'] ?></td>
                                    <td><?php echo $reqRow['author'] ?></td>
                                    <td><?php echo $reqRow['bookstate'] ?></td>
                                    <td><?php echo $reqRow['quantity'] ?></td>
                                    <td><?php echo $reqRow['note'] ?></td>
                                    <td>
                                    <span class="badge <?php if($reqRow['status']=="Currently Not Available"){ ?>badge-danger<?php } 
                                                            elseif($reqRow['status']=="Available Now"){?>badge-success<?php } else{?>badge-secondary<?php } ?>">
                                        <?php echo $reqRow['status']; ?>
                                    <span>
                                    </td>
                                </tr>
                                <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>#R.NO</t>
                                <td>User</td>
                                <td>Book</td>
                                <td>Author</td>
                                <td>Type</td>
                                <td>Quantity</td>
                                <td>Description</td>
                                <td>Status</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div>
                <form style="padding: 20px;" action="" method="POST">
                    <div class="form-group">
                        <label>Order number :</label>
                            <input class="form-control" type="text" placeholder="Order number" name="invoice">
                            <div class="form-group">
                                <label>Order Status :</label>
                                <select class="form-control" name="reqStatus">
                                <option value="On Review">On Review</option>
                                <option value="Available Now">Available Now</option>
                                <option value="Currently Not Available">Currently Not Available</option>
                                </select>
                            </div>

                            <div class="btn-group" role="group">
                                <button class="btn btn-info btn-sm shadow-none mr-2" type="reset">RESET</button>
                                <button class="btn btn-info btn-sm shadow-none mr-2" type="submit" name="reqUpdate">UPDATE</button>
                            </div>
                    </div>
                </form>
            </div>
            <hr>
        </div>
    </div>
    <!-- <script>
         $('#printInvoice').click(function(){
            Popup($('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                window.print();
                return true;
            }
        });
    </script> -->
    <script>
        var today = new Date();
        var year = today.getFullYear();
        var mes = today.getMonth()+1;
        var dia = today.getDate();
        var fecha =dia+" / "+mes+" / "+year;
        document.getElementById("invoiceDate").innerHTML = "Date : "+fecha;      
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