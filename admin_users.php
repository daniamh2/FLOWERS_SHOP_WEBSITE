<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};
?>
<?php

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}
?>
<?php

if(isset($_POST['add_user'])){

    $NAME  = $_POST['name'];
    $EMAIL = $_POST['email'];
    $PASS = $_POST['password'];
    $TYPE  =$_POST['user_type'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folter = 'uploaded_img/'.$image;
    $insert_user = mysqli_query($conn, "INSERT INTO `users`(name, email ,image, password,user_type) VALUES('$NAME','$EMAIL','$image','$PASS','$TYPE')") or die('query failed');
    move_uploaded_file($image_tmp_name, $image_folter);
    $message[] = 'user added successfully!';
}?>
 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>
<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add new user</h3>
      <input type="text" class="box" required placeholder="enter user name" name="name">
      <input type="text"  class="box" required placeholder="enter user email" name="email">
      <input type="radio"  class="box1"  name="user_type" value='user'><p class="box1">user</p>
      <input type="radio"  class="box1"  name="user_type" value='admin'><p class="box1">admin</p>
      <input type="text"  class="box" required placeholder="enter user pass" name="password">
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="add user" name="add_user" class="btn">
   </form>

</section>

<section class="users">

   <h1 class="title">users account</h1>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         if(mysqli_num_rows($select_users) > 0){
            while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="box">
         <img class="image" src="uploaded_img/<?php echo $fetch_users['image']; ?>" alt="user" width="270px">
         <p>user id : <span><?php echo $fetch_users['id']; ?></span></p>
         <p>username : <span><?php echo $fetch_users['name']; ?></span></p>
         <p>email : <span><?php echo $fetch_users['email']; ?></span></p>
         <p>password : <span><?php echo $fetch_users['password']; ?></span></p>
         <p>user type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; }; ?>"><?php echo $fetch_users['user_type']; ?></span></p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete</a>
         <a href="user_up.php?update=<?php echo $fetch_users['id']; ?>" class="option-btn">update</a>

        </div>
      <?php
         }
      }
      ?>
   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>