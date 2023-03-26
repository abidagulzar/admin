<?php

class baxel_widget_recent_comments extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_recent_comments', esc_html__( '07. Baxel Widget: Recent Comments', 'baxel' ), array( 'description' => esc_html__( "Display the latest comments.", 'baxel' ), 'classname' => 'baxel_widget_recent_comments' ) );
		
	}
	
	function form( $instance ) {
	
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		?>
		
		<p><?php echo esc_html__( 'Title:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Number of comments to show:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" style="width: 50px;" /></p>        
        <p>
        <input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['avatar'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" /> 
		<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php echo esc_html__( 'Display avatars', 'baxel' ); ?></label>
		</p>
        		
		<?php
	
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'RECENT COMMENTS', 'baxel' );
		$instance['count'] = $new_instance['count'] ? strip_tags( $new_instance['count'] ) : 5;
		$instance['avatar'] = !empty( $new_instance['avatar'] );
		
		return $instance;	
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		echo wp_kses_post( $before_widget );
		
		$name = apply_filters( 'widget_title', $instance['name'] );
		$count = $instance['count'];
		$avatar = $instance['avatar'];
						
		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );
		
		$rcw_rand = rand( 1, 9999999 );				
		$avatar_size = 40;			
		$approvedCounter = 0;
			
		$comments_query = new WP_Comment_Query();
		$comments = $comments_query->query( array( 'number' => 50 ) );
			
		if ( $comments ) {
				
			foreach( $comments as $comment ) {
			
				if ( $comment->comment_approved && $approvedCounter < $count && !post_password_required( $comment->comment_post_ID ) ) {
						
					$approvedCounter ++;
								
					$link = get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID;
					
					?>
                        
                    <a class="posts-widget-wrapper clearfix <?php echo esc_attr( 'rcw-' . $rcw_rand ); ?>" href="<?php echo esc_url ( $link ); ?>">
                        <?php if ( $avatar && get_option( 'show_avatars' ) ) { ?><?php echo get_avatar( $comment->comment_author_email, $avatar_size ); ?><?php } ?>    
                        <div class="posts-widget-container <?php if ( $avatar && get_option( 'show_avatars' ) ) { echo 'posts-widget-container-with-t'; } ?>">
                            <div class="table-cell-middle"><div class="posts-widget-date"><?php echo get_comment_author( $comment->comment_ID ); ?></div><div class="posts-widget-title"><?php echo get_the_title( $comment->comment_post_ID ); ?></div></div>
                        </div>
                    </a>
                        					
				<?php }
				
			}
				
		}
		
		echo wp_kses_post( $after_widget );
	
	}
	
	function defaults() {
		
		$defaults = array( 'name' => esc_html__( 'RECENT COMMENTS', 'baxel' ), 'count' => 5, 'avatar' => 1 );		
		return $defaults;
		
	}

}

?>