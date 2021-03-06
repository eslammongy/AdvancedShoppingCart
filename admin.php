<?php
error_reporting(E_ERROR | E_PARSE);
include('config.php');
/* adding new product */
if (isset($_POST['add-product-btn'])) {
    $proName = $_POST['pro_name'];
    $proPrice = $_POST['pro_price'];
    $proImage = $_FILES['pro_image']['name'];
    $proImageTempName = $_FILES['pro_image']['tmp_name'];
    $proImageFolder = 'uploaded_img/' . $proImage;

    $query = "INSERT INTO products(name,price,image)
        VALUES('$proName','$proPrice','$proImage')";
    $addingNewProduct = mysqli_query($db_connection, $query) or die('error occured when adding new product');

    if ($addingNewProduct) {
        move_uploaded_file($proImageTempName, $proImageFolder);
        $message[] = 'adding new product successfully';
    } else {
        $message[] = "could not add new product";
    }
};
/* deleting selected product */
if (isset($_GET['delete'])) {
    $deleteID = $_GET['delete'];
    $deleteQuery = "DELETE FROM products WHERE id = $deleteID";
    $deleteProduct = mysqli_query($db_connection, $deleteQuery);
    if ($deleteProduct) {
        // header('location:admin.php');
        $message[] = "product deleted successfully";
    } else {
        //   header('location:admin.php');
        $message[] = "product deleted successfully";
    }
};
/* updating selected product */
if(isset($_POST['update_product'])){
    $updateID = $_POST['update_p_id'];
    $proNameUp = $_POST['update_p_name'];
    $proPriceUp = $_POST['update_p_price'];
    $proImageUp = $_FILES['update_p_image']['name'];
    $proImgTmpNameUp = $_FILES['update_p_image']['tmp_name'];
    $proImageFolderUp = 'uploaded_img/' . $proImageUp;
    $updateQuery = mysqli_query($db_connection, "UPDATE products SET name = '$proNameUp', price = '$proPriceUp', image = '$proImageUp' WHERE id = '$updateID'");
    if($updateQuery){
        move_uploaded_file($proImgTmpNameUp, $proImageFolderUp);
        $message[] = "product updated successfully";
        header('location:admin.php');
    }else{
        $message[] = "error when updating this product";
        header('location:admin.php');
    }

};

?>

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
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
        }
    };
    ?>

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
        <!-- displaying products table -->
        <section class="display-product-table">
            <table>
                <thead>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Date</th>
                    <th>Product Image</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $selectQuery = "SELECT * FROM products ORDER BY productDate DESC";
                    $selectProducts = mysqli_query($db_connection, $selectQuery);
                    if (mysqli_num_rows($selectProducts) > 0) {
                        while ($row = mysqli_fetch_assoc($selectProducts)) {
                    ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?>$</td>
                        <td><?php echo $row['productDate']; ?></td>
                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                        <td><a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-btn"
                                onclick="return confirm('are you sure you want to delete this product?');">
                                <i class="fas fa-trash"></i>Delete</a>
                            <a href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i
                                    class="fas fa-edit"></i> update </a>
                        </td>
                    </tr>


                    <?php
                        };
                    } else {
                        echo "<div class='empty'>No Products Added Yet</div>";
                    }
                    ?>

                </tbody>
            </table>


        </section>
        <!-- editing in selected product -->
        <section class="edit-form-container">

            <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
       $editQuery = "SELECT * FROM products WHERE id = $edit_id";
   
      $edit_query = mysqli_query($db_connection, $editQuery);
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

            <form action="" method="post" enctype="multipart/form-data">
                <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
                <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
                <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
                <input type="number" min="0" class="box" required name="update_p_price"
                    value="<?php echo $fetch_edit['price']; ?>">
                <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
                <input type="submit" value="update the prodcut" name="update_product" class="btn">
                <input type="reset" value="cancel" id="close-edit" class="option-btn">
            </form>

            <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

        </section>


    </div>

    <!-- js file link -->
    <script src="js/script.js">

    </script>
</body>

</html>