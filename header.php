<header class="header">

    <div class="flex">
        <a href="#" class="logo"><i class="fa-solid fa-bag-shopping"></i> Shopping</a>
        <nav class="navbar">
            <a href="admin.php">Add Product</a>
            <a href="products.php">View Products</a>
        </nav>
        <?php 
        @include 'config.php';
        $selectCartNum = mysqli_query($db_connection, "SELECT * FROM cart") or die('Query Failed');
        $row_count = mysqli_num_rows($selectCartNum);
        ?>
        <a href="cart.php" class="cart">Cart <span><?php echo $row_count; ?></span></a>
        <div id="menu-btn" class="fas fa-bars">

        </div>
    </div>

</header>