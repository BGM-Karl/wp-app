<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Restaurant Menu Carousel Widget.
 *
 * @since 1.0
 */
class Starbelly_Restaurant_Menu_Carousel_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-restaurant-menu-carousel';
	}

	public function get_title() {
		return esc_html__( 'Restaurant Menu Carousel', 'starbelly-plugin' );
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
					'categories' => __( 'Categories', 'starbelly-plugin' ),
					'tags' => __( 'Tags', 'starbelly-plugin' ),
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
				'options' => $this->get_restaurant_menu_categories(),
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
				'options' => $this->get_restaurant_menu_tags(),
				'condition' => [
            'source' => 'tags'
        ],
			]
		);

		$this->add_control(
			'source_custom',
			[
				'label'       => esc_html__( 'Custom Menu Items', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_restaurant_menu_items_custom(),
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
				'placeholder' => 6,
				'default'     => 6,
			]
		);

		$this->add_control(
			'sort',
			[
				'label'       => esc_html__( 'Sorting By', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'date',
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
				'default' => 'desc',
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
        'description' => __('Whether to display title of the menu item type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_badge', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Badge', 'starbelly-plugin'),
        'description' => __('Whether to display badge of the menu item type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_title', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Title', 'starbelly-plugin'),
        'description' => __('Whether to display title of the menu item type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

    $this->add_control('attr_excerpt', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Excerpt', 'starbelly-plugin'),
        'description' => __('Whether to display excerpt (short description) of the menu item type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

    $this->add_control('attr_price', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Price', 'starbelly-plugin'),
        'description' => __('Whether to display price of the menu item type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_rating', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Rating', 'starbelly-plugin'),
        'description' => __('Whether to display rating of the menu item type.', 'starbelly-plugin'),
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
				'default' => 'circle',
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
			'item_rating_color',
			[
				'label'     => esc_html__( 'Rating Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-menu-item .sb-stars li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Categories List.
	 *
	 * @since 1.0
	 */
	protected function get_restaurant_menu_categories() {
		$categories = [];

		$args = array(
			'type'			=> 'restaurant_menu',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'restaurant_menu_categories',
			'pad_counts'	=> false
		);

		$menu_categories = get_categories( $args );

		foreach ( $menu_categories as $category ) {
			$categories[$category->term_id] = $category->name;
		}

		return $categories;
	}

	protected function get_restaurant_menu_tags() {
		$tags = [];

		$args = array(
			'type'			=> 'restaurant_menu',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'post_tag',
			'pad_counts'	=> false
		);

		$menu_tags = get_categories( $args );

		foreach ( $menu_tags as $tag ) {
			$tags[$tag->term_id] = $tag->name;
		}

		return $tags;
	}

	protected function get_restaurant_menu_items_custom() {
		$items = [];

		$args = array(
			'post_type'			=> 'restaurant_menu',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1
		);

		$menu_items = new \WP_Query( $args );

		while ( $menu_items->have_posts() ) : $menu_items->the_post();
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
		$this->add_inline_editing_attributes( 'more', 'basic' );

		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$page_id = get_the_ID();
		$cat_ids = '';

		if ( $settings['source'] == 'categories' ) {
			$ids = $settings['source_categories'];
			$cat_ids = $ids;
		} elseif ( $settings['source'] == 'tags' ) {
			$ids = $settings['source_tags'];
		} elseif ( $settings['source'] == 'custom' ) {
			$ids = $settings['source_custom'];
		} else {
			$ids = '';
		}

		$cat_args = array(
			'type'			=> 'restaurant_menu',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'restaurant_menu_categories',
			'pad_counts'	=> false,
			'include'		=> $cat_ids
		);

		$rm_categories = get_categories( $cat_args );

		$args = array(
			'post_type'			=> 'restaurant_menu',
			'post_status'		=> 'publish',
			'orderby'			=> $settings['sort'],
			'order'				=> $settings['order'],
			'posts_per_page'	=> $settings['limit'],
			'paged' 			=> $paged
		);

		if ( $settings['source'] == 'categories' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'restaurant_menu_categories',
					'field'    => 'id',
					'terms'    => $ids
				)
			);

			$args += array('tax_query' => $tax_array);
		}
		if ( $settings['source'] == 'tags' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'post_tag',
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

		$q = new \WP_Query( $args );

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
						<<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-title--h sb-mb-30">
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
								<span class="sb-icon-menu"></span>
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

				<?php if ( $q->have_posts() ) : ?>
				<div class="swiper-container sb-short-menu-slider-<?php echo esc_attr( $settings['carousel_items'] ); ?>i <?php echo esc_attr( $attr_classes ); ?>">
					<div class="swiper-wrapper">
						<?php while ( $q->have_posts() ) : $q->the_post();
							set_query_var( 'is_carousel', true );
							set_query_var( 'items_per_row', $settings['carousel_items'] );

							get_template_part( 'template-parts/content', 'restaurant-menu' );
						endwhile; ?>
					</div>
				</div>
				<?php endif; wp_reset_postdata(); ?>
			</div>
		</section>
		<!-- short menu end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Restaurant_Menu_Carousel_Widget() );
