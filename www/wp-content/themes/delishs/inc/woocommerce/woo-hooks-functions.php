<?php

// shop page hooks
// breadcrumb remove
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
// remove ordering
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
// remove shop sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// content-product hooks--
// action remove
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);


// single product
add_action( 'woocommerce_single_product_summary', 'runok_woo_rating', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 15 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'runok_details_wishlish', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 41 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
if( function_exists( 'runok_blog_social_share' ) ){
add_action( 'woocommerce_single_product_summary', 'runok_blog_social_share', 50 );
}

function runok_details_wishlish(){
    if( class_exists( 'TInvWL_Admin_TInvWL' ) ){
     echo do_shortcode( '[ti_wishlists_addtowishlist]' );
    }            
}


// woocommerce mini cart content
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start();
    ?>
    <div class="mini-shopping-cart-box">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php $fragments['.mini-shopping-cart-box'] = ob_get_clean();
    return $fragments;
});

// woocommerce mini cart count icon
if ( ! function_exists( 'runok_header_add_to_cart_fragment' ) ) {
    function runok_header_add_to_cart_fragment( $fragments ) {
        ob_start();
        ?>
        <span class="cart__count" id="generic-el-cart-item">
            <?php echo esc_html( WC()->cart->cart_contents_count ); ?>
        </span>
        <?php
        $fragments['#generic-el-cart-item'] = ob_get_clean();

        return $fragments;
    }
}
add_filter( 'woocommerce_add_to_cart_fragments', 'runok_header_add_to_cart_fragment' );


// product-content
if( !function_exists('runok_loop_product_thumbnail') ) {
    function runok_loop_product_thumbnail( ) {
        global $product;
        global $post;
        global $woocommerce;
        $rating = wc_get_rating_html($product->get_average_rating());
        $ratingcount = $product->get_review_count();
        ?>
        <div class="product__item text-center transition-3">
           <div class="product__thumb p-relative fix">
            <?php if( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail(); ?>
            <?php endif; ?>

            <?php woocommerce_show_product_loop_sale_flash(); ?>
              
              <div class="product__icon">
                <?php 
                if( class_exists( 'WPCleverWoosq' ) ){
                        echo do_shortcode('[woosq]');
                     }
                ?>

                 <?php  woocommerce_template_loop_add_to_cart();?>

                 <?php 
                 if( class_exists( 'TInvWL_Admin_TInvWL' ) ){
                     echo do_shortcode( '[ti_wishlists_addtowishlist]' );
                    }
                 ?>
              </div>
           </div>

           <div class="product__content">
              <h4 class="product__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h4>
              <div class="product__price">
                 <?php echo woocommerce_template_loop_price();?>
              </div>
            <?php if(!empty($rating)) : ?>
              <div class="product__rating">
                  <?php echo wp_kses_post($rating); ?> 
              </div> 
              <?php endif; ?>
           </div>
        </div>
        <?php
    }
}
add_action( 'woocommerce_before_shop_loop_item', 'runok_loop_product_thumbnail', 10 );

add_filter( 'woosq_button_html', 'runok_woosq_button_html', 10, 2 );
function runok_woosq_button_html( $output , $prodid ) {
    return $output = '<a href="#" class="icon-btn woosq-btn woosq-btn-' . esc_attr( $prodid ) . ' ' . get_option( 'woosq_button_class' ) . '" data-id="' . esc_attr( $prodid ) . '" data-effect="mfp-3d-unfold"><i class="fal fa-eye"></i></a>';
}



// add to cart button
function woocommerce_template_loop_add_to_cart( $args = array() ) {
    global $product;

        if ( $product ) {
            $defaults = array(
                'quantity'   => 1,
                'class'      => implode(
                    ' ',
                    array_filter(
                        array(
                            'cart-button icon-btn',
                            'product_type_' . $product->get_type(),
                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                            $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                        )
                    )
                ),
                'attributes' => array(
                    'data-product_id'  => $product->get_id(),
                    'data-product_sku' => $product->get_sku(),
                    'aria-label'       => $product->add_to_cart_description(),
                    'rel'              => 'nofollow',
                ),
            );

            $args = wp_parse_args( $args, $defaults );

            if ( isset( $args['attributes']['aria-label'] ) ) {
                $args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
            }
        }

        echo sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'cart-button icon-btn' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            '<i class="fal fa-shopping-cart"></i>'
        );
}


/**
 * [runok_woo_rating description]
 * @return [type] [description]
 */


function runok_woo_rating() {
    global $product;
    $rating = $product->get_average_rating();
    $review = 'Rating ' . $rating . ' out of 5';
    $html   = '';
    $html   .= '<div class="details-rating mb-20" title="' . $review . '">';
    for ( $i = 0; $i <= 4; $i ++ ) {
        if ( $i < floor( $rating ) ) {
            $html .= '<i class="fa-sharp fa-solid fa-star"></i>';
        } else {
            $html .= '<i class="fa-sharp fa-solid fa-star"></i>';
        }
    }
    $html .= '<span>( ' . $rating . ' out of 5 )</span>';
    $html .= '</div>';
    print runok_woo_rating_html( $html );
}

function runok_woo_rating_html( $html ) {
    return $html;
}

add_action( 'wp_footer' , 'custom_quantity_fields_script' );
function custom_quantity_fields_script(){
    ?>
    <script type='text/javascript'>
    jQuery( function( $ ) {
        if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function() {
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });
    });
    </script>
    <?php
}