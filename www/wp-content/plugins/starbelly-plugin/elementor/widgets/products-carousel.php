<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Products Carousel Widget.
 *
 * @since 1.0
 */
class Starbelly_Products_Carousel_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-products-carousel';
	}

	public function get_title() {
		return esc_html__( 'Products (Carousel)', 'starbelly-plugin' );
	}

	public function get_icon() {
		return 'eicon-parallax';
	}

	public function get_categories() {
		return [ 'starbelly-category' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls() {

    $this->start_controls_section(
			'title_tab',
			[
				'label' => esc_html__( 'Title', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Title', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'       => esc_html__( 'Title Tag', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'  => __( 'H1', 'starbelly-plugin' ),
					'h2' => __( 'H2', 'starbelly-plugin' ),
					'h3' => __( 'H3', 'starbelly-plugin' ),
					'h4' => __( 'H4', 'starbelly-plugin' ),
					'div' => __( 'DIV', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter description', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Description', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'button',
			[
				'label'       => esc_html__( 'Button (label)', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Button (link)', 'starbelly-plugin' ),
				'type' => Controls_Manager::URL,
				'show_external' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'items_tab',
			[
				'label' => esc_html__( 'Items', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all'  => __( 'All', 'starbelly-plugin' ),
					'categories' => __( 'Taxonomy (Categories)', 'starbelly-plugin' ),
					'tags' => __( 'Taxonomy (Tags)', 'starbelly-plugin' ),
					'custom' => __( 'Custom', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'source_categories',
			[
				'label'       => esc_html__( 'Categories', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_products_categories(),
				'condition' => [
            'source' => 'categories'
        ],
			]
		);

		$this->add_control(
			'source_tags',
			[
				'label'       => esc_html__( 'Tags', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_products_tags(),
				'condition' => [
            'source' => 'tags'
        ],
			]
		);

		$this->add_control(
			'source_custom',
			[
				'label'       => esc_html__( 'Custom Products', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_products_custom(),
				'condition' => [
            'source' => 'custom'
        ],
			]
		);

		$this->add_control(
			'limit',
			[
				'label'       => esc_html__( 'Number of Items', 'starbelly-plugin' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => 4,
				'default'     => 4,
			]
		);

		$this->add_control(
			'sort',
			[
				'label'       => esc_html__( 'Sorting By', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'menu_order',
				'options' => [
					'date'  => __( 'Date', 'starbelly-plugin' ),
					'title' => __( 'Title', 'starbelly-plugin' ),
					'rand' => __( 'Random', 'starbelly-plugin' ),
					'menu_order' => __( 'Order', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'       => esc_html__( 'Order', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'asc',
				'options' => [
					'asc'  => __( 'ASC', 'starbelly-plugin' ),
					'desc' => __( 'DESC', 'starbelly-plugin' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_settings_tab',
			[
				'label' => esc_html__( 'Item Settings', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control('attr_featured_image', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Featured Image', 'starbelly-plugin'),
        'description' => __('Whether to display title of the product type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_badge', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Badge', 'starbelly-plugin'),
        'description' => __('Whether to display badge of the product type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_title', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Title', 'starbelly-plugin'),
        'description' => __('Whether to display title of the product type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

    $this->add_control('attr_excerpt', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Excerpt', 'starbelly-plugin'),
        'description' => __('Whether to display excerpt (short description) of the product type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

    $this->add_control('attr_price', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Price', 'starbelly-plugin'),
        'description' => __('Whether to display price of the product type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_rating', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Rating', 'starbelly-plugin'),
        'description' => __('Whether to display rating of the product type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_readmore', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Readmore', 'starbelly-plugin'),
        'description' => __('Whether to display readmore button of the product type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_addtocart', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Readmore', 'starbelly-plugin'),
        'description' => __('Whether to display add to cart button of the product type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->end_controls_section();

    $this->start_controls_section(
			'bg_tab',
			[
				'label' => esc_html__( 'Background', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'bg_type',
			[
				'label'       => esc_html__( 'Background Figures', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'rect',
				'options' => [
					'circle'  => __( 'Circle', 'starbelly-plugin' ),
					'rect' => __( 'Rect', 'starbelly-plugin' ),
					'rect2' => __( 'Rect 2', 'starbelly-plugin' ),
					'none' => __( 'None', 'starbelly-plugin' ),
				],
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'carousel_settings_tab',
			[
				'label' => esc_html__( 'Carousel Settings', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'carousel_items',
			[
				'label'       => esc_html__( 'Items per Row', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'3'  => __( '3', 'starbelly-plugin' ),
					'4' => __( '4', 'starbelly-plugin' ),
				],
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'title_styling',
			[
				'label'     => esc_html__( 'Title', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-title .sb-title--h' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-group-title .sb-title--h',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-title .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-group-title .sb-text',
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-title .sb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bgcolor',
			[
				'label'     => esc_html__( 'Button BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-title .sb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'     => esc_html__( 'Button Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-group-title .sb-btn',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'items_styling',
			[
				'label'     => esc_html__( 'Items', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'item_title_bgcolor',
			[
				'label'     => esc_html__( 'Item BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-menu-item .sb-card-tp' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-menu-item .sb-card-tp .sb-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-menu-item .sb-card-tp .sb-card-title',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-menu-item .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-menu-item .sb-text',
			]
		);

		$this->add_control(
			'item_price_color',
			[
				'label'     => esc_html__( 'Price Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-menu-item .sb-card-tp .sb-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_price_bgcolor',
			[
				'label'     => esc_html__( 'Price BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-menu-item .sb-card-tp .sb-price' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_price_typography',
				'label'     => esc_html__( 'Price Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-menu-item .sb-card-tp .sb-price',
			]
		);

    $this->add_control(
			'readmore_bgcolor',
			[
				'label'     => esc_html__( 'Readmore BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-btn.sb-btn-2' => 'background-color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'addtocart_color',
			[
				'label'     => esc_html__( 'Add to Cart Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-btn' => 'color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'addtocart_bgcolor',
			[
				'label'     => esc_html__( 'Add to Cart BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'addtocart_typography',
				'label'     => esc_html__( 'Add to Cart Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-btn',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Categories List.
	 *
	 * @since 1.0
	 */
	protected function get_products_categories() {
		$categories = [];

		$args = array(
			'type'			=> 'product',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'DESC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'product_cat',
			'pad_counts'	=> false
		);

		$products_categories = get_categories( $args );

		foreach ( $products_categories as $category ) {
			$categories[$category->term_id] = $category->name;
		}

		return $categories;
	}

	protected function get_products_tags() {
		$tags = [];

		$args = array(
			'type'			=> 'product',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'DESC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'product_tag',
			'pad_counts'	=> false
		);

		$products_tags = get_categories( $args );

		foreach ( $products_tags as $tag ) {
			$tags[$tag->term_id] = $tag->name;
		}

		return $tags;
	}

	protected function get_products_custom() {
		$items = [];

		$args = array(
			'post_type'			=> 'product',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1
		);

		$products_items = new \WP_Query( $args );

		while ( $products_items->have_posts() ) : $products_items->the_post();
			$items[get_the_ID()] = get_the_title();
		endwhile; wp_reset_postdata();

		return $items;
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

    $this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		$this->add_inline_editing_attributes( 'button', 'none' );

		if ( $settings['source'] == 'categories' ) {
			$ids = $settings['source_categories'];
		} elseif ( $settings['source'] == 'tags' ) {
			$ids = $settings['source_tags'];
		} elseif ( $settings['source'] == 'custom' ) {
			$ids = $settings['source_custom'];
		} else {
			$ids = '';
		}

		$args = array(
			'post_type'			=> 'product',
			'post_status'		=> 'publish',
			'orderby'			=> $settings['sort'],
			'order'				=> $settings['order'],
			'posts_per_page'	=> $settings['limit']
		);

		if ( $settings['source'] == 'categories' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $ids
				)
			);

			$args += array('tax_query' => $tax_array);
		}
		if ( $settings['source'] == 'tags' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'product_tag',
					'field'    => 'id',
					'terms'    => $ids
				)
			);

			$args += array('tax_query' => $tax_array);
		}
		if ( $settings['source'] == 'custom' ) {
			$args += array( 'post__in' => $ids );
		}

		$attr_classes = '';

		if ( $settings['attr_featured_image'] == 'false' ) {
      $attr_classes .= ' attr-featured-false';
    }
		if ( $settings['attr_title'] == 'false' ) {
      $attr_classes .= ' attr-title-false';
    }
		if ( $settings['attr_excerpt'] == 'false' ) {
      $attr_classes .= ' attr-desc-false';
    }
		if ( $settings['attr_price'] == 'false' ) {
      $attr_classes .= ' attr-price-false';
    }
		if ( $settings['attr_badge'] == 'false' ) {
      $attr_classes .= ' attr-badge-false';
    }
		if ( $settings['attr_rating'] == 'false' ) {
      $attr_classes .= ' attr-rating-false';
    }
		if ( $settings['attr_readmore'] == 'false' ) {
      $attr_classes .= ' attr-readmore-false';
    }
		if ( $settings['attr_addtocart'] == 'false' ) {
      $attr_classes .= ' attr-addtocart-false';
    }

		$products_loop = new \WP_Query( $args );

		?>

    <!-- short menu -->
    <section class="sb-short-menu sb-p-0-90">
			<?php if ( $settings['bg_type'] == 'rect' ) : ?>
			<div class="sb-bg-1" style="margin-top: 50px;">
        <div></div>
      </div>
			<?php endif; ?>
			<?php if ( $settings['bg_type'] == 'circle' ) : ?>
			<div class="sb-bg-2">
				<div></div>
			</div>
			<?php endif; ?>
			<?php if ( $settings['bg_type'] == 'rect2' ) : ?>
			<div class="sb-bg-3">
				<div></div>
			</div>
			<?php endif; ?>

      <div class="container">

        <?php if ( $settings['title'] || $settings['description'] || $settings['button'] ) : ?>
				<div class="sb-group-title sb-mb-30">
					<?php if ( $settings['title'] || $settings['description'] ) : ?>
					<div class="sb-left sb-mb-30">
						<?php if ( $settings['title'] ) : ?>
						<<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-title--h sb-cate-title sb-mb-30">
							<span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
								<?php echo wp_kses_post( $settings['title'] ); ?>
							</span>
						</<?php echo esc_attr( $settings['title_tag'] ); ?>>
						<?php endif; ?>
						<?php if ( $settings['description'] ) : ?>
						<p class="sb-text">
							<span <?php echo $this->get_render_attribute_string( 'description' ); ?>>
								<?php echo wp_kses_post( $settings['description'] ); ?>
							</span>
						</p>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<div class="sb-right sb-mb-30">
            <!-- slider navigation -->
            <div class="sb-slider-nav">
              <div class="sb-prev-btn sb-short-menu-prev"><i class="fas fa-arrow-left"></i></div>
              <div class="sb-next-btn sb-short-menu-next"><i class="fas fa-arrow-right"></i></div>
            </div>
            <!-- slider navigation end -->
						<?php if ( $settings['button'] ) : ?>
						<!-- button -->
						<a<?php if ( $settings['link'] ) : if ( $settings['link']['is_external'] ) : ?> target="_blank"<?php endif; ?><?php if ( $settings['link']['nofollow'] ) : ?> rel="nofollow"<?php endif; ?> href="<?php echo esc_url( $settings['link']['url'] ); ?>"<?php endif; ?> class="sb-btn sb-m-0">
							<span class="sb-icon">
								<span class="sb-icon-arrow"></span>
							</span>
							<span <?php echo $this->get_render_attribute_string( 'button' ); ?>>
								<?php echo wp_kses_post( $settings['button'] ); ?>
							</span>
						</a>
						<!-- button end -->
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>

        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <?php if ( $products_loop->have_posts() ) : ?>
        <div class="swiper-container sb-short-menu-slider-<?php echo esc_attr( $settings['carousel_items'] ); ?>i woocommerce <?php echo esc_attr( $attr_classes ); ?>">
          <div class="swiper-wrapper">

            <?php
              while ( $products_loop->have_posts() ) : $products_loop->the_post();

							set_query_var( 'is_carousel', true );
              set_query_var( 'items_per_row', $settings['carousel_items'] );
            ?>
            <div class="swiper-slide">

              <?php get_template_part( 'woocommerce/content', 'product' ); ?>

            </div>
            <?php endwhile; ?>

          </div>
        </div>
        <?php endif; wp_reset_postdata(); ?>
        <?php endif; ?>

      </div>
    </section>
    <!-- short menu end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Products_Carousel_Widget() );
