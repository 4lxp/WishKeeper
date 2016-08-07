<?php
  include 'Database.php';

  $product_id = $_POST['product_id'];

  $sql = "select * from Products where Product_ID='$product_id'";

  $result = $conn->query($sql);

  $res = array();

  if ($result->num_rows > 0) {
      // output data of each row
    while ($row = $result->fetch_assoc()) {
        $res = json_encode(array('Product_ID' => $row['Product_ID'], 'Title' => $row['Title'], 'Price' => $row['Price'], 'Img_Url' => $row['Img_Url'], 'Buy_Url' => $row['Buy_Url']));
    }
  } else {
      $res = "errore";
  }

  echo $res;
?>
