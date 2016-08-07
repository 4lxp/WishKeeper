<?php

  session_start();

  include 'Database.php';

  $product_title = mysqli_real_escape_string($conn, $_POST['product_title']);
  $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
  $product_img_url = mysqli_real_escape_string($conn, $_POST['product_img_url']);
  $product_buy_url = mysqli_real_escape_string($conn, $_POST['product_buy_url']);
  $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
  $user_id = $_SESSION['user_id'];


  $sql = "UPDATE Products SET Title='$product_title',Price='$product_price',Img_Url='$product_img_url',Buy_Url='$product_buy_url' WHERE Product_ID='$product_id'";

  if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
  } else {
      echo "Error updating record: " . $conn->error;
  }


  $conn->close();

  echo $res;

?>
