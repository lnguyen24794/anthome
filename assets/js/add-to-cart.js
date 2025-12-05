/**
 * AJAX Add to Cart Handler
 */
(function($) {
    'use strict';

    // Handle AJAX add to cart on product cards
    $(document).on('click', '.product-card-actions .ajax_add_to_cart', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var productId = $button.data('product_id');
        var quantity = $button.data('quantity') || 1;
        
        // Add loading state
        $button.addClass('loading');
        $button.text('Đang thêm...');
        
        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.error && response.product_url) {
                    // Redirect to product page if product requires configuration
                    // window.location = response.product_url;
                    return;
                }
                
                // Update cart count in header
                if (response.fragments) {
                    $.each(response.fragments, function(key, value) {
                        $(key).replaceWith(value);
                    });
                }
                
                // Show success state
                $button.removeClass('loading').addClass('added');
                $button.text('Đã thêm vào giỏ');
                
                // Trigger event for cart update
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
                
                // Reset button after 2 seconds
                setTimeout(function() {
                    $button.removeClass('added');
                    $button.text('Thêm vào giỏ hàng');
                }, 2000);
            },
            error: function() {
                $button.removeClass('loading');
                $button.text('Thêm vào giỏ hàng');
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            }
        });
    });
    
    // Update cart count when items are added
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, button) {
        // Update cart count
        if (fragments && fragments['.cart-count']) {
            $('.cart-count').html(fragments['.cart-count']);
        }
        
        // Optional: Show a toast notification
        if (typeof window.showToast === 'function') {
            window.showToast('Đã thêm sản phẩm vào giỏ hàng!', 'success');
        }
    });
    
})(jQuery);

