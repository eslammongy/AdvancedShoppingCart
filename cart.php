<?php  
@include 'config.php';
if(isset($_POST['update_update_btn'])){
    $update_quantity = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $query = "UPDATE cart SET quantity = '$update_quantity' WHERE id = '$update_id'";
    $updatingQuery = mysqli_query($db_connection, $query);
    if($updatingQuery){
        header('location:cart.php');
    }
}; 

if(isset($_GET['remove'])){
    $remove_ItemId = $_GET['remove'];
    $query = "DELETE FROM cart WHERE id = '$remove_ItemId'";
    $removeQuery = mysqli_query($db_connection, $query);
    if($removeQuery){
        header("location:cart.php");
    }
   
};
 
if(isset($_GET['delete_all'])){
    $query = "DELETE FROM cart";
    $deleteQuery = mysqli_query($db_connection, $query);
    if($deleteQuery){
        header("location:cart.php");
    }
   
};
 


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
        }
    };
    ?>
    <?php include('header.php'); ?>
    <div class="container">
        <section class="shopping-cart">
            <h1 class="heading">Shopping Cart</h1>
            <table>

                <thead>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total price</th>
                    <th>Action</th>
                </thead>

                <tbody>

                    <?php 
         
         $select_cart = mysqli_query($db_connection, "SELECT * FROM cart");
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>

                    <tr>
                        <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['name']; ?></td>
                        <td>$<?php echo number_format($fetch_cart['price']); ?>/-</td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" name="update_quantity" min="1"
                                    value="<?php echo $fetch_cart['quantity']; ?>">
                                <input type="submit" value="update" name="update_update_btn">
                            </form>
                        </td>
                        <td>$<?php echo $sub_total = $fetch_cart['price'] * $fetch_cart['quantity']; ?>/-
                        </td>
                        <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>"
                                onclick="return confirm('Are you sure you want to remove product from cart?')"
                                class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
                    </tr>
                    <?php
           $grand_total += $sub_total;  
            };
         };
         ?>
                    <tr class="table-bottom">
                        <td><a href="products.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
                        <td colspan="3">grand total</td>

                        <td>$<?php echo $grand_total; ?> /-</td>
                        <td><a href="cart.php?delete_all"
                                onclick="return confirm('Are you sure you want to remove all products from cart?');"
                                class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
                    </tr>

                </tbody>

            </table>

            <div class="checkout-btn">
                <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Procced To Checkout</a>
            </div>

        </section>
    </div>

    <!-- js file link -->
    <script src="js/script.js"></script>
</body>

</html>