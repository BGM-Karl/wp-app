<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Blog Grid Widget.
 *
 * @since 1.0
 */
class Starbelly_Blog_Grid_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-blog-grid';
	}

	public function get_title() {
		return esc_html__( 'Blog (Grid)', 'starbelly-plugin' );
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
			'heading_tab',
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
				'default' => 'h3',
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

    $this->add_responsive_control(
			'heading_align',
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
					'{{WRAPPER}} .sb-blog-list .sb-heading-el' => 'text-align: {{VALUE}};',
				],
				'default'	=> 'left',
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
				'label'       => esc_html__( 'Source', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_blog_categories(),
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
				'options' => $this->get_blog_tags(),
				'condition' => [
            'source' => 'tags'
        ],
			]
		);

		$this->add_control(
			'source_custom',
			[
				'label'       => esc_html__( 'Custom Posts', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_blog_custom(),
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

    $this->add_control('attr_details', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Details', 'starbelly-plugin'),
        'description' => __('Whether to display details of the post type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

    $this->add_control('attr_date', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Date', 'starbelly-plugin'),
        'description' => __('Whether to display date of the post type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

    $this->add_control('attr_author', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Author', 'starbelly-plugin'),
        'description' => __('Whether to display author of the post type.', 'starbelly-plugin'),
        'default'     => 'true',
        'options'     => array(
            'true'          => __('Yes', 'starbelly-plugin'),
            'false'         => __('No', 'starbelly-plugin')
        )
    ));

		$this->add_control('attr_readmore', array(
        'type'        => Controls_Manager::SELECT,
        'label'       => __('Readmore', 'starbelly-plugin'),
        'description' => __('Whether to display readmore button of the post type.', 'starbelly-plugin'),
        'default'     => 'false',
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
				'default' => 'pages',
				'options' => [
					'pages' => __( 'Pages', 'starbelly-plugin' ),
					'button' => __( 'Button', 'starbelly-plugin' ),
          'scroll' => __( 'Infinite Scrolling', 'starbelly-plugin' ),
					'no' => __( 'No', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'button',
			[
				'label'       => esc_html__( 'Button', 'starbelly-plugin' ),
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
				'label'       => esc_html__( 'Link', 'starbelly-plugin' ),
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
				'default' => '3',
				'options' => [
					'1'  => __( '1', 'starbelly-plugin' ),
					'2'  => __( '2', 'starbelly-plugin' ),
					'3' => __( '3', 'starbelly-plugin' ),
				],
			]
		);

    $this->add_control(
			'masonry',
			[
				'label' => esc_html__( 'Masonry', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'sidebar',
			[
				'label' => esc_html__( 'Sidebar', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
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
					'{{WRAPPER}} .sb-blog-list .sb-title-el' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-blog-list .sb-title-el',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-blog-list .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-blog-list .sb-text',
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
			'item_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-blog-card h3 a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-blog-card h3',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-blog-card .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-blog-card .sb-text',
			]
		);

		$this->add_control(
			'item_date_color',
			[
				'label'     => esc_html__( 'Date Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-blog-card .sb-suptitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_date_bgcolor',
			[
				'label'     => esc_html__( 'Date BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-blog-card .sb-suptitle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_date_typography',
				'label'     => esc_html__( 'Date Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-blog-card .sb-suptitle',
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
			'pagination_color',
			[
				'label'     => esc_html__( 'Pagination Links Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-pagination a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_typography',
				'label'     => esc_html__( 'Pagination Links Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-pagination',
			]
		);

		$this->add_control(
			'more_button_color',
			[
				'label'     => esc_html__( 'More Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'more_button_bgcolor',
			[
				'label'     => esc_html__( 'More Button BG Color', 'starbelly-plugin' ),
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
				'name'     => 'more_button_typography',
				'label'     => esc_html__( 'More Button Typography', 'starbelly-plugin' ),
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
	protected function get_blog_categories() {
		$categories = [];

		$args = array(
			'type'			=> 'post',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'DESC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'category',
			'pad_counts'	=> false
		);

		$blog_categories = get_categories( $args );

		foreach ( $blog_categories as $category ) {
			$categories[$category->term_id] = $category->name;
		}

		return $categories;
	}

	protected function get_blog_tags() {
		$tags = [];

		$args = array(
			'type'			=> 'post',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'DESC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'post_tag',
			'pad_counts'	=> false
		);

		$post_tags = get_categories( $args );

		foreach ( $post_tags as $tag ) {
			$tags[$tag->term_id] = $tag->name;
		}

		return $tags;
	}

	protected function get_blog_custom() {
		$items = [];

		$args = array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1
		);

		$post_items = new \WP_Query( $args );

		while ( $post_items->have_posts() ) : $post_items->the_post();
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
		$this->add_inline_editing_attributes( 'description', 'advanced' );

		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$page_id = get_the_ID();

		if ( $settings['source'] == 'categories' ) {
			$ids = $settings['source_categories'];
			$cat_ids = $ids;
		} elseif ( $settings['source'] == 'tags' ) {
			$ids = $settings['source_tags'];
		} elseif ( $settings['source'] == 'custom' ) {
			$ids = $settings['source_custom'];
		} else {
			$ids = '';
			$cat_ids = '';
		}

		$args = array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'orderby'			=> $settings['sort'],
			'order'				=> $settings['order'],
			'posts_per_page'	=> $settings['limit'],
			'paged' 			=> $paged
		);

		if ( $settings['source'] == 'categories' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'category',
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
    if ( $settings['attr_details'] == 'false' ) {
      $attr_classes .= ' attr-details-false';
    }
		if ( $settings['attr_date'] == 'false' ) {
      $attr_classes .= ' attr-date-false';
    }
		if ( $settings['attr_author'] == 'false' ) {
      $attr_classes .= ' attr-author-false';
    }
		if ( $settings['attr_readmore'] == 'false' ) {
      $attr_classes .= ' attr-readmore-false';
    }

		$q = new \WP_Query( $args );

    ?>

    <!-- blog list -->
    <section class="sb-blog-list sb-p-90-90">
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

        <?php if ( $settings['sidebar'] == 'yes' ) : ?>
        <div class="row js-blog">
        <div class="col-lg-8">
        <?php endif; ?>

        <?php if ( $settings['title'] || $settings['description'] ) : ?>
        <div class="sb-heading-el sb-mb-60">
          <?php if ( $settings['title'] ) : ?>
          <h2 class="<?php if ( $settings['items_per_row'] == '3' || $settings['sidebar'] == 'yes' ) : ?>sb-cate-title <?php endif; ?>sb-mb-15">
            <span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
              <?php echo wp_kses_post( $settings['title'] ); ?>
            </span>
          </h2>
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

        <?php if ( $q->have_posts() ) : ?>
        <?php if ( $settings['masonry'] == 'yes' ) : ?>
        <div class="sb-masonry-grid js-blog">
          <div class="sb-grid-sizer"></div>
        <?php else : ?>
        <div class="row">
        <?php endif; ?>

          <?php while ( $q->have_posts() ) : $q->the_post();
            set_query_var( 'items_per_row', $settings['items_per_row'] );
            set_query_var( 'masonry', $settings['masonry'] );
            set_query_var( 'sidebar', $settings['sidebar'] );

            get_template_part( 'template-parts/content' );
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
            'prev_text' => esc_html__( 'Prev', 'starbelly-plugin' ),
            'next_text' => esc_html__( 'Next', 'starbelly-plugin' ),
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

        <?php if ( $settings['sidebar'] == 'yes' ) : ?>
        </div>
        <div class="col-lg-4">
          <?php if ( is_active_sidebar( 'sidebar-1' ) ) : get_sidebar(); endif; ?>
        </div>
        </div>
        <?php endif; ?>

        <?php
  			if ( $settings['pagination'] == 'scroll' ) :
  				$infinite_scrolling_data = array(
  					'url'   => admin_url( 'admin-ajax.php' ),
  					'max_num' => $q->max_num_pages,
  					'page_id' => $page_id,
  					'order_by' => $settings['sort'],
  					'order' => $settings['order'],
  					'per_page' => $settings['limit'],
  					'source' => $settings['source'],
  					'cat_ids' => $cat_ids,
  					'items_per_row' => $settings['items_per_row'],
            'masonry' => $settings['masonry'],
            'sidebar' => $settings['masonry'],
  				);

  				wp_enqueue_script( 'starbelly-blog-infinite-scroll-el', get_template_directory_uri() . '/assets/js/blog-infinite-scroll-el.js', array( 'jquery' ), '1.0', true );
  				wp_localize_script( 'starbelly-blog-infinite-scroll-el', 'ajax_blog_infinite_scroll_data', $infinite_scrolling_data );
  			endif;
  			?>

        <?php else : ?>
          <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; wp_reset_postdata(); ?>
      </div>
    </section>
    <!-- blog list end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Blog_Grid_Widget() );
