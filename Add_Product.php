<?php

  session_start();
  
  include 'Database.php';

  $product_title = mysqli_real_escape_string($conn, $_POST['product_title']);
  $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
  $product_img_url = mysqli_real_escape_string($conn, $_POST['product_img_url']);
  $product_buy_url = mysqli_real_escape_string($conn, $_POST['product_buy_url']);
  $user_id = $_SESSION['user_id'];

  $sql = "INSERT INTO Products (Title, Price, Img_Url, Buy_Url, User_ID)
    VALUES ('$product_title','$product_price', '$product_img_url','$product_buy_url','$user_id')";

    if ($conn->query($sql) === TRUE) {
      $res= true;
    } else {
      $res="Error: " . $sql . "<br>" . $conn->error;
    }

  $conn->close();

  echo $res;

?>
