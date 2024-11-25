<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Gallery Widget.
 *
 * @since 1.0
 */
class Starbelly_Gallery_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-gallery';
	}

	public function get_title() {
		return esc_html__( 'Gallery', 'starbelly-plugin' );
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
				'raw' => esc_html__( 'Filters show only with pagination "Infinite Scrolling" or "No"', 'starbelly-plugin' ),
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
				'options' => $this->get_gallery_categories(),
				'condition' => [
            'source' => 'categories'
        ],
			]
		);

		$this->add_control(
			'limit',
			[
				'label'       => esc_html__( 'Number of Items', 'starbelly-plugin' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => 8,
				'default'     => 8,
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
					'scroll' => __( 'Infinite Scrolling', 'starbelly-plugin' ),
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
			'settings_tab',
			[
				'label' => esc_html__( 'Settings', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

    $this->add_control(
			'show_per_row',
			[
				'label'       => esc_html__( 'Show per Row', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'2'  => __( '2 Items', 'starbelly-plugin' ),
					'3' => __( '3 Items', 'starbelly-plugin' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'filters_styling',
			[
				'label'     => esc_html__( 'Filters', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'filters_color',
			[
				'label'     => esc_html__( 'Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .filter__item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filters_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .filter__item.active a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filters_typography',
				'selector' => '{{WRAPPER}} .filter__item a',
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
			'item_zomm_bgcolor',
			[
				'label'     => esc_html__( 'Item Zoom BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-btn.sb-btn-2.sb-btn-gray .sb-icon' => 'background-color: {{VALUE}}; box-shadow: 0 0 0 2px {{VALUE}};',
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
	protected function get_gallery_categories() {
		$categories = [];

		$args = array(
			'type'			=> 'post',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> 'name',
			'order'			=> 'DESC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'gallery_categories',
			'pad_counts'	=> false
		);

		$gallery_categories = get_categories( $args );

		foreach ( $gallery_categories as $category ) {
			$categories[$category->term_id] = $category->name;
		}

		return $categories;
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

		if ( $settings['source'] == 'all' ) {
			$cat_ids = '';
		} else {
			$cat_ids = $settings['source_categories'];
		}

		$cat_args = array(
			'type'			=> 'gallery',
			'child_of'		=> 0,
			'parent'		=> '',
			'orderby'		=> $settings['categories_orderby'],
			'order'			=> $settings['categories_order'],
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'gallery_categories',
			'pad_counts'	=> false,
			'include'		=> $cat_ids
		);

		$gl_categories = get_categories( $cat_args );

		$args = array(
			'post_type'			=> 'gallery',
			'post_status'		=> 'publish',
			'orderby'			=> $settings['sort'],
			'order'				=> $settings['order'],
			'posts_per_page'	=> $settings['limit'],
			'paged' 			=> $paged
		);

		if( $settings['source'] == 'categories' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'gallery_categories',
					'field'    => 'id',
					'terms'    => $cat_ids
				)
			);

			$args += array('tax_query' => $tax_array);
		}

		$template = 'gallery';

		$q = new \WP_Query( $args );

		?>

    <!-- gallery -->
    <div class="sb-p-90-60">
      <div class="container">
        <?php if ( $settings['filters'] == 'yes' && $gl_categories && $settings['pagination'] == 'no' ) : ?>
				<!-- filter -->
				<div class="sb-filter mb-30">
					<a href="#." data-filter="*" class="sb-filter-link sb-active"><?php echo esc_html__( 'All', 'starbelly-plugin' ); ?></a>
					<?php foreach ( $gl_categories as $category ) : ?>
					<a href="#." data-filter=".category-<?php echo esc_attr( $category->slug ); ?>" class="sb-filter-link">
						<span><?php echo esc_html( $category->name ); ?></span>
						<?php if ( $settings['categories_count'] == 'yes' ) : ?><small><?php echo esc_html( $category->count ); ?></small><?php endif; ?>
					</a>
					<?php endforeach; ?>
				</div>
				<!-- filter end -->
				<?php endif; ?>

        <?php if ( $q->have_posts() ) : ?>
        <div class="sb-masonry-grid js-gallery">
          <div class="sb-grid-sizer"></div>

          <?php while ( $q->have_posts() ) : $q->the_post();
  					set_query_var( 'show_per_row', $settings['show_per_row'] );

  					get_template_part( 'template-parts/content', 'gallery' );
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
  					'temp' => $template,
  					'cat_ids' => $cat_ids,
  					'show_per_row' => $settings['show_per_row'],
  				);

  				wp_enqueue_script( 'starbelly-gallery-infinite-scroll-el', get_template_directory_uri() . '/assets/js/gallery-infinite-scroll-el.js', array( 'jquery' ), '1.0', true );
  				wp_localize_script( 'starbelly-gallery-infinite-scroll-el', 'ajax_gallery_infinite_scroll_data', $infinite_scrolling_data );
  			endif;
  			?>

        <?php else :
          get_template_part( 'template-parts/content', 'none' );
        endif; wp_reset_postdata(); ?>

      </div>
    </div>
    <!-- gallery end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Gallery_Widget() );
