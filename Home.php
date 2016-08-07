<?php

  session_start();

  $username = $_SESSION['username_login'];

  //Estraggo l'id dal db, dandogli l'username
  $user_id = getIdFromUsername($username);

  //Aggiungo l'id alla sessione, nel caso dovesse servire, per esempio nell'aggiunta dei prodotti
  $_SESSION['user_id'] = $user_id;

?>


<?php
  function getIdFromUsername($username)
  {
      include 'Database.php';

    //Prendo l'id in base all'username dal DB
    $sql = "select User_ID from Users where Username='$username'";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
        while ($row = $result->fetch_assoc()) {
            $user_id = $row[User_ID];
        }
      } else {
      }

      $conn->close();

      return $user_id;
  }

  function getProducts($user_id)
  {
      include 'Database.php';

      if (!empty($_POST["search_product"])) {
          $search_product=$_POST["search_product"];
          $sql = "select * from Products where User_ID='$user_id' AND Title LIKE '%$search_product%';";
      }else{
          $sql = "select * from Products where User_ID='$user_id'";
      }

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
        while ($row = $result->fetch_assoc()) {
            $productsArray[] = array('Product_ID' => $row['Product_ID'], 'Title' => $row['Title'], 'Price' => $row['Price'], 'Img_Url' => $row['Img_Url'], 'Buy_Url' => $row['Buy_Url']);
            $res = $productsArray;
        }
      } else {
          $res = false;
      }

      return $res;
  }
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wishkeeper</title>
    <meta name="theme-color" content="#d6154f">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Custom files -->
    <link href="css/input.css" rel="stylesheet">
    <link href="css/Home.css" rel="stylesheet">
    <script src="js/Home.js"></script>
    <link rel="stylesheet" href="Font/Lato/stylesheet.css" type="text/css" charset="utf-8" />
    <!-- Jquery Validation -->
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
    <!-- remodal Plugin -->
    <link rel="stylesheet" href="Plugin/Remodal/remodal.css">
    <link rel="stylesheet" href="Plugin/Remodal/remodal-default-theme.css">
    <script src="Plugin/Remodal/remodal.min.js"></script>

</head>

<body>

  <div class="header" >

    <div class="header_img_search">
      <a href="Home.php">
        <img src="Images/Logo.png" class="header_img" >
      </a>
      <div class="header_search">
        <form class="search_product_form" action="Home.php" method="post">
            <input placeholder="Search For a Product..." class="search_product" type="text" name="search_product">
        </form>
      </div>  
    </div>

    <div class="navbar_container">
      <div class="navbar">
        <div class="navbar_text">
        <?php
          echo 'Welcome '.$username.'';
         ?>
        </div>
        <form action="Logout.php" method="post">
          <input type="submit" class="navbar_button" value="LOGOUT">
        </form>
        <input type="submit" class="delete_account_button navbar_button" value="DELETE ACCOUNT">
      </div>

  </div>



  </div>

  <div class="container">
    <div class="no_products_container">
    </div>
    <!--Cards-->
    <div class="row">
      <div class="product_list_title">
        PRODUCT LIST
      </div>
      <?php

        //controllo se sono presenti dei prodotti, se la funzione ritorna falso, ci sono 0 prodotti
        if (getProducts($user_id) == false) {
          echo '<div class="col-xs-12 col-sm-6 col-md-3">
        <div class="no_product_card_container">
          <div class="no_product_card_title">Click this card to add your first product!</div>
          <div class="no_product_card_plus">+</div>
        </div>
      </div>';
        } else {
            $productsArray = getProducts($user_id);
            foreach ($productsArray as $product) {
                echo '<div class="col-xs-12 col-sm-6 col-md-3" id='.$product['Product_ID'].'>
              <div class="card_container">
                <div class="card_image_container">
                  <img class="card_image" src="'.$product['Img_Url'].'"></img>
                  <div class="card_image_hover"></div>
                  <div class="card_image_circle primaryColor" id='.$product['Buy_Url'].'>
                    BUY
                  </div>
                </div>
                <div class="card_footer">
                  <div class="card_footer_title">
                    <div class="card_footer_title_text">
                      '.$product['Title'].'
                    </div>
                    <div class="card_footer_title_price primaryColor">
                      '.$product['Price'].'€
                    </div>
                  </div>

                  <div class="card_footer_actions">
                    <div class="card_footer_actions_remove" id='.$product['Product_ID'].'>
                      REMOVE
                    </div>
                    <div class=card_footer_actions_edit primaryColor" id='.$product['Product_ID'].'>
                      EDIT
                    </div>
                  </div>
                </div>
              </div>
            </div>';
            }
        }

      ?>
    </div>

  </div>

  <div class="floating_action_button" >+</div>

  <div data-remodal-id="modal_add">
    <div class="modal_title">Manually add a Product</div>
    <form class="add_product_form">
      <div class="row">
        <div class="col-xs-12 col-md-9">
          <input placeholder="Product Name" class="product_title" type="text" name="product_title">
        </div>
        <div class="col-xs-12 col-md-3">
          <input placeholder="Price" class="product_price" type="number" name="product_price">
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-6">
          <input placeholder="Image Url" class="product_img_url" type="text" name="product_img_url">
        </div>
        <div class="col-xs-12 col-md-6">
        <input placeholder="Product Url"class="product_buy_url" type="text" name="product_buy_url">
        </div>
      </div>

      <input data-remodal-action="cancel" class="cancel_button" value="Cancel">
      <input type="submit" name="add_product_button" class="add_product_button" value="Add Product" />
    </form>

    <form class="add_product_url_form">
      <div class="modal_title_bottom">Add a Product from Url</div>
        <input placeholder="Product Url"class="product_url" type="text" name="product_url">
        <br>
        <input type="submit" name="add_product_url_button" class="add_product_url_button" value="Get Info from Url" />
        <div class='loader'><img src="Images/Loader.gif"></div>
    </form>


  </div>

  <div data-remodal-id="modal_edit">

    <form class="edit_product_form">
        <input placeholder="Product Name"class="product_title" type="text" name="product_title">
        <br>
        <input placeholder="Price of the Product"class="product_price" type="number" name="product_price">
        <br>
        <input placeholder="Image Url"class="product_img_url" type="text" name="product_img_url">
        <br>
        <input placeholder="Product Url" class="product_buy_url" type="text" name="product_buy_url">
        <br>
        <input data-remodal-action="cancel" class="cancel_button" value="Cancel">
        <input type="submit" name="edit_product_button" class="edit_product_button" value="Edit Product" />

    </form>


  </div>

</body>

</html>
