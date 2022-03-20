<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <section>
            <form action="" method="POST" class="add-product-form" enctype="multipart/form-data">
                <h3>Add New Product</h3>
                <input type="text" name="pro_name" placeholder="enter the product name" class="box" required>
                <input type="number" name="pro_price" placeholder="enter the product price" class="box" required>
                <input type="file" name="pro_image" accept="image/png, image/jpeg, image/jpg" class="box" required>
                <input type="submit" value="add the product" name="add-product-btn" class="btn">


            </form>


        </section>

    </div>




    <!-- js file link -->
    <script src="js/script.js"></script>
</body>

</html>