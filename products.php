<?php
@include 'config.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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
        <section class="products">
            <h1 class="heading">Latest Products</h1>
            <div class="box-container">
                <?php 
                $selectQuery = "SELECT * FROM products";
                $selectAllProducts = mysqli_query($db_connection, $selectQuery);
                if(mysqli_num_rows($selectAllProducts) > 0){
                    while($product = mysqli_fetch_assoc($selectAllProducts)){
                ?>
                <form action="" method="POST">
                    <div class="box">
                        <img src="uploaded_img/<?php echo $product['image']; ?>" alt="">
                        <h3><?php echo $product['name']; ?></h3>
                        <div class="price">
                            <?php echo $product['price']; ?>
                        </div>
                        <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
                        <input type="hidden" name="product_date" value="<?php echo $product['productDate']; ?>">
                        <input type="submit" class="btn" value="Add To Cart" name="add_to_cart">
                    </div>
                </form>

                <?php
                    }
                };   
                ?>
            </div>

        </section>

    </div>










    <!-- js file link -->
    <script src="js/script.js"></script>
</body>

</html>