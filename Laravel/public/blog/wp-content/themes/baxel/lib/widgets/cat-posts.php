<?php

class baxel_widget_category_posts extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_category_posts', esc_html__( '03. Baxel Widget: Category/Tag Posts', 'baxel' ), array( 'description' => esc_html__( "Display the posts belong to a specific category or tag.", 'baxel' ), 'classname' => 'baxel_widget_category_posts' ) );
		
	}
	
	function form( $instance ) {
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
	        		
		?>
        
        <p><?php echo esc_html__( 'Title:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Number of posts to show:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" style="width: 50px;" /></p>
        <p><?php echo esc_html__( 'Taxonomy:', 'baxel' ); ?></p>        
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_type' ) ); ?>" type="radio" value="cat" <?php esc_attr( checked( $instance['list_type'], 'cat' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php echo esc_html__( 'Category Posts', 'baxel' ); ?></label>
        </p>        
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_type' ) ); ?>" type="radio" value="tag" <?php esc_attr( checked( $instance['list_type'], 'tag' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php echo esc_html__( 'Tag Posts', 'baxel' ); ?></label>
        </p>
        <hr />
        <p><strong><?php echo esc_html__( 'Categories', 'baxel' ); ?></strong></p>
        <p>
        <?php		
		$cat_args = array(
			'show_option_none' => esc_html__( '- Select a Category -', 'baxel' ),
			'show_count' => 1,
			'hide_empty' => 0,
			'id' => esc_attr( $this->get_field_name( 'category' ) ),
			'name' => esc_attr( $this->get_field_name( 'category' ) ),
			'selected' => esc_attr( $instance['category'] ),
			'class' => 'postform widefat',
		);				
		wp_dropdown_categories( $cat_args );
		?>
		</p> 
        <p><em><?php echo esc_html__( 'Only used if "Category Posts" is selected.', 'baxel' ); ?></em></p>
        <p><?php echo esc_html__( 'Excluded Categories:', 'baxel' ); ?><br />
        <input name="<?php echo esc_attr( $this->get_field_name( 'exclude_cats' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['exclude_cats'] ); ?>" /></p>
        <p><em><?php echo esc_html__( 'Useful when a post has more than one category.', 'baxel' ); ?><br />
        <?php echo esc_html__( 'Write category IDs you want to hide. Use comma (,) between them. Example: 2,5,8', 'baxel' ); ?></em></p>
        <hr /> 
        <p><strong><?php echo esc_html__( 'Tags', 'baxel' ); ?></strong></p>
        <p>
        <?php		
		$tag_args = array(
			'show_option_none' => esc_html__( '- Select a Tag -', 'baxel' ),
			'show_count' => 1,
			'hide_empty' => 0,
			'id' => esc_attr( $this->get_field_name( 'tag' ) ),
			'name' => esc_attr( $this->get_field_name( 'tag' ) ),
			'selected' => esc_attr( $instance['tag'] ),
			'class' => 'postform widefat',
			'taxonomy' => 'post_tag',
		);				
		wp_dropdown_categories( $tag_args );
		?>
		</p>
        <p><em><?php echo esc_html__( 'Only used if "Tag Posts" is selected.', 'baxel' ); ?></em></p>
        <p><?php echo esc_html__( 'Excluded Tags:', 'baxel' ); ?><br />
        <input name="<?php echo esc_attr( $this->get_field_name( 'exclude_tags' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['exclude_tags'] ); ?>" /></p>
        <p><em><?php echo esc_html__( 'Useful when a post has more than one tag.', 'baxel' ); ?><br />
        <?php echo esc_html__( 'Write tag IDs you want to hide.', 'baxel' ); ?></em></p>
        <hr />
        <p><?php echo esc_html__( 'Excluded Posts:', 'baxel' ); ?><br />
        <input name="<?php echo esc_attr( $this->get_field_name( 'exclude_posts' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['exclude_posts'] ); ?>" /></p>
        <p><em><?php echo esc_html__( 'Write post IDs you want to hide.', 'baxel' ); ?></em></p>
		
		<?php
	
	}
		
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'CATEGORY POSTS', 'baxel' );
		$instance['count'] = $new_instance['count'] ? strip_tags( $new_instance['count'] ) : 5;
		$instance['category'] = $new_instance['category'];
		$instance['tag'] = $new_instance['tag'];
		$instance['list_type'] = $new_instance['list_type'];
		$instance['exclude_cats'] = $new_instance['exclude_cats'];
		$instance['exclude_tags'] = $new_instance['exclude_tags'];
		$instance['exclude_posts'] = $new_instance['exclude_posts'];
		
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		echo wp_kses_post( $before_widget );
				
		$name = apply_filters( 'widget_title', $instance['name'] );
		$count = $instance['count'];
		$category = $instance['category'];
		$tag = $instance['tag'];
		$list_type = $instance['list_type'];
		$exclude_cats = $instance['exclude_cats'];
		$exclude_tags = $instance['exclude_tags'];
		$exclude_posts = $instance['exclude_posts'];
						
		$cpw_rand = rand( 1, 9999999 );
		
		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );
		
		$posts_to_exclude = explode( ',', esc_attr( $exclude_posts ) );
			
		if ( $list_type == 'cat' ) {
			
			$cats_to_exclude = explode( ',', esc_attr( $exclude_cats ) );
						
			$loop_args = array(
				
				'showposts' => esc_attr( $count ),
				'cat' => $category,
				'ignore_sticky_posts' => 1,
				'category__not_in' => $cats_to_exclude,
				'post__not_in' => $posts_to_exclude
					
			);
			
		} else {
			
			$tags_to_exclude = explode( ',', esc_attr( $exclude_tags ) );
				
			$loop_args = array(
				
				'showposts' => esc_attr( $count ),
				'tag_id' => $tag,
				'ignore_sticky_posts' => 1,
				'tag__not_in' => $tags_to_exclude,
				'post__not_in' => $posts_to_exclude
					
			);
				
		}
			
		$widget_query = new WP_Query( $loop_args );

		while ( $widget_query->have_posts() ) : $widget_query->the_post();
							
		?>
				
			<a class="posts-widget-wrapper clearfix <?php echo esc_attr( 'cpw-' . $cpw_rand ); ?>" href="<?php echo get_the_permalink(); ?>">
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
		
		$defaults = array( 'name' => esc_html__( 'CATEGORY POSTS', 'baxel' ), 'count' => 5, 'category' => -1, 'tag' => -1, 'list_type' => 'cat', 'exclude_cats' => '', 'exclude_tags' => '', 'exclude_posts' => '' );		
		return $defaults;
		
	}

}

?>