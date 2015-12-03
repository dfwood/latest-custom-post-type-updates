<?php
// Make sure we aren't being loaded directly!
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * @var array $instance
 * @var TM_LCPTU_Widget $this
 */

$order_values     = array(
	'date'          => __( 'Date', 'latest-custom-post-type-updates' ),
	'none'          => __( 'None', 'latest-custom-post-type-updates' ),
	'author'        => __( 'Author', 'latest-custom-post-type-updates' ),
	'comment_count' => __( 'Comment count', 'latest-custom-post-type-updates' ),
	'ID'            => __( 'Post id', 'latest-custom-post-type-updates' ),
	'menu_order'    => __( 'Menu order', 'latest-custom-post-type-updates' ),
	// TODO: Look at enabling these options in the future, will need a way to specify meta key name.
	// NOTE: Can only have ONE(1) meta key, so meta_value and meta_value_num can't be used together unless on the same key
	/*'meta_value'     => __( 'Meta value', 'latest-custom-post-type-updates' ),
	'meta_value_num' => __( 'Meta value (numeric/integer)', 'latest-custom-post-type-updates' ),*/
	'modified'      => __( 'Modified date', 'latest-custom-post-type-updates' ),
	'name'          => __( 'Name', 'latest-custom-post-type-updates' ),
	'parent'        => __( 'Parent post id', 'latest-custom-post-type-updates' ),
	'type'          => __( 'Post type', 'latest-custom-post-type-updates' ),
	'title'         => __( 'Title', 'latest-custom-post-type-updates' ),
);
$order_directions = array(
	'DESC' => __( 'Descending (c, b, a; newest first)', 'latest-custom-post-type-updates' ),
	'ASC'  => __( 'Ascending (a, b, c; oldest first)', 'latest-custom-post-type-updates' ),
);

?>
<section class="tm_lcptu_widget_section tm_lcptu_general_section">
	<h5><?php _e( 'General Options', 'latest-custom-post-type-updates' ); ?></h5>

	<div class="tm_lcptu_widget_section_inner">
		<p>
			<label for="<?php $this->the_field_id( 'title' ); ?>"><?php
				_e( 'Title:', 'latest-custom-post-type-updates' ); ?></label>
			<input id="<?php $this->the_field_id( 'title' ); ?>"
			       name="<?php $this->the_field_name( 'title' ); ?>"
			       type="text" class="widefat"
			       value="<?php echo $instance['title']; ?>"/>
		</p>

		<p>
			<label for="<?php $this->the_field_id( 'number' ); ?>"><?php
				_e( 'Number of posts to show:', 'latest-custom-post-type-updates' ); ?></label>
			<input id="<?php $this->the_field_id( 'number' ); ?>"
			       name="<?php $this->the_field_name( 'number' ); ?>"
			       type="text"
			       value="<?php echo $instance['number']; ?>"
			       size="3"/>
		</p>

		<p>
			<label><?php _e( 'Post types to show:', 'latest-custom-post-type-updates' ); ?></label><br/>
			<?php
			$post_types = get_post_types( array( 'public' => true, ), 'objects' );
			if ( ! empty( $post_types ) ) {
				$name    = esc_attr( $this->get_field_name( 'post_type' ) . '[]' );
				$id_base = $this->get_field_id( 'post_type' );
				foreach ( $post_types as $post_type ) {
					$value    = esc_attr( $post_type->name );
					$field_id = esc_attr( $id_base . $post_type->name );
					$label    = esc_html( $post_type->labels->name );
					$checked  = in_array( $post_type->name, (array) $instance['post_type'] ) ? ' checked="checked"' : '';
					echo "<input type='checkbox' name='{$name}' id='{$field_id}' value='{$value}'{$checked}/>";
					echo "<label for='{$field_id}'>{$label}</label><br/>";
				}
			}
			?>
		</p>
	</div>
</section>

<section class="tm_lcptu_widget_section tm_lcptu_sort_section">
	<h5><?php _e( 'Sort Options', 'latest-custom-post-type-updates' ); ?></h5>

	<div class="tm_lcptu_widget_section_inner">
		<div class="tm_lcptu_advanced_sorting_wrap">
			<?php
			if ( empty( $instance['orderby'] ) || ! is_array( $instance['orderby'] ) ) {
				$instance['orderby'] = array( 'date' => 'DESC', );
			}
			$x = 0;
			foreach ( $instance['orderby'] as $order => $dir ) {
				$orderby_id = esc_attr( $this->get_field_id( 'orderby' ) . $x );
				$order_id   = esc_attr( $this->get_field_id( 'order' ) . $x );
				?>
				<p class="tm_lcptu_advanced_sort_field">
					<label for="<?php echo $orderby_id; ?>"><?php
						_e( 'Order by:', 'latest-custom-post-type-updates' ); ?></label><br/>
					<select id="<?php echo $orderby_id; ?>"
					        name="<?php $this->the_field_name( 'orderby' ); ?>[]"
					        class="tm_lcptu_field_orderby">
						<?php
						foreach ( $order_values as $key => $label ) {
							$value    = esc_attr( $key );
							$label    = esc_html( $label );
							$selected = ( $order == $key ) ? ' selected="selected"' : '';
							echo "<option value='{$value}'{$selected}>{$label}</option>";
						}
						?>
					</select><br/>
					<label for="<?php echo $order_id; ?>"><?php
						_e( 'Order:', 'latest-custom-post-type-updates' ); ?></label>
					<select id="<?php echo $order_id; ?>"
					        name="<?php $this->the_field_name( 'order' ); ?>[]"
					        class="tm_lcptu_field_order">
						<?php
						foreach ( $order_directions as $key => $label ) {
							$value    = esc_attr( $key );
							$label    = esc_html( $label );
							$selected = ( $dir == $key ) ? ' selected="selected"' : '';
							echo "<option value='{$value}'{$selected}>{$label}</option>";
						}
						?>
					</select>
				</p>
				<?php
				$x ++;
			}
			?>
		</div>
	</div>
</section>

<section class="tm_lcptu_widget_section tm_lcptu_date_section">
	<h5><?php _e( 'Date Display Options', 'latest-custom-post-type-updates' ); ?></h5>

	<div class="tm_lcptu_widget_section_inner">
		<p>
			<input type="checkbox" class="tm_lcptu_show_date"
			       id="<?php $this->the_field_id( 'show_date' ); ?>"
			       name="<?php $this->the_field_name( 'show_date' ); ?>"
				<?php echo $instance['show_date'] ? 'checked="checked"' : ''; ?>
				   value="1"/>
			<label for="<?php $this->the_field_id( 'show_date' ); ?>"><?php
				_e( 'Show date', 'latest-custom-post-type-updates' ); ?></label>
		</p>

		<div class="tm_lcptu_extra_options_wrap"<?php echo $instance['show_date'] ? '' : ' style="display: none"'; ?>>
			<p>
				<label for="<?php $this->the_field_id( 'date_to_show' ); ?>"><?php
					_e( 'Date to show:', 'latest-custom-post-type-updates' ); ?></label>
				<select id="<?php $this->the_field_id( 'date_to_show' ); ?>"
				        name="<?php $this->the_field_name( 'date_to_show' ); ?>">
					<?php
					$date_formats = array(
						'publish'  => __( 'Publish date', 'latest-custom-post-type-updates' ),
						'modified' => __( 'Last modified date', 'latest-custom-post-type-updates' ),
					);
					foreach ( $date_formats as $value => $label ) {
						$value    = esc_attr( $value );
						$label    = esc_html( $label );
						$selected = $instance['date_to_show'] == $value ? ' selected="selected"' : '';
						echo "<option value='{$value}'{$selected}>{$label}</option>";
					}
					?>
				</select>
			</p>

			<p>
				<label for="<?php $this->the_field_id( 'date_format' ); ?>"><?php
					_e( 'Date Format:', 'latest-custom-post-type-updates' ); ?></label>
				<select class="tm_lcptu_date_format_selector"
				        id="<?php $this->the_field_id( 'date_format' ); ?>"
				        name="<?php $this->the_field_name( 'date_format' ); ?>">
					<?php
					$date_formats = array(
						'wp'     => _x( 'WordPress Settings', 'date format option', 'latest-custom-post-type-updates' ),
						'diff'   => _x( 'Human diff ("2 days ago")', 'date format option', 'latest-custom-post-type-updates' ),
						'custom' => _x( 'Custom', 'date format option', 'latest-custom-post-type-updates' ),
					);
					foreach ( $date_formats as $value => $label ) {
						$value    = esc_attr( $value );
						$label    = esc_html( $label );
						$selected = $instance['date_format'] == $value ? ' selected="selected"' : '';
						echo "<option value='{$value}'{$selected}>{$label}</option>";
					}
					?>
				</select>
			</p>

			<p class="tm_lcptu_date_wp_format tm_lcptu_extra_options_wrap"<?php echo 'wp' == $instance['date_format']
				? '' : ' style="display: none"'; ?>>
				<input type="checkbox"
				       id="<?php $this->the_field_id( 'show_time' ); ?>"
				       name="<?php $this->the_field_name( 'show_time' ); ?>"
					<?php echo $instance['show_date'] ? 'checked="checked"' : ''; ?>
					   value="1"/>
				<label for="<?php $this->the_field_id( 'show_time' ); ?>"><?php
					_e( 'Show time', 'latest-custom-post-type-updates' ); ?></label>
			</p>

			<p class="tm_lcptu_date_custom_format tm_lcptu_extra_options_wrap"<?php echo 'custom' == $instance['date_format']
				? '' : ' style="display: none"'; ?>>
				<label for="<?php $this->the_field_id( 'custom_date_format' ); ?>"><?php
					_e( 'Custom date format:', 'latest-custom-post-type-updates' ); ?></label>
				<input type="text" class="widefat"
				       id="<?php $this->the_field_id( 'custom_date_format' ); ?>"
				       name="<?php $this->the_field_name( 'custom_date_format' ); ?>"
				       value="<?php echo esc_attr( $instance['custom_date_format'] ); ?>"/><br/>
			<span class="description"><?php printf(
					__( 'See this <a href="%1$s" target="_blank">WordPress.org</a> article for more information on this', 'latest-custom-post-type-updates' ),
					esc_url( 'https://codex.wordpress.org/Formatting_Date_and_Time' )
				); ?></span>
			</p>
		</div>
	</div>
</section>