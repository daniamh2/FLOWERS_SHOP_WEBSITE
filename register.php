<?php

@include 'config.php';


if(isset($_POST['submit'])){

   $NAME  = $_POST['name'];
   $EMAIL = $_POST['email'];
   $pass = $_POST['pass'];
   $cpass = $_POST['cpass'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;
   $select_user = mysqli_query($conn, "SELECT email FROM `users` WHERE email = '$EMAIL'") or die('query failed');

   if(mysqli_num_rows($select_user) > 0){
      $message[] = 'user name already exist!';
   }else if ($pass != $cpass){
      $message[] = 'confirm password not matched!';
   }else{
      $insert_user = mysqli_query($conn, "INSERT INTO `users`(name, email ,image, password,user_type) VALUES('$NAME','$EMAIL','$image','$PASS','user')") or die('query failed');
      move_uploaded_file($image_tmp_name, $image_folter);
      $message[] = 'rigisted successfully!'; 
         header('location:login.php');
      }
      }

   

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>      
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="text" name="name" class="box" placeholder="enter your username" required>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="password" name="pass" class="box" placeholder="enter your password" required>
      <input type="password" name="cpass" class="box" placeholder="confirm your password" required>
      <input type="submit" class="btn" name="submit" value="register now">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>

</body>
</html>
