<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Products List Widget.
 *
 * @since 1.0
 */
class Starbelly_Products_List_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-products-list';
	}

	public function get_title() {
		return esc_html__( 'Products List', 'starbelly-plugin' );
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
			'categories_tab',
			[
				'label' => esc_html__( 'Categories', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'categories_note',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' =>  sprintf( __( 'All categories and additional categories fields you can edit in <a href="%s" target="_blank">Restaurant -> Categories</a>', 'starbelly-plugin' ), admin_url( 'edit-tags.php?taxonomy=product_cat&post_type=product' ) ),
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'categories_orderby',
			[
				'label'       => esc_html__( 'Categories Orderby', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name'  => __( 'Name', 'starbelly-plugin' ),
					'id' => __( 'ID', 'starbelly-plugin' ),
					'count' => __( 'Count', 'starbelly-plugin' ),
					'slug' => __( 'Slug', 'starbelly-plugin' ),
					'include' => __( 'Selected', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'categories_order',
			[
				'label'       => esc_html__( 'Categories Order', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC'  => __( 'ASC', 'starbelly-plugin' ),
					'DESC' => __( 'DESC', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'categories_count',
			[
				'label' => esc_html__( 'Category Count', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_responsive_control(
			'categories_align',
			[
				'label' => __( 'Alignment', 'starbelly-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'starbelly-plugin' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'starbelly-plugin' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'starbelly-plugin' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sb-menu-category' => 'text-align: {{VALUE}};',
				],
				'default'	=> 'left',
			]
		);

		$this->add_control(
			'categories_description',
			[
				'label' => esc_html__( 'Category Description', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
			'items_note',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' =>  sprintf( __( 'All restaurant menu items and additional item fields you can edit in <a href="%s" target="_blank">Restaurant -> Menu Items</a>', 'starbelly-plugin' ), admin_url( 'edit.php?post_type=product' ) ),
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'categories',
				'options' => [
					'categories' => __( 'Categories', 'starbelly-plugin' ),
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
				'options' => $this->get_product_cat(),
				'condition' => [
            'source' => 'categories'
        ],
			]
		);

		$this->add_control(
			'exclude_custom',
			[
				'label'       => esc_html__( 'Exclude Custom Menu Items', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_product_items_custom(),
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
			'pagination_tab',
			[
				'label' => esc_html__( 'Pagination', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'       => esc_html__( 'Pagination Type', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'button',
			[
				'label'       => esc_html__( 'Button (title)', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter button', 'starbelly-plugin' ),
				'default'     => esc_html__( 'All Posts', 'starbelly-plugin' ),
				'condition' => [
            'pagination' => 'button'
        ],
			]
		);

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
				'default' => 'auto',
				'options' => [
					'auto'  => __( 'Auto', 'starbelly-plugin' ),
					'circle'  => __( 'Circle', 'starbelly-plugin' ),
					'rect' => __( 'Rect', 'starbelly-plugin' ),
					'none' => __( 'None', 'starbelly-plugin' ),
				],
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'settings_tab',
			[
				'label' => esc_html__( 'Settings', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'items_per_row',
			[
				'label'       => esc_html__( 'Items per Row', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'2'  => __( '2 Items', 'starbelly-plugin' ),
					'3'  => __( '3 Items', 'starbelly-plugin' ),
					'4' => __( '4 Items', 'starbelly-plugin' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'category_styling',
			[
				'label'     => esc_html__( 'Category', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'category_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-menu-category h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-menu-category h2',
			]
		);

		$this->add_control(
			'category_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-menu-category .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-menu-category .sb-text',
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
	protected function get_product_cat() {
		$categories = [];

		$args = array(
			'type'			=> 'product',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'product_cat',
			'pad_counts'	=> false
		);

		$menu_categories = get_categories( $args );

		foreach ( $menu_categories as $category ) {
			$categories[$category->term_id] = $category->name;
		}

		return $categories;
	}

	protected function get_product_items_custom() {
		$items = [];

		$args = array(
			'post_type'			=> 'product',
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

		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$page_id = get_the_ID();

		if ( $settings['source'] == 'categories' ) {
			$ids = $settings['source_categories'];
			$cat_ids = $ids;
		} else {
			$ids = '';
			$cat_ids = '';
		}

		$cat_args = array(
			'type'			=> 'product',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> $settings['categories_orderby'],
			'order'			=> $settings['categories_order'],
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'product_cat',
			'pad_counts'	=> false,
			'include'		=> $cat_ids
		);

		$rm_categories = get_categories( $cat_args );

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

		?>

		<?php if ( $rm_categories ) : ?>
		<?php $i = 0; $bg_index = 0; foreach ( $rm_categories as $category ) : $i++; $bg_index++;

		$margin_top = 0;

		if ( $i == 1 ) {
			$margin_top = 90;
		}

		if ( $bg_index == 3 ) {
			$bg_index = 0;
		}

		$category_desc = get_field( 'full_description', 'product_cat_' . $category->term_id );

		if ( $settings['items_per_row'] == '3' ) {
			$col_class = 'col-lg-4';
		} elseif ( $settings['items_per_row'] == '2' ) {
			$col_class = 'col-lg-6';
		} else {
			$col_class = 'col-lg-3';
		}

		$args = array(
			'post_type'			=> 'product',
			'post_status'		=> 'publish',
			'orderby'			=> $settings['sort'],
			'order'				=> $settings['order'],
			'posts_per_page'	=> $settings['limit'],
			'paged' 			=> $paged
		);

		if ( $settings['source'] == 'categories' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $category->term_id
				)
			);

			$args += array('tax_query' => $tax_array);
		}
		if ( !empty( $settings['exclude_custom'] ) ) {
			$args += array( 'post__not_in' => $settings['exclude_custom'] );
		}

		$q = new \WP_Query( $args );

	  ?>

		<?php if ( $q->have_posts() ) : ?>
		<!-- menu section -->
		<section class="sb-menu-section sb-p-<?php echo esc_attr( $margin_top ); ?>-60">
			<?php if ( $settings['bg_type'] == 'auto' ) : ?>
			<div class="sb-bg-<?php echo esc_attr( $bg_index ); ?>">
        <div></div>
      </div>
			<?php else : ?>
			<?php if ( $settings['bg_type'] == 'rect' ) : ?>
			<div class="sb-bg-1">
        <div></div>
      </div>
			<?php endif; ?>
			<?php if ( $settings['bg_type'] == 'circle' ) : ?>
			<div class="sb-bg-2">
				<div></div>
			</div>
			<?php endif; ?>
			<?php endif; ?>

			<div class="container <?php echo esc_attr( $attr_classes ); ?>">

				<div class="sb-menu-category sb-mb-60">
					<h2 class="<?php if ( $settings['items_per_row'] != '3' ) : ?>sb-cate-title <?php endif; ?>sb-mb-15">
						<span><?php echo esc_html( $category->name ); ?></span>
						<?php if ( $settings['categories_count'] == 'yes' ) : ?><small><?php echo esc_html( $category->count ); ?></small><?php endif; ?>
					</h2>
					<?php if ( $category_desc && $settings['categories_description'] == 'yes' ) : ?>
					<div class="sb-text">
						<?php echo wp_kses_post( $category_desc ); ?>
					</div>
					<?php endif; ?>
				</div>

				<div class="row woocommerce">
					<?php while ( $q->have_posts() ) : $q->the_post(); ?>
						<?php
							set_query_var( 'is_column', true );
							set_query_var( 'items_per_row', $settings['items_per_row'] );

							get_template_part( 'woocommerce/content', 'product' );
						?>
					<?php endwhile; ?>

				</div>

			</div>

		</section>
		<?php endif; wp_reset_postdata();?>

		<?php $bg_index++; endforeach; ?>
		<?php endif; ?>

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Products_List_Widget() );
