<?php
/**
 * Skin
**/

if ( ! function_exists( 'starbelly_skin' ) ) {

function starbelly_skin() {
	/*colors options*/
	$accent_color1 = get_field( 'accent_color1', 'option' );
	$accent_color2 = get_field( 'accent_color2', 'option' );
	$text_color1 = get_field( 'text_color1', 'option' );
	$text_color2 = get_field( 'text_color2', 'option' );
	$bg_color1 = get_field( 'bg_color1', 'option' );
	$bg_color2 = get_field( 'bg_color2', 'option' );

	/*typography options*/
	$text_font_size = get_field( 'text_font_size', 'option' );
	$text_font_weight = get_field( 'text_font_weight', 'option' );
	$text_font_family = get_field( 'text_font_family', 'option' );
	$text_letter_spacing = get_field( 'text_letter_spacing', 'option' );

	$heading1_font_size = get_field( 'heading1_font_size', 'option' );
	$heading1_font_weight = get_field( 'heading1_font_weight', 'option' );
	$heading1_font_family = get_field( 'heading1_font_family', 'option' );
	$heading1_letter_spacing = get_field( 'heading1_letter_spacing', 'option' );

	$heading2_font_size = get_field( 'heading2_font_size', 'option' );
	$heading2_font_weight = get_field( 'heading2_font_weight', 'option' );
	$heading2_font_family = get_field( 'heading2_font_family', 'option' );
	$heading2_letter_spacing = get_field( 'heading2_letter_spacing', 'option' );

	$heading3_font_size = get_field( 'heading3_font_size', 'option' );
	$heading3_font_weight = get_field( 'heading3_font_weight', 'option' );
	$heading3_font_family = get_field( 'heading3_font_family', 'option' );
	$heading3_letter_spacing = get_field( 'heading3_letter_spacing', 'option' );

	$heading4_font_size = get_field( 'heading4_font_size', 'option' );
	$heading4_font_weight = get_field( 'heading4_font_weight', 'option' );
	$heading4_font_family = get_field( 'heading4_font_family', 'option' );
	$heading4_letter_spacing = get_field( 'heading4_letter_spacing', 'option' );

	$menu_font_size = get_field( 'menu_font_size', 'option' );
	$menu_font_weight = get_field( 'menu_font_weight', 'option' );
	$menu_font_family = get_field( 'menu_font_family', 'option' );
	$menu_letter_spacing = get_field( 'menu_letter_spacing', 'option' );

	/*buttons options*/
	$btn_text_color = get_field( 'btn_text_color', 'option' );
	$btn_bg_color = get_field( 'btn_bg_color', 'option' );
	$btn_font_size = get_field( 'btn_font_size', 'option' );
	$btn_font_weight = get_field( 'btn_font_weight', 'option' );
	$btn_font_family = get_field( 'btn_font_family', 'option' );
	$btn_letter_spacing = get_field( 'btn_letter_spacing', 'option' );
	$btn_border_radius = get_field( 'btn_border_radius', 'option' );
	$btn_height = get_field( 'btn_height', 'option' );
	$btn_transform = get_field( 'btn_transform', 'option' );

	/*breadcrumbs options*/
	$brc_text_color = get_field( 'brc_text_color', 'option' );
	$brc_bg_color = get_field( 'brc_bg_color', 'option' );
	$brc_font_size = get_field( 'brc_font_size', 'option' );
	$brc_font_weight = get_field( 'brc_font_weight', 'option' );
	$brc_font_family = get_field( 'brc_font_family', 'option' );
	$brc_letter_spacing = get_field( 'brc_letter_spacing', 'option' );
	$brc_border_radius = get_field( 'brc_border_radius', 'option' );

	/*preloader options*/
	$preloader = get_field( 'preloader', 'option' );
	$preloader_color = get_field( 'preloader_color', 'option' );
?>

<style>
	/*Begin Colors Options*/
	<?php if ( ! empty( $accent_color1 ) ) : ?>
	::-webkit-scrollbar-thumb {
		background-color: <?php echo esc_attr( $accent_color1 ); ?>;
	}
	.sb-404,
	.sb-stars li,
	.sb-social li a:hover,
	nav .sb-navigation li a:hover,
	.sb-features-item .sb-number,
	.sb-group-input input:valid~.placeholder:after,
	.datepicker .datepicker--cell.-current-,
	.social-share a:hover, .social-share a:hover .icon,
	.wp-block-button.is-style-outline a.wp-block-button__link,
	.woocommerce .star-rating,
	.woocommerce p.stars a {
		color: <?php echo esc_attr( $accent_color1 ); ?>;
	}
	.sb-pagination a.page-numbers:after,
	.sb-pagination span.page-numbers:after,
	.woocommerce nav.woocommerce-pagination a.page-numbers:after,
	.woocommerce nav.woocommerce-pagination span.page-numbers:after,
	.page-links a.post-page-numbers:after,
	.page-links span.post-page-numbers:after,
	.sb-pagination a.page-numbers.current,
	.sb-pagination span.page-numbers.current,
	.woocommerce nav.woocommerce-pagination a.page-numbers.current,
	.woocommerce nav.woocommerce-pagination span.page-numbers.current,
	.page-links a.post-page-numbers.current,
	.page-links span.post-page-numbers.current,
	.sb-keywords li a,
	.sb-breadcrumbs,
	.sb-badge,
	.sb-btn,
	.sb-btn.sb-btn-2 .sb-icon,
	.sb-btn.sb-btn-icon .sb-icon,
	.sb-btn.sb-btn-text,
	.sb-btn.sb-btn-text .sb-icon,
	.sb-load,
	nav .sb-navigation li a:after,
	nav .sb-navigation li a:before,
	.sb-menu-item .sb-card-tp .sb-price,
	.sb-group-input.sb-group-with-btn button,
	.sb-group-input .sb-bar:before,
	.sb-map-frame .sb-map.sb-active,
	.sb-lock,
	.sb-filter .sb-filter-link.sb-active,
	.sb-team-member .sb-photo-frame:before,
	.sb-categorie-card .sb-card-body .sb-category-icon:before,
	.sb-product-description .sb-price-frame .sb-price,
	.sb-radio input[type=radio]:checked~.sb-check::before,
	.sb-faq .sb-plus-minus-toggle,
	.datepicker .datepicker--cell.-selected-,
	.sb-cart-number,
	.sb-input-number-frame .sb-input-number-btn,
	.sb-illustration-1 .sb-cirkle-2,
	.sb-illustration-1 .sb-cirkle-3,
	.sb-illustration-1 .sb-cirkle-4,
	.sb-illustration-1-2 .sb-cirkle-2,
	.sb-illustration-1-2 .sb-cirkle-3,
	.sb-illustration-1-2 .sb-cirkle-4,
	.sb-illustration-1-404 .sb-cirkle-2,
	.sb-illustration-1-404 .sb-cirkle-3,
	.sb-illustration-1-404 .sb-cirkle-4,
	.sb-illustration-2 .sb-cirkle-2,
	.sb-illustration-2 .sb-cirkle-3,
	.sb-illustration-3 .sb-cirkle-2,
	.sb-illustration-3 .sb-cirkle-3,
	.sb-illustration-3 .sb-cirkle-4,
	.sb-illustration-4 .sb-cirkle-2,
	.sb-illustration-4 .sb-cirkle-3,
	.sb-illustration-5 .sb-cirkle-2,
	.sb-illustration-5 .sb-cirkle-3,
	.sb-illustration-6 .sb-cirkle-2,
	.sb-illustration-6 .sb-cirkle-3,
	.sb-illustration-6 .sb-cirkle-4,
	.sb-illustration-7 .sb-cirkle-2,
	.sb-illustration-7 .sb-cirkle-3,
	.sb-illustration-8 .sb-cirkle-2,
	.sb-illustration-8 .sb-cirkle-3,
	.sb-illustration-8 .sb-cirkle-4,
	.sb-illustration-9 .sb-cirkle-2,
	.sb-illustration-9 .sb-cirkle-3,
	.datepicker .datepicker--cell.-selected-,
	.datepicker .datepicker--cell.-selected-.-current-,
	.datepicker .datepicker--cell.-selected-:hover,
	.datepicker .datepicker--cell.-selected-.-current-:hover,
	.widget-area .widget_search input.search-submit,
	.wp-block-search .wp-block-search__button,
	.post-text-bottom .tags-links a,
	.wp-block-tag-cloud .tag-cloud-link,
	.widget-area .widget_tag_cloud .tag-cloud-link,
	.widget-area td#today,
	.sticky:before,
	.wp-block-button a.wp-block-button__link,
	.post-password-form input[type="submit"],
	.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
	.select2-container--default .select2-results__option--highlighted[aria-selected],
	.select2-container--default .select2-results__option--highlighted[data-selected] {
		background-color: <?php echo esc_attr( $accent_color1 ); ?>;
	}
	.sb-radio input[type=radio]:checked~.sb-check,
	.wp-block-pullquote blockquote,
	.wp-block-button.is-style-outline a.wp-block-button__link {
		border-color: <?php echo esc_attr( $accent_color1 ); ?>;
	}
	.mapboxgl-marker svg g,
	.sb-social li a:hover svg 
	{
		fill: <?php echo esc_attr( $accent_color1 ); ?>;
	}
	.sb-team-member .sb-photo-frame:before {
	  box-shadow: 0 0 0 3px <?php echo esc_attr( $accent_color1 ); ?>;
	}
	@media (max-width: 992px) {
	  nav .sb-navigation li ul {
	    background-color: <?php echo esc_attr( $accent_color1 ); ?>;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $accent_color2 ) ) : ?>
	::-webkit-scrollbar-track {
		background-color: <?php echo esc_attr( $accent_color2 ); ?>;
	}
	.sb-stars li.sb-empty {
		color: <?php echo esc_attr( $accent_color2 ); ?>;
	}
	.sb-suptitle,
	.sb-list li span.sb-number,
	.sb-btn.sb-btn-2.sb-btn-gray .sb-icon,
	.sb-btn.sb-btn-icon.sb-btn-gray .sb-icon,
	.sb-btn.sb-btn-text.sb-btn-gray,
	.sb-btn.sb-btn-text.sb-btn-gray .sb-icon,
	.sb-menu-item .sb-card-tp,
	.sb-menu-item .sb-cover-frame,
	.sb-lock.sb-active,
	.sb-filter .sb-filter-link,
	.sb-cart-table .sb-cart-item .sb-remove,
	.sb-remove,
	.sb-comment-box .sb-comment-head .sb-date {
		background-color: <?php echo esc_attr( $accent_color2 ); ?>;
	}
	.sb-list li,
	.sb-list li:first-child,
	.sb-post-navigation,
	.sb-top-bar-frame,
	nav .sb-navigation li ul,
	.footer,
	.sb-info-bar,
	.sb-info-bar .sb-info-bar-footer,
	.sb-minicart,
	.sb-minicart .sb-minicart-content .sb-menu-item,
	.sb-minicart .sb-minicart-footer,
	.sb-contact-form-frame .sb-form-content,
	.sb-group-input input,
	.sb-group-input select,
	.sb-group-input textarea,
	textarea,
	select,
	.sb-sidebar-frame .sb-sidebar,
	.sb-faq li,
	.sb-faq li:last-child,
	.sb-cart-table .sb-cart-item,
	.sb-cart-total,
	.sb-cart-btns-frame,
	.sb-illustration-2 .sb-experience .sb-exp-content,
	.sb-comment-box {
		border-color: <?php echo esc_attr( $accent_color2 ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $text_color1 ) ) : ?>
	body,
	.sb-text a, .description a,
	.sb-suptitle,
	.sb-list li span.sb-number,
	.sb-pagination a.page-numbers,
	.sb-pagination span.page-numbers,
	.woocommerce nav.woocommerce-pagination a.page-numbers,
	.woocommerce nav.woocommerce-pagination span.page-numbers,
	.page-links a.post-page-numbers,
	.page-links span.post-page-numbers,
	.sb-pagination a.page-numbers:hover,
	.sb-pagination span.page-numbers:hover,
	.woocommerce nav.woocommerce-pagination a.page-numbers:hover,
	.woocommerce nav.woocommerce-pagination span.page-numbers:hover,
	.page-links a.post-page-numbers:hover,
	.page-links span.post-page-numbers:hover,
	.sb-pagination a.page-numbers.current,
	.sb-pagination span.page-numbers.current,
	.woocommerce nav.woocommerce-pagination a.page-numbers.current,
	.woocommerce nav.woocommerce-pagination span.page-numbers.current,
	.page-links a.post-page-numbers.current,
	.page-links span.post-page-numbers.current,
	.sb-keywords li a,
	nav .sb-navigation li a,
	.sb-group-input input:focus~.placeholder,
	.sb-group-input input:valid~.placeholder,
	.sb-group-input textarea:focus~.placeholder,
	.sb-group-input textarea:valid~.placeholder,
	.sb-filter .sb-filter-link.sb-active,
	.sb-filter .sb-filter-link:hover,
	.sb-cart-table .sb-cart-item .sb-remove,
	.sb-remove,
	.sb-price-2,
	.widget-area ul li a,
	.widget-area ol li a,
	.widget-area .widget_rss .rss-date,
	.post-text-bottom .tags-links a,
	.wp-block-tag-cloud .tag-cloud-link,
	.widget-area .widget_tag_cloud .tag-cloud-link,
	.post-edit-link,
	.single-post-text dt,
	.single-post-text h1,
	.single-post-text h2,
	.single-post-text h3,
	.single-post-text h4,
	.single-post-text h5,
	.single-post-text h6,
	.single-post-text blockquote,
	.single-post-text blockquote:before,
	.single-post-text blockquote:after,
	.post-text-bottom span.cat-links a,
	.post-text-bottom span.cat-links a:hover,
	.sb-comment-box .sb-comment-head .sb-date {
		color: <?php echo esc_attr( $text_color1 ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $text_color2 ) ) : ?>
	.sb-text,
	.description,
	.single-post-text,
	.sb-ib-title-frame i,
	.sb-list li span,
	.sb-pagination,
	.woocommerce nav.woocommerce-pagination,
	.page-links,
	.sb-stars li span,
	.footer .sb-footer-frame .sb-copy,
	.sb-group-input label,
	.sb-group-input .placeholder,
	.sb-filter .sb-filter-link,
	.sb-price-1,
	.widget-area .widget_block h2:before,
	.widget-area ul li,
	.widget-area ol li,
	.post-text-bottom,
	.wp-caption-text,
	.wp-block-image figcaption,
	.wp-block-video figcaption,
	.wp-block-embed figcaption {
		color: <?php echo esc_attr( $text_color2 ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $bg_color1 ) ) : ?>
	.sb-app,
	.sb-info-bar,
	.sb-info-bar .sb-info-bar-footer,
	.sb-minicart .sb-minicart-footer,
	.sb-popup-frame .sb-popup-body,
	.sb-sidebar-frame,
	.sb-top-bar-frame .sb-top-bar-bg,
	.footer {
		background-color: <?php echo esc_attr( $bg_color1 ); ?>;
	}
	.sb-banner.sb-banner-color,
	.sb-map-frame,
	.sb-bg-1,
	.sb-bg-3 {
		border-color: <?php echo esc_attr( $bg_color1 ); ?>;
	}
	@media (max-width: 768px) {
	  .sb-bg-1 {
	    border-color: <?php echo esc_attr( $bg_color1 ); ?>;
	  }
	}
	<?php endif; ?>
	<?php if ( ! empty( $bg_color2 ) ) : ?>
	body,
	.sb-h1 b,
	.sb-h1 span span,
	h1 b,
	h1 span span,
	.sb-h2 b,
	.sb-h2 span span,
	h2 b,
	h2 span span,
	.sb-pagination a.page-numbers,
	.sb-pagination span.page-numbers,
	.woocommerce nav.woocommerce-pagination a.page-numbers,
	.woocommerce nav.woocommerce-pagination span.page-numbers,
	.page-links a.post-page-numbers,
	.page-links span.post-page-numbers,
	.sb-pagination a.page-numbers:hover,
	.sb-pagination span.page-numbers:hover,
	.woocommerce nav.woocommerce-pagination a.page-numbers:hover,
	.woocommerce nav.woocommerce-pagination span.page-numbers:hover,
	.page-links a.post-page-numbers:hover,
	.page-links span.post-page-numbers:hover,
	.sb-banner.sb-banner-color,
	.sb-promo-content .sb-image-frame,
	.sb-promo-frame,
	.sb-author-panel .sb-suptitle,
	.sb-blog-card .sb-cover-frame,
	.sb-team-member .sb-photo-frame,
	.sb-team-member:hover .sb-photo-frame,
	.sb-categorie-card,
	.sb-product-description .sb-price-frame,
	.sb-faq .sb-plus-minus-toggle.sb-collapsed,
	.sb-co-cart-frame,
	.sb-bg-1 div:after,
	.sb-bg-3,
	.sb-illustration-2 .sb-square {
		background-color: <?php echo esc_attr( $bg_color2 ); ?>;
	}
	.sb-bg-2 div:after {
	  border-color: <?php echo esc_attr( $bg_color2 ); ?>;
	}
	<?php endif; ?>
	/*End Colors Options*/

	/*Begin Typography Options*/
	<?php if ( ! empty( $text_font_size ) ) : ?>
	.sb-preloader .sb-preloader-body .sb-loading,
	body,
	.sb-text.sb-text-lg,
	.sb-faq .sb-answer,
	.sb-text,
	.description,
	.single-post-text,
	.post-text-bottom {
		font-size: <?php echo esc_attr( $text_font_size ); ?>px;
	}
	<?php endif; ?>
	<?php if ( ! empty( $text_font_weight ) ) : ?>
	.sb-preloader .sb-preloader-body .sb-loading,
	body,
	.sb-text.sb-text-lg,
	.sb-faq .sb-answer,
	.sb-text,
	.description,
	.single-post-text,
	.post-text-bottom {
		font-weight: <?php echo esc_attr( $text_font_weight ); ?>;
	}
	<?php endif; ?>
	<?php if ( isset( $text_letter_spacing ) && $text_letter_spacing != '' ) : ?>
	.sb-preloader .sb-preloader-body .sb-loading,
	body,
	.sb-text.sb-text-lg,
	.sb-faq .sb-answer,
	.sb-text,
	.description,
	.single-post-text,
	.post-text-bottom {
		letter-spacing: <?php echo esc_attr( $text_letter_spacing ); ?>px;
	}
	<?php endif; ?>
	<?php if ( ! empty( $text_font_family ) ) : ?>
	.sb-preloader .sb-preloader-body .sb-loading,
	body,
	.sb-text.sb-text-lg,
	.sb-faq .sb-answer,
	.sb-text,
	.description,
	.single-post-text,
	.post-text-bottom {
		font-family: '<?php echo esc_attr( $text_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading1_font_size ) ) : ?>
	@media (min-width: 993px) {
		.sb-h1,
		h1 {
			font-size: <?php echo esc_attr( $heading1_font_size ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading1_font_weight ) ) : ?>
	.sb-h1,
	h1 {
		font-weight: <?php echo esc_attr( $heading1_font_weight ); ?>;
	}
	<?php endif; ?>
	<?php if ( isset( $heading1_letter_spacing ) && $heading1_letter_spacing != '' ) : ?>
	@media (min-width: 993px) {
		.sb-h1,
		h1 {
			letter-spacing: <?php echo esc_attr( $heading1_letter_spacing ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading1_font_family ) ) : ?>
	.sb-h1,
	h1 {
		font-family: '<?php echo esc_attr( $heading1_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading2_font_size ) ) : ?>
	@media (min-width: 993px) {
		.sb-h2,
		h2 {
			font-size: <?php echo esc_attr( $heading2_font_size ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading2_font_weight ) ) : ?>
	.sb-h2,
	h2 {
		font-weight: <?php echo esc_attr( $heading2_font_weight ); ?>;
	}
	<?php endif; ?>
	<?php if ( isset( $heading2_letter_spacing ) && $heading2_letter_spacing != '' ) : ?>
	@media (min-width: 993px) {
		.sb-h2,
		h2 {
			letter-spacing: <?php echo esc_attr( $heading2_letter_spacing ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading2_font_family ) ) : ?>
	.sb-h2,
	h2 {
		font-family: '<?php echo esc_attr( $heading2_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading3_font_size ) ) : ?>
	@media (min-width: 993px) {
		.sb-h3,
		h3 {
			font-size: <?php echo esc_attr( $heading3_font_size ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading3_font_weight ) ) : ?>
	.sb-h3,
	h3 {
		font-weight: <?php echo esc_attr( $heading3_font_weight ); ?>;
	}
	<?php endif; ?>
	<?php if ( isset( $heading3_letter_spacing ) && $heading3_letter_spacing != '' ) : ?>
	@media (min-width: 993px) {
		.sb-h3,
		h3 {
			letter-spacing: <?php echo esc_attr( $heading3_letter_spacing ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading3_font_family ) ) : ?>
	.sb-h3,
	h3 {
		font-family: '<?php echo esc_attr( $heading3_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading4_font_size ) ) : ?>
	@media (min-width: 993px) {
		.sb-h4,
		h4 {
			font-size: <?php echo esc_attr( $heading4_font_size ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading4_font_weight ) ) : ?>
	.sb-h4,
	h4 {
		font-weight: <?php echo esc_attr( $heading4_font_weight ); ?>;
	}
	<?php endif; ?>
	<?php if ( isset( $heading4_letter_spacing ) && $heading4_letter_spacing != '' ) : ?>
	@media (min-width: 993px) {
		.sb-h4,
		h4 {
			letter-spacing: <?php echo esc_attr( $heading4_letter_spacing ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $heading4_font_family ) ) : ?>
	.sb-h4,
	h4 {
		font-family: '<?php echo esc_attr( $heading4_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>
	<?php if ( ! empty( $menu_font_size ) ) : ?>
	@media (min-width: 993px) {
		nav .sb-navigation li a {
			font-size: <?php echo esc_attr( $menu_font_size ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $menu_font_weight ) ) : ?>
	nav .sb-navigation li a {
		font-weight: <?php echo esc_attr( $menu_font_weight ); ?>;
	}
	<?php endif; ?>
	<?php if ( isset( $menu_letter_spacing ) && $menu_letter_spacing != '' ) : ?>
	@media (min-width: 993px) {
		nav .sb-navigation li a {
			letter-spacing: <?php echo esc_attr( $menu_letter_spacing ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $menu_font_family ) ) : ?>
	nav .sb-navigation li a {
		font-family: '<?php echo esc_attr( $menu_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>
	/*End Typography Options*/

	/*Begin Buttons Options*/
	<?php if ( ! empty( $btn_text_color ) ) : ?>
	.sb-btn,
	.sb-btn.sb-btn-2 .sb-icon,
	.sb-btn.sb-btn-icon .sb-icon,
	.sb-btn.sb-btn-text,
	.sb-btn.sb-btn-text .sb-icon,
	.sb-group-input.sb-group-with-btn button,
	.sb-filter .sb-filter-link.sb-active,
	.sb-faq .sb-plus-minus-toggle,
	.sb-input-number-frame .sb-input-number-btn,
	.widget-area .widget_search input.search-submit,
	.wp-block-search .wp-block-search__button,
	.wp-block-button a.wp-block-button__link,
	.post-password-form input[type="submit"],
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-mini-cart__buttons #respond input#submit,
	.woocommerce-mini-cart__buttons a.button,
	.woocommerce-mini-cart__buttons button.button,
	.woocommerce-mini-cart__buttons input.button,
	.woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover {
		color: <?php echo esc_attr( $btn_text_color ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $btn_bg_color ) ) : ?>
	.sb-btn,
	.sb-btn.sb-btn-2 .sb-icon,
	.sb-btn.sb-btn-icon .sb-icon,
	.sb-btn.sb-btn-text,
	.sb-btn.sb-btn-text .sb-icon,
	.sb-group-input.sb-group-with-btn button,
	.sb-filter .sb-filter-link.sb-active,
	.sb-faq .sb-plus-minus-toggle,
	.sb-input-number-frame .sb-input-number-btn,
	.widget-area .widget_search input.search-submit,
	.wp-block-search .wp-block-search__button,
	.wp-block-button a.wp-block-button__link,
	.post-password-form input[type="submit"],
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-mini-cart__buttons #respond input#submit,
	.woocommerce-mini-cart__buttons a.button,
	.woocommerce-mini-cart__buttons button.button,
	.woocommerce-mini-cart__buttons input.button,
	.woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover {
		background-color: <?php echo esc_attr( $btn_bg_color ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $btn_font_size ) ) : ?>
	@media (min-width: 993px) {
		.sb-btn,
		.sb-btn.sb-btn-2 .sb-icon,
		.sb-btn.sb-btn-icon .sb-icon,
		.sb-btn.sb-btn-text,
		.sb-btn.sb-btn-text .sb-icon,
		.sb-group-input.sb-group-with-btn button,
		.sb-filter .sb-filter-link.sb-active,
		.sb-faq .sb-plus-minus-toggle,
		.sb-input-number-frame .sb-input-number-btn,
		.widget-area .widget_search input.search-submit,
		.wp-block-search .wp-block-search__button,
		.wp-block-button a.wp-block-button__link,
		.post-password-form input[type="submit"],
		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button,
		.woocommerce-mini-cart__buttons #respond input#submit,
		.woocommerce-mini-cart__buttons a.button,
		.woocommerce-mini-cart__buttons button.button,
		.woocommerce-mini-cart__buttons input.button,
		.woocommerce-mini-cart__buttons a.button.checkout,
		.woocommerce-mini-cart__buttons button.button.checkout,
		.woocommerce-mini-cart__buttons input.button.checkout,
		.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
		.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
		.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
		.woocommerce-mini-cart__buttons a.button.checkout:hover,
		.woocommerce-mini-cart__buttons button.button.checkout:hover,
		.woocommerce-mini-cart__buttons input.button.checkout:hover,
		.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
		.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
		.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover,
		.woocommerce #respond input#submit.alt,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt,
		.woocommerce input.button.alt,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce a.button.alt:hover,
		.woocommerce button.button.alt:hover,
		.woocommerce input.button.alt:hover {
			font-size: <?php echo esc_attr( $btn_font_size ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $btn_font_weight ) ) : ?>
	.sb-btn,
	.sb-btn.sb-btn-2 .sb-icon,
	.sb-btn.sb-btn-icon .sb-icon,
	.sb-btn.sb-btn-text,
	.sb-btn.sb-btn-text .sb-icon,
	.sb-group-input.sb-group-with-btn button,
	.sb-filter .sb-filter-link.sb-active,
	.sb-faq .sb-plus-minus-toggle,
	.sb-input-number-frame .sb-input-number-btn,
	.widget-area .widget_search input.search-submit,
	.wp-block-search .wp-block-search__button,
	.wp-block-button a.wp-block-button__link,
	.post-password-form input[type="submit"],
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-mini-cart__buttons #respond input#submit,
	.woocommerce-mini-cart__buttons a.button,
	.woocommerce-mini-cart__buttons button.button,
	.woocommerce-mini-cart__buttons input.button,
	.woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover {
		font-weight: <?php echo esc_attr( $btn_font_weight ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $btn_font_family ) ) : ?>
	.sb-btn,
	.sb-btn.sb-btn-2 .sb-icon,
	.sb-btn.sb-btn-icon .sb-icon,
	.sb-btn.sb-btn-text,
	.sb-btn.sb-btn-text .sb-icon,
	.sb-group-input.sb-group-with-btn button,
	.sb-filter .sb-filter-link.sb-active,
	.sb-faq .sb-plus-minus-toggle,
	.sb-input-number-frame .sb-input-number-btn,
	.widget-area .widget_search input.search-submit,
	.wp-block-search .wp-block-search__button,
	.wp-block-button a.wp-block-button__link,
	.post-password-form input[type="submit"],
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-mini-cart__buttons #respond input#submit,
	.woocommerce-mini-cart__buttons a.button,
	.woocommerce-mini-cart__buttons button.button,
	.woocommerce-mini-cart__buttons input.button,
	.woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover {
		font-family: '<?php echo esc_attr( $btn_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>
	<?php if ( isset( $btn_letter_spacing ) && $btn_letter_spacing != '' ) : ?>
	@media (min-width: 993px) {
		.sb-btn,
		.sb-btn.sb-btn-2 .sb-icon,
		.sb-btn.sb-btn-icon .sb-icon,
		.sb-btn.sb-btn-text,
		.sb-btn.sb-btn-text .sb-icon,
		.sb-group-input.sb-group-with-btn button,
		.sb-filter .sb-filter-link.sb-active,
		.sb-faq .sb-plus-minus-toggle,
		.sb-input-number-frame .sb-input-number-btn,
		.widget-area .widget_search input.search-submit,
		.wp-block-search .wp-block-search__button,
		.wp-block-button a.wp-block-button__link,
		.post-password-form input[type="submit"],
		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button,
		.woocommerce-mini-cart__buttons #respond input#submit,
		.woocommerce-mini-cart__buttons a.button,
		.woocommerce-mini-cart__buttons button.button,
		.woocommerce-mini-cart__buttons input.button,
		.woocommerce-mini-cart__buttons a.button.checkout,
		.woocommerce-mini-cart__buttons button.button.checkout,
		.woocommerce-mini-cart__buttons input.button.checkout,
		.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
		.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
		.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
		.woocommerce-mini-cart__buttons a.button.checkout:hover,
		.woocommerce-mini-cart__buttons button.button.checkout:hover,
		.woocommerce-mini-cart__buttons input.button.checkout:hover,
		.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
		.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
		.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover,
		.woocommerce #respond input#submit.alt,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt,
		.woocommerce input.button.alt,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce a.button.alt:hover,
		.woocommerce button.button.alt:hover,
		.woocommerce input.button.alt:hover {
			letter-spacing: <?php echo esc_attr( $btn_letter_spacing ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( isset( $btn_border_radius ) & $btn_border_radius != '' ) : ?>
	.sb-btn,
	.sb-btn.sb-btn-2 .sb-icon,
	.sb-btn.sb-btn-icon .sb-icon,
	.sb-btn.sb-btn-text,
	.sb-btn.sb-btn-text .sb-icon,
	.sb-group-input.sb-group-with-btn button,
	.sb-filter .sb-filter-link.sb-active,
	.sb-faq .sb-plus-minus-toggle,
	.sb-input-number-frame .sb-input-number-btn,
	.widget-area .widget_search input.search-submit,
	.wp-block-search .wp-block-search__button,
	.wp-block-button a.wp-block-button__link,
	.post-password-form input[type="submit"],
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-mini-cart__buttons #respond input#submit,
	.woocommerce-mini-cart__buttons a.button,
	.woocommerce-mini-cart__buttons button.button,
	.woocommerce-mini-cart__buttons input.button,
	.woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover {
		border-radius: <?php echo esc_attr( $btn_border_radius ); ?>px;
	}
	<?php endif; ?>
	<?php if ( isset( $btn_height ) & $btn_height != '' ) : ?>
	.sb-btn,
	.sb-btn.sb-btn-2 .sb-icon,
	.sb-btn.sb-btn-icon .sb-icon,
	.sb-btn.sb-btn-text,
	.sb-btn.sb-btn-text .sb-icon,
	.sb-group-input.sb-group-with-btn button,
	.sb-filter .sb-filter-link.sb-active,
	.sb-faq .sb-plus-minus-toggle,
	.sb-input-number-frame .sb-input-number-btn,
	.widget-area .widget_search input.search-submit,
	.wp-block-search .wp-block-search__button,
	.wp-block-button a.wp-block-button__link,
	.post-password-form input[type="submit"],
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-mini-cart__buttons #respond input#submit,
	.woocommerce-mini-cart__buttons a.button,
	.woocommerce-mini-cart__buttons button.button,
	.woocommerce-mini-cart__buttons input.button,
	.woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover {
		height: <?php echo esc_attr( $btn_height ); ?>px;
	}
	<?php endif; ?>
	<?php if ( isset( $btn_transform ) & $btn_transform != '' ) : ?>
	.sb-btn,
	.sb-btn.sb-btn-2 .sb-icon,
	.sb-btn.sb-btn-icon .sb-icon,
	.sb-btn.sb-btn-text,
	.sb-btn.sb-btn-text .sb-icon,
	.sb-group-input.sb-group-with-btn button,
	.sb-filter .sb-filter-link.sb-active,
	.sb-faq .sb-plus-minus-toggle,
	.sb-input-number-frame .sb-input-number-btn,
	.widget-area .widget_search input.search-submit,
	.wp-block-search .wp-block-search__button,
	.wp-block-button a.wp-block-button__link,
	.post-password-form input[type="submit"],
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce-mini-cart__buttons #respond input#submit,
	.woocommerce-mini-cart__buttons a.button,
	.woocommerce-mini-cart__buttons button.button,
	.woocommerce-mini-cart__buttons input.button,
	.woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout,
	.woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons a.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons button.button.checkout:hover,
	.woocommerce .woocommerce-mini-cart__buttons input.button.checkout:hover,
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover {
		text-transform: <?php echo esc_attr( $btn_transform ); ?>;
	}
	<?php endif; ?>
	/*End Buttons Options*/

	/*Begin Breadcrumbs Options*/
	<?php if ( ! empty( $brc_text_color ) ) : ?>
	.sb-breadcrumbs li,
	.sb-breadcrumbs li > a,
	.sb-breadcrumbs li:last-child > a,
	.sb-breadcrumbs li:last-child > span {
		color: <?php echo esc_attr( $brc_text_color ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $brc_bg_color ) ) : ?>
	.sb-breadcrumbs {
		background-color: <?php echo esc_attr( $brc_bg_color ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $brc_font_size ) ) : ?>
	@media (min-width: 993px) {
		.sb-breadcrumbs {
			font-size: <?php echo esc_attr( $brc_font_size ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $brc_font_weight ) ) : ?>
	.sb-breadcrumbs {
		font-weight: <?php echo esc_attr( $brc_font_weight ); ?>;
	}
	<?php endif; ?>
	<?php if ( ! empty( $brc_font_family ) ) : ?>
	.sb-breadcrumbs {
		font-family: '<?php echo esc_attr( $brc_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>
	<?php if ( isset( $brc_letter_spacing ) && $brc_letter_spacing != '' ) : ?>
	@media (min-width: 993px) {
		.sb-breadcrumbs {
			letter-spacing: <?php echo esc_attr( $brc_letter_spacing ); ?>px;
		}
	}
	<?php endif; ?>
	<?php if ( isset( $brc_border_radius ) && $brc_border_radius != '' ) : ?>
	.sb-breadcrumbs {
		border-radius: <?php echo esc_attr( $brc_border_radius ); ?>px;
	}
	<?php endif; ?>
	/*End Breadcrumbs Options*/

	/*Begin Preloader Options*/
	<?php if ( ! empty( $preloader ) ) : ?>
	.sb-preloader {
		display: none !important;
	}
	<?php endif; ?>
	<?php if ( ! empty( $preloader_color ) ) : ?>
	.sb-preloader .sb-preloader-bg {
		background-color: <?php echo esc_attr( $preloader_color ); ?>!important;
	}
	<?php endif; ?>
	/*End Preloader Options*/
</style>

<?php
}
add_action( 'wp_head', 'starbelly_skin', 10 );

}
