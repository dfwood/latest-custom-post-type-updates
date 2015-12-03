<?php
// Make sure we aren't being loaded directly!
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class TM_LCPTU_Widget
 * @since 2.0.0
 */
class TM_LCPTU_Widget extends WP_Widget {

	protected $widget_cache = 'tm_lcptu_widget';

	/**
	 * TM_LCPTU_Widget constructor. Sets up our widget.
	 * @since 2.0.0
	 */
	public function __construct() {
		$id_base        = false;
		$name           = _x( 'Latest Custom Post Type Updates', 'widget name', 'latest-custom-post-type-updates' );
		$widget_options = array(
			'description' => _x( 'Displays the most recent posts from builtin and custom post types.', 'widget description', 'latest-custom-post-type-updates' ),
		);

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

		parent::__construct( $id_base, $name, $widget_options );
	}

	/**
	 * Outputs our widgets html markup
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @since 2.0.0
	 */
	public function widget( $args, $instance ) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( $this->widget_cache, 'widget' );
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];

			return;
		}

		$sidebar_id = $args['id'];

		// Setup our query args
		$query_args = array(
			'post_type'           => $instance['post_type'],
			'posts_per_page'      => $instance['number'],
			'orderby'             => $instance['orderby'],
			'ignore_sticky_posts' => true,
		);
		// Run our query
		$recent_posts = new WP_Query( $query_args );

		// Start our output
		ob_start();
		echo isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		if ( ! empty( $instance['title'] ) ) {
			echo isset( $args['before_title'] ) ? $args['before_title'] : '';
			echo $instance['title'];
			echo isset( $args['after_title'] ) ? $args['after_title'] : '';
		}

		if ( $recent_posts->have_posts() ) {
			if ( $instance['show_date'] ) {
				if ( 'diff' == $instance['date_format'] ) {
					$format = false;
				} elseif ( 'wp' == $instance['date_format'] ) {
					$format = get_option( 'date_format' );
					if ( $instance['show_time'] ) {
						$format .= ' ' . get_option( 'time_format' );
					}
				} else {
					$format = $instance['custom_date_format'];
				}
			}

			/**
			 * Filter the tag used to wrap all the latest posts in
			 *
			 * @since 2.0.0
			 *
			 * @param string $tag The html tag to be used (e.g. 'ul')
			 * @param string $sidebar_id The ID of the sidebar the widget will be displayed in
			 */
			$wrap_tag = esc_html( apply_filters( 'lcptu_wrapper_tag', 'ul', $sidebar_id ) );
			/**
			 * Filter the tag used to wrap each single post item in
			 *
			 * @since 2.0.0
			 *
			 * @param string $tag The html tag to be used (e.g. 'li')
			 * @param string $sidebar_id The ID of the sidebar the widget will be displayed in
			 */
			$single_tag = esc_html( apply_filters( 'lcptu_single_wrapper_tag', 'li', $sidebar_id ) );
			echo "<{$wrap_tag}>";
			while ( $recent_posts->have_posts() ) {
				$recent_posts->the_post();
				$permalink = get_the_permalink();
				$title     = get_the_title();
				$content   = "<a href='{$permalink}' class='lcptu-link'>{$title}</a>";
				if ( $instance['show_date'] && isset( $format ) ) {
					// Add our date
					if ( false !== $format ) {
						if ( 'modified' == $instance['date_to_show'] ) {
							$date = get_the_modified_time( $format );
						} else {
							$date = get_the_time( $format );
						}
					} else {
						if ( 'modified' == $instance['date_to_show'] ) {
							$date = human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) );
						} else {
							$date = human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );
						}
					}
					$date = esc_html( $date );
					$content .= " <span class='lcptu-item-date'>{$date}</span>";
				}
				/**
				 * Filter the content HTML for individual posts. The post object is setup and you are in the loop.
				 *
				 * @since 2.0.0
				 *
				 * @param string $content The HTML markup to display, does not include wrapper tags
				 * @param string $sidebar_id The ID of the sidebar the widget will be displayed in
				 * @param WP_Query $recent_posts WP_Query object containing the query
				 */
				$content = apply_filters( 'lcptu_single_content_html', $content, $sidebar_id, $recent_posts );
				/**
				 * Filter the CSS classes for the wrapper tag for each post item. The post object is setup and you are in the loop.
				 *
				 * @since 2.0.0
				 *
				 * @param array $classes The CSS classes to be applied to the wrapper tag
				 * @param string $sidebar_id The ID of the sidebar the widget will be displayed in
				 */
				$item_classes    = apply_filters( 'lcptu_single_wrapper_classes', array( 'tm-lcptu-single' ), $sidebar_id );
				$wrapper_classes = esc_attr( implode( ' ', $item_classes ) );
				echo "<{$single_tag} class='{$wrapper_classes}'>{$content}</{$single_tag}>";
			}
			echo "</{$wrap_tag}>";
			wp_reset_postdata();
		}

		// Finish our output!
		echo isset( $args['after_widget'] ) ? $args['after_widget'] : '';

		// Save our cache if not a preview, flush ob to screen otherwise.
		// Also make sure if we have a human time diff being show we don't cache it, that changes too often for new posts!
		if ( ! $this->is_preview() || ! ( $instance['show_date'] && 'diff' == $instance['date_format'] ) ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( $this->widget_cache, $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	/**
	 * Sanitizes and saves our widget options
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 * @since 2.0.0
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		// General options
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['post_type'] = array_unique( array_filter( $new_instance['post_type'] ) );

		// Sort Options
		if ( empty( $new_instance['orderby'] ) || ! is_array( $new_instance['orderby'] ) ) {
			$instance['orderby'] = array( 'date' => 'DESC', );
		} else {
			$instance['orderby'] = array();
			$order_values        = array(
				'date',
				'none',
				'author',
				'comment_count',
				'ID',
				'menu_order',
				'meta_value',
				'meta_value_num',
				'modified',
				'name',
				'parent',
				'type',
				'title',
			);
			foreach ( $new_instance['orderby'] as $key => $orderby ) {
				if ( ! in_array( $orderby, $order_values ) ) {
					continue;
				}
				$instance['orderby'][ $orderby ] = in_array( $new_instance['order'][ $key ], array( 'ASC', 'DESC' ) ) ?
					$new_instance['order'][ $key ] : 'DESC';
			}
		}

		// Date Options
		$instance['show_date']          = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['date_to_show']       = in_array( $new_instance['date_to_show'], array( 'publish', 'modified' ) )
			? $new_instance['date_to_show'] : 'publish';
		$instance['date_format']        = in_array( $new_instance['date_format'], array( 'wp', 'diff', 'custom' ) )
			? $new_instance['date_format'] : 'wp';
		$instance['show_time']          = isset( $new_instance['show_time'] ) ? (bool) $new_instance['show_time'] : false;
		$instance['custom_date_format'] = strip_tags( $new_instance['custom_date_format'] );

		// Make sure the cache is clean, we want our new settings to be able to take effect
		$this->flush_widget_cache();

		return $instance;
	}

	/**
	 * Options for our widget
	 *
	 * @param array $instance
	 *
	 * @return string
	 * @since 2.0.0
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				// General Options
				'title'              => __( 'Latest Updates', 'latest-custom-post-type-updates' ),
				'number'             => 5,
				'post_type'          => array( 'post' ),

				// Sort Options
				'orderby'            => array(
					'date' => 'DESC',
				),
				//'meta_key' => '', // Needed and used only for `meta_value` and `meta_value_num` sorting options!

				// Date Options
				'show_date'          => false,
				'date_to_show'       => 'publish', // `publish` or `modified`
				'date_format'        => 'wp', // `wp`, `diff` (human readable), or `custom`
				'show_time'          => false, // Only shows for `wp` date format
				'custom_date_format' => get_option( 'date_format' ), // Only shows for `custom` date format

				// TODO: Consider adding taxonomy queries
				// Taxonomy Options
				/*'tax_relation'       => 'AND',
				'taxonomies'         => array(),
				'terms'              => '',*/

				// TODO: Consider adding meta query options
			)
		);

		include( __DIR__ . '/tm-lcptu-widget-options.php' );
	}

	/**
	 * Flushes our cached widgets
	 * @since 2.0.0
	 */
	public function flush_widget_cache() {
		wp_cache_delete( $this->widget_cache, 'widget' );
	}

	public function the_field_name( $field_name ) {
		echo esc_attr( $this->get_field_name( $field_name ) );
	}

	public function the_field_id( $field_name ) {
		echo esc_attr( $this->get_field_id( $field_name ) );
	}

}