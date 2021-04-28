<?php
session_start();
$status="";
if (isset($_POST['action']) && $_POST['action']=="remove"){
if(!empty($_SESSION["shopping_cart"])) {
	foreach($_SESSION["shopping_cart"] as $key => $value) {
		if($_POST["bookid"] == $key){
		unset($_SESSION["shopping_cart"][$key]);
		$status = "<div class='box' style='color:red;'>
		Product is removed from your cart!</div>";
		}
		if(empty($_SESSION["shopping_cart"]))
		unset($_SESSION["shopping_cart"]);
			}		
		}
}

if (isset($_POST['action']) && $_POST['action']=="change"){
  foreach($_SESSION["shopping_cart"] as &$value){
    if($value['bookid'] === $_POST["bookid"]){
        $value['quantity'] = $_POST["quantity"];
        break; // Stop the loop after we've found the product
    }
   } 	
}

if (isset($_POST['action2']) && $_POST['action2']=="change2"){
    foreach($_SESSION["shopping_cart"] as &$value){
      if($value['bookid'] === $_POST["bookid"]){
          $value['bstate'] = $_POST["bstate"];
          if($value['bstate'] == "OLD")
          {
              $value['fprice'] = $value['obprice'];
          }else{
            $value['fprice'] = $value['price'];
          }
          break; // Stop the loop after we've found the product
      }
     } 	
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/smoothproducts.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cart.css">
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
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fa fa-user" style="font-size: 17px;"></i></a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="shoppingbag.php"><i class="fa fa-cart-arrow-down" style="font-size: 17px; color:black;"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main style="margin-top: 100px;">
        <section>
            <div class="container">
                <h2>Your Shopping Cart</h2>
                <?php if(isset($_SESSION['orderCNF']) && !empty($_SESSION['orderCNF'])) { echo $_SESSION['orderCNF']; $_SESSION['orderCNF']=""; } ?>
                <hr>

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
    <a href="shoppingbag.php">
        <img src="assets/img/icon/cart-icon.png" /> Cart
        <span><?php echo $cart_count; ?></span></a>
</div>
<?php
}
?>

<div class="cart">
    <?php
if(isset($_SESSION["shopping_cart"])){
$total_price = 0;
?>
    <table class="table">
        <tbody>
            <tr>
                <td></td>
                <td>ITEM NAME</td>
                <td>QUANTITY</td>
                <td>BOOK STATE</td>
                <td>UNIT PRICE</td>
                <td>ITEMS TOTAL</td>
            </tr>
            <?php		
                foreach ($_SESSION["shopping_cart"] as $product){
            ?>
            <tr>
                <td><img src='<?php echo $product["image"]; ?>' width="50" height="40" /></td>
                <td><?php echo $product["name"]; ?><br />
                    <form method='POST' action=''>
                        <input type='hidden' name='bookid' value="<?php echo $product["bookid"]; ?>" />
                        <input type='hidden' name='action' value="remove" />
                        <button type='submit' class='remove'>Remove Item</button>
                    </form>
                </td>
                <td>
                    <form method='post' action=''>
                        <input type='hidden' name='bookid' value="<?php echo $product["bookid"]; ?>" />
                        <input type='hidden' name='action' value="change" />
                        <select name='quantity' class='quantity' onchange="this.form.submit()">
                            <option <?php if($product["quantity"]==1) echo "selected";?> value="1">1</option>
                            <option <?php if($product["quantity"]==2) echo "selected";?> value="2">2</option>
                            <option <?php if($product["quantity"]==3) echo "selected";?> value="3">3</option>
                            <option <?php if($product["quantity"]==4) echo "selected";?> value="4">4</option>
                            <option <?php if($product["quantity"]==5) echo "selected";?> value="5">5</option>
                        </select>
                    </form>
                </td>
                <td>
                    <form method='post' action=''>
                        <input type='hidden' name='bookid' value="<?php echo $product["bookid"]; ?>" />
                        <input type='hidden' name='action2' value="change2" />
                        <select name='bstate' class='quantity' onchange="this.form.submit()">
                            <option <?php if($product["bstate"]=="NEW") echo "selected";?> value="NEW">NEW</option>
                            <option <?php if($product["bstate"]=="OLD") echo "selected";?> value="OLD">OLD</option>
                            <option <?php if($product["bstate"]=="OLD if not available then NEW") echo "selected";?> value="OLD if not available then NEW">OLD if not available then NEW</option>
                        </select>
                    </form>
                </td>
                <td><?php if($product["bstate"]=="OLD"){echo "৳ ".$product["obprice"];}else{echo "৳ ".$product["price"];} ?></td>
                <td><?php if($product["bstate"]=="OLD"){echo "৳ ".$product["obprice"]*$product["quantity"];}else{echo "৳ ".$product["price"]*$product["quantity"];} ?></td>
            </tr>
            <?php
            if($product["bstate"]=="OLD")
            {
                $total_price += ($product["obprice"]*$product["quantity"]);
            }
            else
            {
                $total_price += ($product["price"]*$product["quantity"]);
            }
                }
            ?>
            <tr>
                <td colspan="5" align="right">
                    <strong>TOTAL : <?php echo "৳ ".$total_price; ?></strong>
                    <?php $_SESSION["totalprice"] = $total_price; ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}else{
echo "<h3>Your cart is empty!</h3>";
}
?>
</div>

<div style="clear:both;"></div>
<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>
<div align="right">
<button type="button" onclick="location.href='bagconfirm.php'" class="btn btn-outline-secondary" <?php if(empty($_SESSION["shopping_cart"]) || !isset($_SESSION["user"]) || isset($_SESSION["user"])==NULL || $_SESSION["totalprice"]<30){ ?> disabled <?php } ?> >GO TO CONFIRM ORDER <i class="fas fa-arrow-circle-right"></i></button>
</div>

    <br/><br/>
            </div>
        </section>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- <script>
        /* Set values + misc */
        var promoCode;
        var promoPrice;
        var fadeTime = 300;

        /* Assign actions */
        $('.quantity input').change(function() {
            updateQuantity(this);
        });

        $('.remove button').click(function() {
            removeItem(this);
        });

        $(document).ready(function() {
            updateSumItems();
        });

        $('.promo-code-cta').click(function() {

            promoCode = $('#promo-code').val();

            if (promoCode == '10off' || promoCode == '10OFF') {
                //If promoPrice has no value, set it as 10 for the 10OFF promocode
                if (!promoPrice) {
                    promoPrice = 10;
                } else if (promoCode) {
                    promoPrice = promoPrice * 1;
                }
            } else if (promoCode != '') {
                alert("Invalid Promo Code");
                promoPrice = 0;
            }
            //If there is a promoPrice that has been set (it means there is a valid promoCode input) show promo
            if (promoPrice) {
                $('.summary-promo').removeClass('hide');
                $('.promo-value').text(promoPrice.toFixed(2));
                recalculateCart(true);
            }
        });

        /* Recalculate cart */
        function recalculateCart(onlyTotal) {
            var subtotal = 0;

            /* Sum up row totals */
            $('.basket-product').each(function() {
                subtotal += parseFloat($(this).children('.subtotal').text());
            });

            /* Calculate totals */
            var total = subtotal;

            //If there is a valid promoCode, and subtotal < 10 subtract from total
            var promoPrice = parseFloat($('.promo-value').text());
            if (promoPrice) {
                if (subtotal >= 10) {
                    total -= promoPrice;
                } else {
                    alert('Order must be more than £10 for Promo code to apply.');
                    $('.summary-promo').addClass('hide');
                }
            }

            /*If switch for update only total, update only total display*/
            if (onlyTotal) {
                /* Update total display */
                $('.total-value').fadeOut(fadeTime, function() {
                    $('#basket-total').html(total.toFixed(2));
                    $('.total-value').fadeIn(fadeTime);
                });
            } else {
                /* Update summary display. */
                $('.final-value').fadeOut(fadeTime, function() {
                    $('#basket-subtotal').html(subtotal.toFixed(2));
                    $('#basket-total').html(total.toFixed(2));
                    if (total == 0) {
                        $('.checkout-cta').fadeOut(fadeTime);
                    } else {
                        $('.checkout-cta').fadeIn(fadeTime);
                    }
                    $('.final-value').fadeIn(fadeTime);
                });
            }
        }

        /* Update quantity */
        function updateQuantity(quantityInput) {
            /* Calculate line price */
            var productRow = $(quantityInput).parent().parent();
            var price = parseFloat(productRow.children('.price').text());
            var quantity = $(quantityInput).val();
            var linePrice = price * quantity;

            /* Update line price display and recalc cart totals */
            productRow.children('.subtotal').each(function() {
                $(this).fadeOut(fadeTime, function() {
                    $(this).text(linePrice.toFixed(2));
                    recalculateCart();
                    $(this).fadeIn(fadeTime);
                });
            });

            productRow.find('.item-quantity').text(quantity);
            updateSumItems();
        }

        function updateSumItems() {
            var sumItems = 0;
            $('.quantity input').each(function() {
                sumItems += parseInt($(this).val());
            });
            $('.total-items').text(sumItems);
        }

        /* Remove item from cart */
        function removeItem(removeButton) {
            /* Remove row from DOM and recalc cart total */
            var productRow = $(removeButton).parent().parent();
            productRow.slideUp(fadeTime, function() {
                productRow.remove();
                recalculateCart();
                updateSumItems();
            });
        }
    </script> -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/material-Style-Ripple-Button.js"></script>
</body>

</html>