<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Restaurant Menu Grid Widget.
 *
 * @since 1.0
 */
class Starbelly_Products_Grid_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-products-grid';
	}

	public function get_title() {
		return esc_html__( 'Products Grid', 'starbelly-plugin' );
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
			'filters_tab',
			[
				'label' => esc_html__( 'Filters', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'filters_note',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Filters show only with [Pagination -> No]', 'starbelly-plugin' ),
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'filters',
			[
				'label' => esc_html__( 'Show Filters', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
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
				'options' => $this->get_product_cat(),
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
				'options' => $this->get_product_tags(),
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
				'options' => $this->get_product_items_custom(),
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
					'pages' => __( 'Pages', 'starbelly-plugin' ),
					'button' => __( 'Button', 'starbelly-plugin' ),
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

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Button (link)', 'starbelly-plugin' ),
				'type'        => Controls_Manager::URL,
				'show_external' => true,
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
				'default' => 'rect',
				'options' => [
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

		$this->start_controls_section(
			'pagination_styling',
			[
				'label'     => esc_html__( 'Pagination', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pag_btn_color',
			[
				'label'     => esc_html__( 'Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-btns .sb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pag_btn_bgcolor',
			[
				'label'     => esc_html__( 'Button BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-btns .sb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pag_btn_typography',
				'label'     => esc_html__( 'Button Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-btns .sb-btn',
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

	protected function get_product_tags() {
		$tags = [];

		$args = array(
			'type'			=> 'product',
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

		$this->add_inline_editing_attributes( 'button', 'none' );

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

		$q = new \WP_Query( $args );

		?>

		<!-- menu section 1 -->
		<section class="sb-menu-section sb-p-90-60">
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

			<div class="container <?php echo esc_attr( $attr_classes ); ?>">
				<?php if ( $q->have_posts() ) : ?>

				<?php if ( $settings['filters'] == 'yes' && $rm_categories && $settings['pagination'] != 'pages' ) : ?>
				<!-- filter -->
				<div class="sb-filter mb-30">
					<a href="#." data-filter="*" class="sb-filter-link sb-active"><?php echo esc_html__( 'All dishes', 'starbelly-plugin' ); ?></a>
					<?php foreach ( $rm_categories as $category ) : ?>
					<a href="#." data-filter=".category-<?php echo esc_attr( $category->slug ); ?>" class="sb-filter-link">
						<span><?php echo esc_html( $category->name ); ?></span>
						<?php if ( $settings['categories_count'] == 'yes' ) : ?><small><?php echo esc_html( $category->count ); ?></small><?php endif; ?>
					</a>
					<?php endforeach; ?>
				</div>
				<!-- filter end -->
				<?php endif; ?>

				<div class="sb-masonry-grid">
					<div class="sb-grid-sizer"></div>

					<?php while ( $q->have_posts() ) : $q->the_post();
						set_query_var( 'is_masonry', true );
						set_query_var( 'items_per_row', $settings['items_per_row'] );

						get_template_part( 'woocommerce/content', 'product' );
					endwhile; ?>

				</div>

				<?php if ( $settings['pagination'] == 'pages' ) : ?>
        <div class="sb-pagination">
          <?php
  					$big = 999999999; // need an unlikely integer

  					echo paginate_links( array(
  						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
  						'format' => '?paged=%#%',
  						'current' => max( 1, get_query_var('paged') ),
  						'total' => $q->max_num_pages,
  						'prev_text' => '<i class="icon-arrow-left"></i>',
  						'next_text' => '<i class="icon-arrow-right"></i>',
  					) );
  				?>
        </div>
        <?php endif; ?>

        <?php if ( $settings['pagination'] == 'button' && $settings['button'] ) : ?>
  			<div class="sb-btns">
  				<a class="sb-btn" href="<?php echo esc_url( $settings['link']['url'] ); ?>"<?php if ( $settings['link']['is_external'] ) : ?> target="_blank"<?php endif; ?><?php if ( $settings['link']['nofollow'] ) : ?> rel="nofollow"<?php endif; ?>>
            <span class="sb-icon">
              <span class="sb-icon-arrow"></span>
            </span>
            <span><?php echo esc_html( $settings['button'] ); ?></span>
          </a>
  			</div>
				<?php endif; ?>

				<?php else :
					get_template_part( 'template-parts/content', 'none' );
				endif; wp_reset_postdata(); ?>

			</div>

		</div>


		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Products_Grid_Widget() );
