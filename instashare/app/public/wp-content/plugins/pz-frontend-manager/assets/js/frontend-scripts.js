jQuery(document).ready(function ($) {
    $('body').delegate('.pzfm-wishlist-btn', 'click', function() {
        var productID = $(this).attr('data-id');
        var wishlistAction = $(this).attr('data-type');
        if($('#wishlist-product-'+productID).find('i').hasClass('fa-heart-o')){
            $('#wishlist-product-'+productID).find('i').removeClass('fa-heart-o');
            $('#wishlist-product-'+productID).find('i').addClass('fa-heart');
        }else{
            $('#wishlist-product-'+productID).find('i').removeClass('fa-heart');
            $('#wishlist-product-'+productID).find('i').addClass('fa-heart-o');
        }
        if($('#wishlist-product-'+productID).attr('data-type') == 'add-to-wishlist'){
            $('#wishlist-product-'+productID).attr('data-type', 'remove-to-wishlist');
        }else{
            $('#wishlist-product-'+productID).attr('data-type', 'add-to-wishlist');
        }
        $.ajax({
            url: pzfmFrontendAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_update_wishlist',
                productID: productID,
                wishlistAction : wishlistAction
            },
            beforeSend: function () {
                $('body').append('<div id="genloader"></div>');
            },
            success: function () {
                $('body').remove('#genloader');
            }
        });
    });
});