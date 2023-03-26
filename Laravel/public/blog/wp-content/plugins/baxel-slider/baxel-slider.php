<?php
/*
Plugin Name: Baxel Slider
Plugin URI: http://www.burnhambox.com/baxel
Description: Baxel Slider
Version: 1.0
Author: Burnhambox
Author URI: http://www.burnhambox.com
License: GNU
*/

/* Slider Post Type */
function baxel_create_slider_post_type() {
	
	$labels = array(
		'all_items' => 'All Slides',	
		'edit_item' => 'Edit Slide',
		'add_new' => 'Add New Slide',
		'add_new_item' => 'Add New Slide',
		'not_found' => 'No slides found.',
		'not_found_in_trash' => 'No slides found in Trash.',
	);
	
	$args = array(
		'labels' => $labels,
		'public' => false,
		'show_ui' => true,
		'menu_icon' => 'dashicons-images-alt',
		'capability_type' => 'post',
		'rewrite' => array( 'slide_group', 'post_tag' ),
		'label'  => 'Baxel Slider',
		'supports' => array( 'thumbnail' ),
	);
	
	register_post_type( 'slider', $args );
	
}
add_action( 'init', 'baxel_create_slider_post_type' );
/* */

/* Add Meta Box */
function baxel_slider_add_meta_box() {
	
	add_meta_box( 'baxel-slide-meta-box', 'Slide Properties', 'baxel_slide_meta_box_markup', 'slider', 'normal', 'high' );
	
}
add_action( 'add_meta_boxes', 'baxel_slider_add_meta_box' );

function baxel_slide_meta_box_markup( $post ) {
	
	wp_nonce_field( basename( __FILE__ ), 'baxel-slider-meta-box-nonce' );
	
	$baxel_slide_title = get_post_meta( $post->ID, 'baxel-slide-title', true );
	$baxel_slide_teaser = get_post_meta( $post->ID, 'baxel-slide-teaser', true );
	$baxel_slide_url = get_post_meta( $post->ID, 'baxel-slide-url', true );
	$baxel_slide_new_window = get_post_meta( $post->ID, 'baxel-slide-new-window', true );
	$baxel_slide_to_post = get_post_meta( $post->ID, 'baxel-slide-to-post', true );
	$baxel_slide_simple = get_post_meta( $post->ID, 'baxel-slide-simple', true );
	
	$posts = get_posts( array( 'numberposts' => -1 ) );
		
	?>
	
    <p>
    <b>a)</b> You can directly insert a post into your slider by selecting it from the <b>"Post Direction"</b> drop down. After selecting it, you can override its properties <em>(Title, Slide Image etc.)</em> if you wish.
    <br />
    <b>b)</b> To create a brand new slide, just do not select a post and fill in the other fields <em>(Title, URL etc.)</em>.
    </p>
    <p>
    <b>Note:</b> Don't forget that you should use the same group name for the slides/posts you want to see in the same slider. See <a href="edit-tags.php?taxonomy=slide_group&post_type=slider"><em>Slide Groups</em></a>.
    </p>
    <hr />
	<p>Post Direction:<br />
	<select id="baxel-slide-to-post" name="baxel-slide-to-post" class="widefat" style="max-width: 300px;">
        <option <?php echo esc_attr( $baxel_slide_to_post ) == 0 ? 'selected="selected"' : '';?> value="0">- Select a Post -</option>
		<?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
        <option <?php echo $post->ID == esc_attr( $baxel_slide_to_post ) ? 'selected="selected"' : '';?> value="<?php echo $post->ID; ?>"><?php echo get_the_title( $post->ID ); ?></option>
		<?php endforeach; ?>
	</select>
	</p>
	<p>Title:<br />
	<input type="text" name="baxel-slide-title" id="baxel-slide-title" value="<?php echo esc_attr( $baxel_slide_title ); ?>" class="widefat" style="max-width: 300px;" />
	</p>
    <p>Teaser:<br />
	<input type="text" name="baxel-slide-teaser" id="baxel-slide-teaser" value="<?php echo esc_attr( $baxel_slide_teaser ); ?>" class="widefat" style="max-width: 300px;" />
	</p>
    <p>URL:<br />
	<input type="text" name="baxel-slide-url" id="baxel-slide-url" value="<?php echo esc_url( $baxel_slide_url ); ?>" class="widefat" style="max-width: 300px;" />
	</p>
    <p><input name="baxel-slide-new-window" id="baxel-slide-new-window" type="checkbox" value="true"<?php if ( $baxel_slide_new_window == 'true' ) { echo ' checked'; } ?>><label for="baxel-slide-new-window"> Open in new window</label></p>
    <p><input name="baxel-slide-simple" id="baxel-slide-simple" type="checkbox" value="true"<?php if ( $baxel_slide_simple == 'true' ) { echo ' checked'; } ?>><label for="baxel-slide-simple"> Show the "Slide Image" only</label></p>

<?php }	
	
function baxel_slider_save_meta_box( $post_id ) {
	
	if ( !isset( $_POST['baxel-slider-meta-box-nonce'] ) || !wp_verify_nonce( $_POST['baxel-slider-meta-box-nonce'], basename( __FILE__ ) ) ) { return $post_id; }		
	if ( !current_user_can( 'edit_post', $post_id ) ) { return $post_id; }		
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }
	
	$baxel_slide_title = '';
	$baxel_slide_teaser = '';
	$baxel_slide_url = '';
	$baxel_slide_new_window = '';
	$baxel_slide_to_post = '';
	$baxel_slide_simple = '';
	
	if( isset( $_POST['baxel-slide-title'] ) ) { $baxel_slide_title = $_POST['baxel-slide-title']; }
	if( isset( $_POST['baxel-slide-teaser'] ) ) { $baxel_slide_teaser = $_POST['baxel-slide-teaser']; }
	if( isset( $_POST['baxel-slide-url'] ) ) { $baxel_slide_url = $_POST['baxel-slide-url']; }
	if( isset( $_POST['baxel-slide-new-window'] ) ) { $baxel_slide_new_window = $_POST['baxel-slide-new-window']; }
	if( isset( $_POST['baxel-slide-to-post'] ) ) { $baxel_slide_to_post = $_POST['baxel-slide-to-post']; }
	if( isset( $_POST['baxel-slide-simple'] ) ) { $baxel_slide_simple = $_POST['baxel-slide-simple']; }
	
	update_post_meta( $post_id, 'baxel-slide-title', $baxel_slide_title );
	update_post_meta( $post_id, 'baxel-slide-teaser', $baxel_slide_teaser );
	update_post_meta( $post_id, 'baxel-slide-url', $baxel_slide_url );
	update_post_meta( $post_id, 'baxel-slide-new-window', $baxel_slide_new_window );
	update_post_meta( $post_id, 'baxel-slide-to-post', $baxel_slide_to_post );
	update_post_meta( $post_id, 'baxel-slide-simple', $baxel_slide_simple );
		
}
add_action( 'save_post', 'baxel_slider_save_meta_box' );
/* */

/* Manage/Edit/Move Columns & Meta Boxes */
function baxel_slider_columns( $columns ) {

	$new_columns = array(	
		'cb' => '<input type=\"checkbox\" />',
		'baxel-slide-image' => 'Image',
		'baxel-slide-title' => 'Title',
		'baxel-slide-groups' => 'Slide Groups',
		'baxel-slide-to-post' => 'Post Direction',
		'baxel-slide-url' => 'URL',
	);
	
	return $new_columns;
	
}
add_filter( 'manage_slider_posts_columns' , 'baxel_slider_columns' );

function baxel_slider_custom_columns( $column, $post_id ) {
		
	switch ( $column ) {
		case 'baxel-slide-image':
			$temp_image_path = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'baxel-small-thumbnail-image' );
			if ( $temp_image_path ) { $final_image_path = $temp_image_path[0]; } else { $final_image_path = plugin_dir_url( __FILE__ ) . 'images/no-thumbnail.png'; }
			echo '<a href="post.php?post=' . $post_id . '&action=edit"><img src="' . $final_image_path . '" /></a>';
			break;
		case 'baxel-slide-title':
			$temp_title = get_post_meta( $post_id, 'baxel-slide-title', true );
			if ( $temp_title ) { $temp_title = '<b>' . $temp_title . '</b>'; } else { $temp_title = '<em>No Title</em>'; }
			echo '<a href="post.php?post=' . $post_id . '&action=edit">' . $temp_title . '</a>';
			break;
		case 'baxel-slide-groups':
			$terms = get_the_terms( $post_id, 'slide_group' );			
			if ( is_array( $terms ) ) {				
				foreach( $terms as $key => $term ) {
					$terms[$key] = '<a href="edit.php?post_type=slider&slide_group=' . $term->slug . '">' . $term->name . '</a>';
				}				
				echo implode( ', ', $terms );				
			}			
			break;
		case 'baxel-slide-to-post':
			$temp_post_title = get_the_title( get_post_meta( $post_id, 'baxel-slide-to-post', true ) );
			if ( $temp_post_title != 'Auto Draft' && $temp_post_title != '' ) { echo '<b>' . $temp_post_title . '</b>'; } else { echo '&mdash;'; }
			break;
		case 'baxel-slide-url':
			$temp_url = get_post_meta( $post_id, 'baxel-slide-url', true );
			if ( $temp_url ) { echo $temp_url; } else { echo '&mdash;'; } 
			break;
	}
	
}
add_action( 'manage_posts_custom_column', 'baxel_slider_custom_columns', 10, 2 );

function baxel_slider_edit_slide_groups_columns( $columns ) {
    	
	unset( $columns['description'], $columns['slug'] );
	
	$new_columns = array(	
		'baxel-slide-shortcode' => 'Slider Shortcode',
	);
	
    return array_merge( $columns, $new_columns );
	
}
add_filter( 'manage_edit-slide_group_columns', 'baxel_slider_edit_slide_groups_columns' );

function baxel_slide_groups_columns( $out, $column, $term_id ) {
	
	switch ( $column ) {
		case 'baxel-slide-shortcode':
			$term = get_term( $term_id, 'slide_group' );
			$out = '<input style="width: 100%;" readonly type="text" value="[baxelslider group=&quot;' . $term->slug . '&quot;]" />';
			break;
	}
	
	return $out;
	
}
add_filter( 'manage_slide_group_custom_column', 'baxel_slide_groups_columns', 10, 3 );

function baxel_slider_move_meta_boxes(){
	
    remove_meta_box( 'postimagediv', 'slider', 'side' );		
    add_meta_box( 'postimagediv', 'Slide Image', 'post_thumbnail_meta_box', 'slider', 'normal', 'low' );
	
}
add_action( 'do_meta_boxes', 'baxel_slider_move_meta_boxes' );
/* */

/* Slide Group Taxonomy */
function baxel_slide_group_tax() {
	
	$labels = array(
		'add_new_item' => 'Add New Slide Group',
		'edit_item' => 'Edit Slide Group',
		'separate_items_with_commas' => 'Separate groups with commas',
		'choose_from_most_used' => 'Choose from the most used groups',
		'not_found' => 'No groups found.',
	);
	
	register_taxonomy( 'slide_group', 'slider', array(
			'label' => 'Slide Groups',
			'labels' => $labels,
			'public' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'rewrite' => false,
		)
	);

}
add_action( 'init', 'baxel_slide_group_tax' );
/* */

/* Hide "Quick Edit" link */
function baxel_slider_hide_quick_edit( $actions, $post ){
	
	global $current_screen;
	
    if( $current_screen->post_type == 'slider' ) {		
		unset( $actions['inline hide-if-no-js'] );	
	}

    return $actions;
	
}
add_filter( 'post_row_actions', 'baxel_slider_hide_quick_edit', 10, 2 );	
/* */

/* Slider Shortcode */	
function baxel_slider_shortcode( $atts = null ) {
	
	global $add_my_script, $ss_atts;
	$add_my_script = true;
	$ss_atts = shortcode_atts(
		array(
			'group' => '',
			'limit' => -1,
		), $atts, 'baxelslider'
	);
	
	$args = array(
		'post_type' => 'slider',
		'posts_per_page' => $ss_atts['limit'],
	);
	
	if ( $ss_atts['group'] != '' ) {		
		$args['tax_query'] = array(
			array( 'taxonomy' => 'slide_group', 'field' => 'slug', 'terms' => $ss_atts['group'] )
		);		
	}
		
	$the_query = new WP_Query( $args );
	$slides = array();
					
	if ( $the_query->have_posts() ) {		
		while ( $the_query->have_posts() ) {
			
			$the_query->the_post();
			
			$baxel_slide_title = get_post_meta( get_the_ID(), 'baxel-slide-title', true );
			$baxel_slide_teaser = get_post_meta( get_the_ID(), 'baxel-slide-teaser', true );
			$baxel_slide_url = get_post_meta( get_the_ID(), 'baxel-slide-url', true );
			$baxel_slide_new_window = get_post_meta( get_the_ID(), 'baxel-slide-new-window', true );
			$baxel_slide_to_post = get_post_meta( get_the_ID(), 'baxel-slide-to-post', true );
			$baxel_slide_simple = get_post_meta( get_the_ID(), 'baxel-slide-simple', true );
			
			$slide_target = '_self';
			if ( $baxel_slide_new_window ) {
				$slide_target = '_blank';
			}
			
			$slide_title = '';
			if ( $baxel_slide_title ) {
				$slide_title = $baxel_slide_title;
			} else if ( $baxel_slide_to_post ) {
				$slide_title = get_the_title( $baxel_slide_to_post );
			}
			
			$slide_teaser_open = '';
			$slide_teaser = '';
			$slide_teaser_close = '';
			if ( $baxel_slide_teaser ) {
				$slide_teaser_open = '<div class="slide-teaser">';
				$slide_teaser = $baxel_slide_teaser;
				$slide_teaser_close = '</div>';
			}
			
			$slide_url = '';
			$slide_a_open = '<div>';
			$slide_a_close = '</div>';
			if ( $baxel_slide_url ) {
				$slide_url = $baxel_slide_url;
			} else if ( $baxel_slide_to_post ) {
				$slide_url = get_the_permalink( $baxel_slide_to_post );
			}
			if ( $slide_url ) {
				$slide_a_open = '<a href="' . esc_url( $slide_url ) . '" target="' . $slide_target . '">';
				$slide_a_close = '</a>';
			}
			
			$slide_image_ID = 0;
			$slide_image = '<div class="null_slide_image"></div>';
			$slide_image_thumbnail = '<img alt="" class="null_slide_image_thumbnail">';
			if ( has_post_thumbnail() ) {
				$slide_image_ID = get_the_ID();
			} else if ( $baxel_slide_to_post ) {
				$slide_image_ID = $baxel_slide_to_post;
			}
			$slide_image_path = wp_get_attachment_image_src( get_post_thumbnail_id( $slide_image_ID ), 'baxel-slider-image' );
			$slide_image_thumbnail_path = wp_get_attachment_image_src( get_post_thumbnail_id( $slide_image_ID ), 'baxel-thumbnail-image' );
			if ( $slide_image_path ) {									
				$slide_image = '<img class="slide-image" alt="" src="' . esc_url( $slide_image_path[0] ) . '">';
				$slide_image_thumbnail = '<img alt="" src="' . esc_url( $slide_image_thumbnail_path[0] ) . '">';
			}
			
			$slide_thumbnail_container = '<div class="slide-lens"></div><div class="slide-thumbnail-container clearfix">' . $slide_image_thumbnail . '<div class="slide-thumbnail-inner fading"><div class="table-cell-middle"><div class="slide-title">' . esc_attr( $slide_title ) . $slide_teaser_open . esc_attr( $slide_teaser ) . $slide_teaser_close . '</div></div></div></div>';
			if ( $baxel_slide_simple ) {
				$slide_thumbnail_container = '<div class="slide-thumbnail-container clearfix">' . $slide_image_thumbnail . '</div>';
			}

			$slides[] = $slide_a_open . $slide_image . $slide_thumbnail_container . $slide_a_close;
			
		}		
	}
	
	wp_reset_query();
	
	return '<div class="baxel-slider-container"><div class="owl-carousel">' . implode( '', $slides ) . '</div></div>';
	
}
add_shortcode( 'baxelslider', 'baxel_slider_shortcode' );
/* */

/* Slide Ordering Engine */
class baxel_slider_order_engine {

    function __construct() {
		
		add_action( 'admin_init', array( $this, 'baxel_slider_refresh' ) );
		add_action( 'admin_init', array( $this, 'baxel_slider_load_scripts' ) );
		add_action( 'wp_ajax_update-menu-order', array( $this, 'baxel_slider_update_order' ) );
		add_action( 'pre_get_posts', array( $this, 'baxel_slider_pre_get_posts' ) );

    }
	
	function baxel_slider_check_scripts() {
		
        $active = false;
        $objects = array( 'slider' );
        if ( isset( $_GET['orderby'] ) || strstr( $_SERVER['REQUEST_URI'], 'action=edit') || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) ) { return false; }
        if ( isset( $_GET['post_type'] ) && !isset( $_GET['taxonomy'] ) && in_array( $_GET['post_type'], $objects ) ) { $active = true; }
        return $active;
		
    }

    function baxel_slider_load_scripts() {
		
		if ( $this->baxel_slider_check_scripts() ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'baxel-slider-order-js', plugin_dir_url( __FILE__ ) . 'assets/slider-order.js', array( 'jquery' ), null, true );
			wp_enqueue_style( 'baxel-slider-order-css', plugin_dir_url( __FILE__ ) . 'assets/slider-order.css', array(), null );		
		}
		
    }

    function baxel_slider_refresh() {
		
        global $wpdb;

		$result = $wpdb->get_results("
			SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min 
			FROM $wpdb->posts 
			WHERE post_type = 'slider' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
		");

		$results = $wpdb->get_results("
			SELECT ID 
			FROM $wpdb->posts 
			WHERE post_type = 'slider' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') 
			ORDER BY menu_order ASC
		");
			
		foreach ( $results as $key => $result ) {
			$wpdb->update( $wpdb->posts, array( 'menu_order' => $key + 1 ), array( 'ID' => $result->ID ) );
		}
        
    }

    function baxel_slider_update_order() {
		
        global $wpdb;
        parse_str( $_POST['order'], $data );

        if ( !is_array( $data ) )
            return false;

        $id_arr = array();
        foreach ( $data as $key => $values ) {
            foreach ( $values as $position => $id ) {
                $id_arr[] = $id;
            }
        }

        $menu_order_arr = array();
        foreach ( $id_arr as $key => $id ) {
            $results = $wpdb->get_results( "SELECT menu_order FROM $wpdb->posts WHERE ID = " . intval( $id ) );
            foreach ( $results as $result ) {
                $menu_order_arr[] = $result->menu_order;
            }
        }

        sort( $menu_order_arr );

        foreach ( $data as $key => $values ) {
            foreach ( $values as $position => $id ) {
                $wpdb->update( $wpdb->posts, array( 'menu_order' => $menu_order_arr[$position] ), array( 'ID' => intval( $id ) ) );
            }
        }
		
    }

    function baxel_slider_pre_get_posts( $wp_query ) {
		
        $objects = array( 'slider' );

        if ( isset( $wp_query->query['post_type'] ) && !isset( $_GET['orderby'] ) ) {
            if ( in_array( $wp_query->query['post_type'], $objects ) ) {
                $wp_query->set( 'orderby', 'menu_order' );
                $wp_query->set( 'order', 'ASC' );
            }
        }
		
    }

}
$baxel_slider_order_engine = new baxel_slider_order_engine();
/* */
?>