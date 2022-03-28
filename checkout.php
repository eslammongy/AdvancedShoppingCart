<?php
error_reporting(E_ERROR | E_PARSE);
include 'config.php';

if (isset($_POST['order_now_btn'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];
    
    $cart_query = mysqli_query($db_connection, "SELECT * FROM cart");
    $total_price = 0;
    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
             $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
            $product_price = number_format($product_item['price'] * $product_item['quantity']);
            $total_price += $product_price;
        };
    };
    $total_product = implode(', ', $product_name);
    $queryOrder = "INSERT INTO orders(name, number, email, method, flat, street, city, country,
       pinCode, totalProducts, totalPrice) VALUES('$name', '$number', '$email', '$method', '$flat', '$street', '$city', '$country',
        '$pin_code', '$total_product', '$total_price')" or die("Query Failed");
    $order_query = mysqli_query($db_connection, $queryOrder);

    if ($cart_query && $order_query) {
       echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>thank you for shopping!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> total : $".$total_price."/-  </span>
         </div>
         <div class='customer-details'>
            <p> your name : <span>".$name."</span> </p>
            <p> your number : <span>".$number."</span> </p>
            <p> your email : <span>".$email."</span> </p>
            <p> your address : <span>".$flat.", ".$street.", ".$city.", ".$country." - ".$pin_code."</span> </p>
            <p> your payment mode : <span>".$method."</span> </p>
            <p>(*pay when product arrives*)</p>
         </div>
            <a href='products.php' class='btn'>continue shopping</a>
         </div>
      </div>
      ";
    
  }
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <section class="checkout-form">
            <h1 class="heading">Complete Your Order </h1>

            <form action="" method="POST">
                <div class="display-order">
                    <?php
                    $select_cart_q = mysqli_query($db_connection, "SELECT * FROM cart");
                    $price = 0;
                    $total_price = 0;
                    if (mysqli_num_rows($select_cart_q) > 0) {
                        while ($rowCart = mysqli_fetch_assoc($select_cart_q)) {
                            $price = number_format($rowCart['price'] * $rowCart['quantity']);
                            $total_price += $price;
                    ?>
                    <span><?php echo $rowCart['name']; ?>(<?php echo $rowCart['quantity']; ?>)</span>
                    <?php
                        }
                    } else {
                        echo "<div class='display-order'><span>your cart is empty!!</span></div>";
                    }
                    ?>
                    <span class="grand-total">Total Price : <?php echo $total_price; ?></span>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Your Name</span>
                        <input type="text" placeholder="enter your name" name="name" required>
                    </div>
                    <div class="inputBox">
                        <span>Your Number</span>
                        <input type="number" placeholder="enter your number" name="number" required>
                    </div>
                    <div class="inputBox">
                        <span>Your Email</span>
                        <input type="email" placeholder="enter your email" name="email" required>
                    </div>
                    <div class="inputBox">
                        <span>Payment Method</span>
                        <select name="method">
                            <option value="Cach on delivary" selected>Cach on delivary</option>
                            <option value="Credit Cart">Credit Cart</option>
                            <option value="Paypal">Paypal</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>Address line 1</span>
                        <input type="text" placeholder="e.g. flat no." name="flat" required>
                    </div>
                    <div class="inputBox">
                        <span>Address line 2</span>
                        <input type="text" placeholder="e.g. street name." name="street" required>
                    </div>
                    <div class="inputBox">
                        <span>City</span>
                        <input type="text" placeholder="e.g. monoufia" name="city" required>
                    </div>
                    <div class="inputBox">
                        <span>Country</span>
                        <input type="text" placeholder="e.g. egypt" name="country" required>
                    </div>
                    <div class="inputBox">
                        <span>Pin Code</span>
                        <input type="text" placeholder="e.g. 123" name="pin_code" required>
                    </div>

                </div>
                <input type="submit" value="Order Now" name="order_now_btn" class="btn">
            </form>

        </section>

    </div>






    <!-- js file link -->
    <script src="js/script.js"></script>
</body>

</html>