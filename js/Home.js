$(document).ready(function() {

var product_id;

$('.loader').hide();


$(".card_footer_actions_remove").click(function() {

    var product_id = $(this).attr('id');

    $.ajax({
        type: "POST",
        url: "Remove_Product.php",
        data: {
            product_id: product_id
        },
        success: function(data) {
            console.log(data);
            if (data == true) {
                location.reload();
            }
        }
    });
});

$(".card_image_circle").click(function() {

    var buy_url = $(this).attr('id');
    window.open(buy_url, '_blank');
});

$(".card_footer_actions_edit").click(function() {

  var inst = $('[data-remodal-id=modal_edit]').remodal();

  inst.open();

  product_id = $(this).attr('id');

  $.ajax({
      type: "POST",
      url: "Get_Products_From_Id.php",
      data: {
          product_id: product_id
      },
      success: function(data) {
        var product = $.parseJSON(data);
        console.log(data);
        var product_title = product.Title;
        var product_price = product.Price;
        var product_img_url = product.Img_Url;
        var product_buy_url = product.Buy_Url;
        console.log(product_title);
        console.log(product_price);
        console.log(product_img_url);
        console.log(product_buy_url);
        $('.edit_product_form > .product_title').val(product_title);
        $('.edit_product_form > .product_price').val(product_price);
        $('.edit_product_form > .product_img_url').val(product_img_url);
        $('.edit_product_form > .product_buy_url').val(product_buy_url);

      }
  });
});

$(".floating_action_button").click(function() {

  var inst = $('[data-remodal-id=modal_add]').remodal();

  inst.open();

});

$(".no_product_card_container").click(function() {

  var inst = $('[data-remodal-id=modal_add]').remodal();

  inst.open();

});

$(".delete_account_button").click(function() {

    $.ajax({
        type: "POST",
        url: "Delete_Account.php",
        success: function(data) {
            console.log(data);
            if (data == true) {
                //L'account è stato cancellato, ritorno alla index
                window.location.href = "Index.html";
            }
        }
    });
});

$('.add_product_form').validate({
    rules: {
        product_title: {
            required: true
        },
        product_price: {},
        product_img_url: {},
        product_buy_url: {},
    }
});

$('.edit_product_form').validate({
    rules: {
        product_title: {
            required: true
        },
        product_price: {},
        product_img_url: {},
        product_buy_url: {},
    }
});

$('.add_product_form').on('submit', function(e) {
    if ($(this).valid()) {

        var add_product_form_data = $('.add_product_form').serializeArray();

        var product_title = add_product_form_data[0].value;
        var product_price = add_product_form_data[1].value;
        var product_img_url = add_product_form_data[2].value;
        var product_buy_url = add_product_form_data[3].value;

        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "Add_Product.php",
            data: {
                product_title: product_title,
                product_price: product_price,
                product_img_url: product_img_url,
                product_buy_url: product_buy_url
            },
            success: function(data) {
                console.log(data); //restituisce eventuali errori, prodotto gia presente ad esempio, deve essere visualizzato
                if (data == true) {
                    //Devo inventarmi qualcosa, o senno ricarico la pagina, per far vedere il nuovo prodotto
                    var inst = $('[data-remodal-id=modal_add]').remodal();
                    inst.close();
                    location.reload();
                }
            }
        });
    }
});

$('.add_product_url_form').validate({
    rules: {
        product_url: {
            required: true
        },
    }
});

$('.add_product_url_form').on('submit', function(e) {
    if ($(this).valid()) {

        var add_product_url_form_data = $('.add_product_url_form').serializeArray();

        var product_url = add_product_url_form_data[0].value;

        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "Url_Extractor.php",
            data: {
                product_url: product_url
            },
            beforeSend: function() {
               $('.loader').show();
               $('.add_product_url_button').hide();

            },
            complete: function(){
               $('.loader').hide();
               $('.add_product_url_button').show();
            },
            success: function(data) {
                if (data == false) {
                    console.log(data); //restituisce eventuali errori, url errato per esempio, deve essere visualizzato
                    console.log("Sito non valido");
                } else {
                    var product = $.parseJSON(data);
                    console.log(data);
                    var product_title = product.title;
                    var product_price = product.price;
                    var product_img_url = product.image;
                    var product_buy_url = product_url;
                    console.log(product_title);
                    console.log(product_price);
                    console.log(product_img_url);
                    console.log(product_buy_url);
                    $('.product_title').val($('.product_title').val() + product_title );
                    $('.product_price').val($('.product_price').val() + parseInt(product_price) );
                    $('.product_img_url').val($('.product_img_url').val() + product_img_url );
                    $('.product_buy_url').val($('.product_buy_url').val() + product_buy_url );

                }
            }
        });
    }
});

$('.edit_product_form').on('submit', function(e) {
    if ($(this).valid()) {

        var add_product_form_data = $('.edit_product_form').serializeArray();

        var product_title = add_product_form_data[0].value;
        var product_price = add_product_form_data[1].value;
        var product_img_url = add_product_form_data[2].value;
        var product_buy_url = add_product_form_data[3].value;

        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "Edit_Product.php",
            data: {
                product_title: product_title,
                product_price: product_price,
                product_img_url: product_img_url,
                product_buy_url: product_buy_url,
                product_id:product_id
            },
            success: function(data) {
                console.log(data); //restituisce eventuali errori, prodotto gia presente ad esempio, deve essere visualizzato
                var inst = $('[data-remodal-id=modal_edit]').remodal();
                inst.close();
                location.reload();
                if (data == true) {

                }
            }
        });
    }
    console.log(product_id);
});

//Animazioni

//Hover del footer nelle cards
$('.card_footer').hover(function() {
    $(this).css('height', '140px'),
        $(this).parent().find('.card_image_container').css('height', '160px');
}, function() {
    //Resetto quando tolgo l'hover
    $(this).css('height', '70px'),
        $(this).parent().find('.card_image_container').css('height', '230px');
});

//Hover dell'immagine
$('.card_image_container').hover(function() {
    $(this).find('.card_image_hover').css('background-color', 'rgba(255, 40, 104, 0.5)'),
        $(this).find('.card_image_circle').css({
            'height': '90px',
            'width': '90px',
            'font-size': '16px',
            'line-height': '90px'
        });
}, function() {
    //Resetto quando tolgo l'hover
    $(this).find('.card_image_hover').css('background-color', 'rgba(255, 17, 3, 0)'),
        $(this).find('.card_image_circle').css({
            'height': '0px',
            'width': '0px',
            'font-size': '0px',
            'line-height': ' 0px'
        });
});

});
