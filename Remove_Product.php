<?php

  include 'Database.php';

  $product_id = $_POST['product_id'];

  $sql = "DELETE FROM Products WHERE Product_ID=$product_id";

  if ($conn->query($sql) === TRUE) {
    $res= true;
  }

  else {
    $res= "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

  echo $res;

?>
