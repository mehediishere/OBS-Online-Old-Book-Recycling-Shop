<?php 
    include 'db.php';
    $ord = "All";
    if(isset($_POST['orderupdate']))
    {
        $updateOrderSQL = "UPDATE tb_order_ws SET `status`='$_POST[orderStatus]' WHERE `invoice`='$_POST[invoice]'";
        mysqli_query($conn, $updateOrderSQL);
    }

    if(isset($_GET['order']))
    {
        if($_GET['order']=="all"){
            $ord = "All";
            $orderSql = "SELECT * FROM tb_order_ws";
        }elseif($_GET['order']=="processing"){
            $ord = "Processing";
            $orderSql = "SELECT * FROM tb_order_ws WHERE `status`='processing'";
        }
        elseif($_GET['order']=="confirmed"){
            $ord = "Confirmed";
            $orderSql = "SELECT * FROM tb_order_ws WHERE `status`='confirmed'";
        }
        elseif($_GET['order']=="completed"){
            $ord = "Completed";
            $orderSql = "SELECT * FROM tb_order_ws WHERE `status`='completed'";
        }
        elseif($_GET['order']=="canceled"){
            $ord = "Canceled";
            $orderSql = "SELECT * FROM tb_order_ws WHERE `status`='canceled'";
        }else{
            $orderSql = "SELECT * FROM tb_order_ws";
        }
    }else{
        $orderSql = "SELECT * FROM tb_order_ws";
    }

    if(isset($_POST['src_btn']))
    {
        $var = $_POST['src_text'];
        $orderSql = "SELECT * FROM tb_order_ws where invoice LIKE '%$var%' OR useremail LIKE '%$var%' OR status LIKE '%$var%' OR bookid LIKE '%$var%' OR bookname LIKE '%$var%' OR price LIKE '%$var%' OR totalprice LIKE '%$var%' OR sbname LIKE '%$var%'";
    }

    if(isset($_POST['orderupdate']))
    {
        $updateOrderSQL = "UPDATE tb_order_ws SET `status`='$_POST[orderStatus]' WHERE `invoice`='$_POST[invoice]'";
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
                            Order: <?php echo $ord; ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="?order=all">All</a>
                            <a class="dropdown-item" href="?order=processing">Processing</a>
                            <a class="dropdown-item" href="?order=confirmed">Confirmed</a>
                            <a class="dropdown-item" href="?order=completed">Completed</a>
                            <a class="dropdown-item" href="?order=canceled">Canceled</a>
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
                                <th># Order</th>
                                <th>Email</th>
                                <th>Book</th>
                                <th>E/S Book</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-monospace">
                            <?php
                                // $orderSql = "SELECT * FROM tb_order_ws";
                                $resultOrder = mysqli_query($conn, $orderSql);
                                if (mysqli_num_rows($resultOrder) > 0) {
                                while($orderRow = mysqli_fetch_assoc($resultOrder)) {
                            ?>
                            <tr>
                                <td><?php echo $orderRow['invoice']; ?></td>
                                <td><?php echo $orderRow['useremail']; ?></td>
                                <td><?php echo $orderRow['bookid']; ?></td>
                                <td><?php echo $orderRow['sbname']; ?></td>
                                <td><?php echo $orderRow['bstate']; ?></td>
                                <td><?php echo $orderRow['quantity']; ?></td>
                                <td><?php echo $orderRow['price']; ?></td>
                                <td><?php echo $orderRow['order_time']; ?></td>
                                <td>
                                    <span class="badge <?php if($orderRow['status']=="Canceled"){ ?>badge-danger<?php } 
                                                            elseif($orderRow['status']=="Confirmed"){?>badge-info<?php }
                                                            elseif($orderRow['status']=="Completed"){?>badge-success<?php } else{?>badge-warning<?php } ?>">
                                        <?php echo $orderRow['status']; ?>
                                    <span>
                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                            <td># Order</td>
                                <td>Email</td>
                                <td>Book</td>
                                <td>E/S Book</td>
                                <td>Type</td>
                                <td>Quantity</td>
                                <td>Price</td>
                                <td>Date & Time</td>
                                <td>Status</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div>
                <form style="padding: 20px;" action="" method="POST">
                    <div class="form-group">
                        <!-- <div class="d-flex">
                            <input class="form-control w-100" type="search" style="height: 31px;"><button class="btn btn-secondary shadow-none pb-4 src_btn_admin" type="button" style="/*height: 27px;*//*width: 129.8594px;*/">&nbsp;<i class="fa fa-search"></i></button>
                        </div> -->
                        <label>Order number :</label>
                            <input class="form-control" type="text" placeholder="Order number" name="invoice">
                            <div class="form-group">
                                <label>Order Status :</label>
                                <select class="form-control" name="orderStatus">
                                <option value="Processing">Processing</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Completed">Completed</option>
                                <option value="Canceled">Canceled</option>
                                </select>
                            </div>

                            <div class="btn-group" role="group">
                                <button class="btn btn-info btn-sm shadow-none mr-2" type="reset">RESET</button>
                                <button class="btn btn-info btn-sm shadow-none mr-2" type="submit" name="orderupdate">UPDATE</button>
                                <button class="btn btn-info btn-sm shadow-none mr-2" type="submit" name="orderdetails">E/S Book Details</button>
                                <button class="btn btn-info btn-sm shadow-none" type="submit" name="create_invoice">GENERATE INVOICE</button>
                            </div>
                    </div>
                </form>
            </div>
            <hr>
<!-- **********************Table Details Start*************************  -->
    <?php
    $invoice="";
    if(isset($_POST['orderdetails']) && $_POST['invoice']!=NULL){
        $bookdetailsSQL = "SELECT * FROM tb_order_ws WHERE `invoice`='$_POST[invoice]'";
        $result = mysqli_query($conn, $bookdetailsSQL);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $simage = "order_with_sell/".$row['simage'];
    ?>
    <table class="table table-bordered mt-3 mb-3">
        <tbody style="font-size: 0.9rem;">
            <tr>
                <td style="background-color: #F1F2F4; width: 20%;">Order Note</td>
                <td><a href="" style="color:#4d94ff;"><?php echo $row['note'] ?></a></td>
            </tr>
            <tr>
                <td style="background-color: #F1F2F4; width: 20%;">E/S Book Name</td>
                <td><a href="" style="color:#4d94ff;"><?php echo $row['sbname'] ?></a></td>
            </tr>
            <tr>
                <td style="background-color: #F1F2F4; width: 20%;">Estimate Price</td>
                <td><a href="" style="color:#4d94ff;"><?php echo $row['sprice'] ?></a></td>
            </tr>
            <tr>
                <td style="background-color: #F1F2F4; width: 20%;">Note of E/S Books</td>
                <td style="color:#4d94ff;"><?php echo $row['snote'] ?></td>
            </tr>
            <tr>
                <td style="background-color: #F1F2F4; width: 20%;">E/S Books Image</td>
                <td><img src="<?php echo $simage; ?>" class="rounded" height="350" width="300"></td>
            </tr>
        </tbody>
    </table>
    <?php }}}?>
<!-- **********************Table Details End*************************  -->
<!-- *********************Invoice Start***********************  -->
    <?php
        $invoice="";
        if(isset($_POST['create_invoice']) && $_POST['invoice']!=NULL)
        {
            $invoice = $_POST['invoice'];
            $orderuser = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `useremail` FROM `tb_order_ws` WHERE `invoice` = '$invoice'"));
        
    ?>
    <div id="invoice">
        <div class="toolbar hidden-print">
            <div class="text-right">
                <button id="printInvoice" class="btn btn-info" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
            </div>
            <hr>
        </div>
        <style>
        @media print {
                body * {
                    visibility: hidden;
                }
                .print-container, .print-container * {
                    visibility: visible;
                }
                .print-container{
                    position: absolute;
                    top: 0;
                    left: 0;
                }
            }
        </style>
        <div class="print-container invoice overflow-auto">
            <div style="min-width: 600px">
                <header>
                    <div class="row">
                        <div class="col">
                            <a target="_blank" href="#">
                                <img src="assets/img/icon/obslogo.png" data-holder-rendered="true" />
                                </a>
                        </div>
                        <div class="col company-details">
                            <!-- <h4 class="name">
                                LOCATION & CONTACT
                            </h4> -->
                            <div>Office: 7th Floor Shal-Ali Plaza, Mirpur-10, Dhaka-1216.</div>
                            <div>+88019*7-5*0456</div>
                            <div>obs@gmail.com</div>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="row contacts">
                        <?php
                             $userdetailsSql = mysqli_query($conn,"SELECT `name`,`phone`, `address` FROM `tb_user` WHERE `email` = '$orderuser[useremail]'");
                             if (mysqli_num_rows($userdetailsSql) > 0) {
                                 while($uname = mysqli_fetch_assoc($userdetailsSql)) {
                        ?>
                        <div class="col invoice-to">
                            <div class="text-gray-light">INVOICE TO:</div>
                            <h4 class="to"><?php if(!empty($uname['name'])){echo "$uname[name]";}?></h4>
                            <div><?php if(!empty($uname['phone'])) {echo "$uname[phone]";}?></div>
                            <div class="email"><?php if(!empty($invoiceRow['useremail'])){ echo "$invoiceRow[useremail]";}?></div>
                            <div class="address"><?php if(!empty($uname['address'])){ echo "$uname[address]";}?></div>
                        </div>
                        <?php } } ?>
                        <div class="col invoice-details">
                            <h4 class="invoice-id">INVOICE #<?php if(!empty($invoice)) echo $invoice; ?></h4>
                            <div class="date" id="invoiceDate"> </div>
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">DESCRIPTION</th>
                                <th class="text-right">TYPE</th>
                                <th class="text-right">QUANTITY</th>
                                <th class="text-right">PRICE</th>
                                <th class="text-right">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $invoiceSql = "SELECT * FROM tb_order_ws WHERE `invoice`='$invoice'";
                                $invoiceResult = mysqli_query($conn, $invoiceSql);
                                $srl = 1;
                                if (mysqli_num_rows($invoiceResult) > 0) {
                                    while($invoiceRow = mysqli_fetch_assoc($invoiceResult)) {
                                        $total = $invoiceRow['totalprice'];
                            ?>
                            <tr>
                                <td class="no"><?php echo $srl; ?></td>
                                <td class="text-left"><h3><?php echo $invoiceRow['bookname']?></h3></td>
                                <td class="unit"><?php echo $invoiceRow['bstate']?></td>
                                <td class="qty"><?php echo $invoiceRow['quantity']?></td>
                                <td class="unit"><?php echo $invoiceRow['price']?></td>
                                <td class="total"><?php echo ($invoiceRow['price']*$invoiceRow['quantity']);?></td>
                            </tr>
                            <?php $srl = $srl+1; } } ?>
                            <!-- <tr>
                                <td class="no">02</td>
                                <td class="text-left"><h3>Website Development</h3>Developing a Content Management System-based Website</td>
                                <td class="unit">$40.00</td>
                                <td class="qty">80</td>
                                <td class="unit">$40.00</td>
                                <td class="total">$300.00</td>
                            </tr>
                            <tr>
                                <td class="no">03</td>
                                <td class="text-left"><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td>
                                <td class="unit">$40.00</td>
                                <td class="qty">20</td>
                                <td class="unit">$40.00</td>
                                <td class="total">$800.00</td>
                            </tr> -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">SUBTOTAL</td>
                                <td><?php echo $total?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">SHIPPING COST (+)</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">EXCHANGEABLE BOOK PRICE (-)</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">GRAND TOTAL</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="thanks">Thank you!</div>
                    <div class="notices">
                        <div>NOTE:</div>
                        <div class="notice">For any queries or complaint about delivery or product please contact with us.</div>
                    </div>
                </main>
                <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
                </footer>
            </div>
            <?php } ?>
            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
            <div></div>
        </div>
    </div>

<!-- *********************Invoice End*********************** -->
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