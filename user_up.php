<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_user'])){

   $update_p_id = $_POST['update_p_id'];
   $name =  $_POST['name'];
   $EMAIL = $_POST['email'];
   $PASS = $_POST['password'];
   $TYPE  =$_POST['user_type'];

   mysqli_query($conn, "UPDATE `users` SET name = '$name',user_type='$TYPE', email = '$EMAIL', password = '$PASS' WHERE id = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;
   $old_image = $_POST['update_p_image'];
   
   if(!empty($image)){
         mysqli_query($conn, "UPDATE `users` SET image = '$image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folter);
         $message[] = 'image updated successfully!';
      
   }

   $message[] = 'user INFO updated successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update user</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="update-product">

<?php
   $ID=$_GET['update'];
   $up = mysqli_query($conn, "select * from users where id =$ID");
   $fetch_users = mysqli_fetch_array($up);
   ?>
<form action="" method="post" enctype="multipart/form-data">
   <img src="uploaded_img/<?php echo $fetch_users['image']; ?>" class="image"  alt="">
   <input type="hidden" value="<?php echo $fetch_users['id']; ?>" name="update_p_id">
   <input type="hidden" value="<?php echo $fetch_users['image']; ?>" name="update_p_image">
   <input type="text" class="box" value="<?php echo $fetch_users['name']; ?>" required placeholder="update user name" name="name">
   <input type="text"  class="box" value="<?php echo $fetch_users['email']; ?>" required placeholder="update user email" name="email">
   <input type="text"  class="box" value="<?php echo $fetch_users['password']; ?>" required placeholder="update user pass" name="password">
   <input type="text"  class="box" value="<?php echo $fetch_users['user_type']; ?>" required placeholder="update user type" name="user_type">   
   <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
   <input type="submit" value="update user" name="update_user" class="btn">
   <a href="admin_users.php" class="option-btn">go back</a>
</form>





</section>

<script src="js/admin_script.js"></script>

</body>
</html>