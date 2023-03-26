<?php

class baxel_widget_selected_posts extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_selected_posts', esc_html__( '04. Baxel Widget: Selected Posts', 'baxel' ), array( 'description' => esc_html__( "Display the posts you've selected.", 'baxel' ), 'classname' => 'baxel_widget_selected_posts' ) );
		
	}
	
	function form( $instance ) {
				
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		global $post;
		$posts = get_posts( array( 'numberposts' => -1 ) );
		$first_selector = esc_html__( '- Select a Post -', 'baxel' );
		
		?>
        
        <p><?php echo esc_html__( 'Title:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        
        <?php
		
		for ( $x = 0; $x < 5; $x++ ) {
			
			echo '<p>' . esc_html__( 'Post', 'baxel' ) . ' ' . ( $x + 1 ) . ':';
			echo '<select class="widefat" id="' . esc_attr( $this->get_field_name( 'post_id_' . $x ) ) . '"  name="' . esc_attr( $this->get_field_name( 'post_id_' . $x ) ) . '">';
			echo '<option ';
			echo esc_attr( $instance['post_id_' . $x ] ) == 0 ? 'selected="selected"' : '';
			echo ' value="0">' . $first_selector . '</option>';
			foreach( $posts as $post ) : setup_postdata( $post );
				echo '<option ';
				if ( $post->ID == esc_attr( $instance['post_id_' . $x ] ) ) { echo 'selected="selected"'; }
				echo ' value="' . $post->ID . '">' . get_the_title() . '</option>';
			endforeach;
			echo '</select></p>';
			
		}
	
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'SELECTED POSTS', 'baxel' );
		$instance['post_id_0'] = $new_instance['post_id_0'];
		$instance['post_id_1'] = $new_instance['post_id_1'];
		$instance['post_id_2'] = $new_instance['post_id_2'];
		$instance['post_id_3'] = $new_instance['post_id_3'];
		$instance['post_id_4'] = $new_instance['post_id_4'];
		
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		echo wp_kses_post( $before_widget );
				
		$name = apply_filters( 'widget_title', $instance['name'] );
		$post_id_0 = $instance['post_id_0'];
		$post_id_1 = $instance['post_id_1'];
		$post_id_2 = $instance['post_id_2'];
		$post_id_3 = $instance['post_id_3'];
		$post_id_4 = $instance['post_id_4'];
				
		$spw_rand = rand( 1, 9999999 );
								
		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );
						
		$loop_args = array(
				
			'post_type' => 'post',
			'post__in' => array( $post_id_0, $post_id_1, $post_id_2, $post_id_3, $post_id_4 ),
			'ignore_sticky_posts' => 1,
			'orderby' => 'post__in'
					
		);

		$widget_query = new WP_Query( $loop_args );

		while ( $widget_query->have_posts() ) : $widget_query->the_post();
						
		?>
				
			<a class="posts-widget-wrapper clearfix <?php echo esc_attr( 'spw-' . $spw_rand ); ?>" href="<?php echo get_the_permalink(); ?>">
				<?php echo the_post_thumbnail( 'baxel-small-thumbnail-image' ); ?>    
				<div class="posts-widget-container <?php if ( has_post_thumbnail() ) { echo 'posts-widget-container-with-t'; } ?>">
					<div class="table-cell-middle"><?php if ( get_theme_mod( 'baxel_show_widget_date', 0 ) ) { ?><div class="posts-widget-date"><?php echo get_the_date(); ?></div><?php } ?><div class="posts-widget-title"><?php echo get_the_title(); ?></div></div>
				</div>
			</a>
			
		<?php endwhile;
			
		wp_reset_postdata();
								
		echo wp_kses_post( $after_widget );
	
	}
	
	function defaults() {
		
		$defaults = array( 'name' => esc_html__( 'SELECTED POSTS', 'baxel' ), 'post_id_0' => 0, 'post_id_1' => 0, 'post_id_2' => 0, 'post_id_3' => 0, 'post_id_4' => 0 );		
		return $defaults;
		
	}

}

?>