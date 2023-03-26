<?php

class baxel_widget_popular_posts extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_popular_posts', esc_html__( '02. Baxel Widget: Popular Posts', 'baxel' ), array( 'description' => esc_html__( "Display the most popular posts.", 'baxel' ), 'classname' => 'baxel_widget_popular_posts' ) );
		
	}

	function form( $instance ) {
				
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
	
		?>
        		
		<p><?php echo esc_html__( 'Title:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Number of posts to show:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" style="width: 50px;" /></p>                        		                
        <p>
        <input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['day_limit'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'day_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'day_limit' ) ); ?>" /> 
		<label for="<?php echo esc_attr( $this->get_field_id( 'day_limit' ) ); ?>"><?php echo esc_html__( 'Include last 60 days only', 'baxel' ); ?></label>
		</p>
        <p><?php echo esc_html__( 'Popularity Type:', 'baxel' ); ?></p>
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'comment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popularity_base' ) ); ?>" type="radio" value="comment" <?php esc_attr( checked( $instance['popularity_base'], 'comment' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'comment' ) ); ?>"><?php echo esc_html__( 'Comment Based', 'baxel' ); ?></label>
        </p>        
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'view' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popularity_base' ) ); ?>" type="radio" value="view" <?php esc_attr( checked( $instance['popularity_base'], 'view' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'view' ) ); ?>"><?php echo esc_html__( 'View Based', 'baxel' ); ?></label>
        </p>
                		
		<?php
	
	}
		
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'POPULAR POSTS', 'baxel' );
		$instance['count'] = $new_instance['count'] ? strip_tags( $new_instance['count'] ) : 5;
		$instance['day_limit'] = !empty( $new_instance['day_limit'] );
		$instance['popularity_base'] = $new_instance['popularity_base'];
		
		return $instance;
		
	}
	
	function filter_where( $where = '' ) {

		$where .= " AND post_date > '" . date( 'Y-m-d', strtotime( '-' . 60 .' days' ) ) . "'";
		return $where;
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		echo wp_kses_post( $before_widget );
				
		$name = apply_filters( 'widget_title', $instance['name'] );
		$count = $instance['count'];
		$day_limit = $instance['day_limit'];
		$popularity_base = $instance['popularity_base'];
		
		$ppw_rand = rand( 1, 9999999 );
						
		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );
			
		if ( $popularity_base == 'comment' ) {
			
			$loop_args = array(
				
				'posts_per_page' => esc_attr( $count ),
				'orderby' => 'comment_count',
				'ignore_sticky_posts' => 1
					
			);
			
		} else {
			
			$loop_args = array(
				
				'posts_per_page' => esc_attr( $count ),
				'orderby'   => 'meta_value_num',
				'meta_key'  => 'post_views_count',
				'ignore_sticky_posts' => 1
					
			);
			
		}
			
		if ( $day_limit ) { add_filter( 'posts_where', array( $this, 'filter_where' ) ); }
		$widget_query = new WP_Query( $loop_args );
		if ( $day_limit ) { remove_filter( 'posts_where', array( $this, 'filter_where' ) ); }
			
		while( $widget_query->have_posts() ) : $widget_query->the_post();
							
		?>
            
            <a class="posts-widget-wrapper clearfix <?php echo esc_attr( 'ppw-' . $ppw_rand ); ?>" href="<?php echo get_the_permalink(); ?>">
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
		
		$defaults = array( 'name' => esc_html__( 'POPULAR POSTS', 'baxel' ), 'count' => 5, 'day_limit' => 1, 'popularity_base' => 'comment' );		
		return $defaults;
		
	}

}

?>