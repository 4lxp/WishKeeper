<?php
  include "Database.php";
  $url = $_POST['product_url'];

  include('Plugin/simple_html_dom.php');
  $html = file_get_html($url);

  //Zalando
  if (strpos($url, 'zalando') !== false) {
    foreach($html->find('[itemprop="brand"]') as $brandtitle) {
       $brand=$brandtitle->plaintext; //plaintext prende solo il contenuto del div
    }

    foreach($html->find('[itemprop="name"]') as $itemtitle) {
       $name=$itemtitle->plaintext; //plaintext prende solo il contenuto del div
    }

    $title= $brand."".$name;

    foreach($html->find('[name="twitter:image"]') as $img) {
        //$image=$img->getAttribute('data-media');
        $image = $img->content;
    }

    foreach($html->find('[id="articlePrice"]') as $price) {
        $price=$price->plaintext;
        //prendo solo il prezzo numerico
        $price=preg_replace("/[^0-9\,]/","",$price);
    }

    $res = json_encode(array("title"=>$title,"image"=>$image,"price"=>$price));

  }

  //Amazon
  else if (strpos($url, 'amazon') !== false) {

    foreach($html->find('[id="productTitle"]') as $title) {
       $title= trim($title->plaintext); //plaintext prende solo il contenuto del div, trim toglie gli spazi
    }

    foreach($html->find('[id="landingImage"]') as $img) {
       $image= $img->src;
    }

    foreach($html->find('[id="priceblock_ourprice"]') as $price) {
      $price=$price->plaintext;
      //prendo solo il prezzo numerico
      $price=preg_replace("/[^0-9\,]/","",$price);
    }

    $res = json_encode(array("title"=>$title,"image"=>$image,"price"=>$price));

  }

  //Ebay
  else if (strpos($url, 'ebay') !== false) {

    foreach($html->find('[id="itemTitle"]') as $title) {
       $title= explode(';',$title->plaintext); //plaintext prende solo il contenuto del div, trim toglie gli spazi
    }

    foreach($html->find('[id="icImg"]') as $img) {
       $image= $img->src;
    }

    foreach($html->find('[id="prcIsum"]') as $price) {
      $price=$price->plaintext;
      //prendo solo il prezzo numerico
      $price=preg_replace("/[^0-9\,]/","",$price);
    }

    $res = json_encode(array("title"=>$title[1],"image"=>$image,"price"=>$price));

  }

  else{
    $res= false;
  }

  echo $res;

?>
