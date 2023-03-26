<?php

if ( !isset( $content_width ) ) {
	$content_width = 2560;
}

/* Include Customizer */
include( get_template_directory() . '/customizer.php' );
/* */

/* Load Widgets Filter */
if ( !function_exists( 'baxel_load_widgets' ) ) {
	function baxel_load_widgets() {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'underscore' );

	}
}
add_action( 'load-widgets.php', 'baxel_load_widgets' );
/* */

/* Google Fonts */
include( get_template_directory() . '/lib/google-fonts.php' );

if ( !function_exists( 'baxel_fonts_url' ) ) {
	function baxel_fonts_url() {

		$font_customizer_names = array();

		foreach ( baxel_font_labels() as $key => $val ) {

			$add_underscore = str_replace( ' ', '_', $key );
			$font_customizer_names[ $add_underscore ] = $key . ':300,300i,400,400i,700,700i';

		}

		if ( !get_theme_mod( 'baxel_logo_image' ) ) { $baxel_font_logotype =  get_theme_mod( 'baxel_font_logotype', 'Ubuntu_Condensed' ); } else { $baxel_font_logotype = ''; }

		$font_holders = array(
			get_theme_mod( 'baxel_font_primary', 'Raleway' ),
			get_theme_mod( 'baxel_font_secondary', 'Raleway' ),
			$baxel_font_logotype
		);

		$font_families = array();

		foreach ( $font_customizer_names as $n => $g ) {
			foreach ( $font_holders as $fh ) {
				if( $n == $fh ) {
					if ( !in_array( $g, $font_families ) ) {
						$font_families[] = $g;
					}
				}
			}
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		return esc_url_raw( $fonts_url );

	}
}
/* */

/* Embed Resources */
if ( !function_exists( 'baxel_embed_resources' ) ) {
	function baxel_embed_resources() {

		/* Fonts */
		wp_enqueue_style( 'baxel-fonts', baxel_fonts_url(), array(), null );
		/* */

		wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css', array( 'baxel-fonts' ) );
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( 'style' ), '4.7.0', 'all' );
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '', 'all' );
		wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), '', 'all' );
		wp_enqueue_style( 'slicknav', get_template_directory_uri() . '/css/slicknav.css', array(), '', 'all' );

		wp_add_inline_style( 'slicknav', baxel_rewrite_css() );

		/* */

		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'burnhambox', get_template_directory_uri() . '/js/burnhambox.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'slicknav', get_template_directory_uri() . '/js/jquery.slicknav.min.js', array( 'jquery' ), '', true );

		if ( is_page() && get_theme_mod( 'baxel_map_page_id' ) == get_the_ID() ) {

			$map_api = get_theme_mod( 'baxel_map_api', '' );
			if ( $map_api ) { $map_key = '?key=' . $map_api; } else { $map_key = ''; }

			wp_enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js' . esc_attr( $map_key ), array(), '', false );
			wp_enqueue_script( 'google-maps', get_template_directory_uri() . '/js/maps.js', array( 'jquery' ), '', true );

		}

	}
}
add_action( 'wp_enqueue_scripts', 'baxel_embed_resources' );
/* */

/* Theme setup */
if ( !function_exists( 'baxel_theme_setup' ) ) {
	function baxel_theme_setup() {

		// Navigation Menu
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'baxel' ),
		) );

		$baxel_featured_image_width = get_theme_mod( 'baxel_featured_image_width', 1140 );
		$baxel_featured_image_height = get_theme_mod( 'baxel_featured_image_height', 760 );
		$baxel_thumbnail_image_width = get_theme_mod( 'baxel_thumbnail_image_width', 600 );
		$baxel_thumbnail_image_height = get_theme_mod( 'baxel_thumbnail_image_height', 400 );
		$baxel_slider_image_width = get_theme_mod( 'baxel_slider_image_width', 1140 );
		$baxel_slider_image_height = get_theme_mod( 'baxel_slider_image_height', 570 );

		// Add featured image support. Works for only new added images.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( esc_attr( $baxel_featured_image_width ), esc_attr( $baxel_featured_image_height ), true ); // Featured Image
		add_image_size( 'baxel-slider-image', esc_attr( $baxel_slider_image_width ), esc_attr( $baxel_slider_image_height ), array( 'center', 'top' ) ); // Slider Images
		add_image_size( 'baxel-small-thumbnail-image', 150, 100, array( 'center', 'top' ) ); // Small Thumbnail Image
		add_image_size( 'baxel-thumbnail-image', esc_attr( $baxel_thumbnail_image_width ), esc_attr( $baxel_thumbnail_image_height ), array( 'center', 'top' ) ); // Thumbnail Image
		add_image_size( 'baxel-style-z-image', 540, 210, array( 'center', 'top' ) ); // Style Z Image

		// Add post type support
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'aside' ) );

		// Add automatic feed links support
		add_theme_support( 'automatic-feed-links' );

		// Add title-tag support
		add_theme_support( 'title-tag' );

		// Add text-domain
		load_theme_textdomain( 'baxel', get_template_directory() . '/languages ');

	}
}
add_action( 'after_setup_theme', 'baxel_theme_setup' );
/* */

/* Disable Responsive Image Support for WP 4.4 and higher */
if ( $wp_version >= 4.4 ) {
	// Clean the up the image from wp_get_attachment_image()
	add_filter( 'wp_get_attachment_image_attributes', 'baxel_clear_aia', PHP_INT_MAX );
	// Override the calculated image sizes
	add_filter( 'wp_calculate_image_sizes', '__return_false',  PHP_INT_MAX );
	// Override the calculated image sources
	add_filter( 'wp_calculate_image_srcset', '__return_false', PHP_INT_MAX );
	// Remove the reponsive stuff from the content
	remove_filter( 'the_content', 'wp_make_content_images_responsive' );
}

if ( !function_exists( 'baxel_clear_aia' ) ) {
	function baxel_clear_aia( $attr ) {

		if( isset( $attr['sizes'] ) ) { unset( $attr['sizes'] ); }
		if( isset( $attr['srcset'] ) ) { unset( $attr['srcset'] ); }
		return $attr;

	}
}
/* */

/* Add Custom Post Options */
if ( !function_exists( 'baxel_add_meta_box' ) ) {
	function baxel_add_meta_box() {

		add_meta_box( 'baxel-meta-box', esc_html__( 'Baxel Post Options', 'baxel' ), 'baxel_meta_box_markup', array( 'post', 'page' ), 'side', 'low' );

	}
}
add_action( 'add_meta_boxes', 'baxel_add_meta_box' );

if ( !function_exists( 'baxel_meta_box_markup' ) ) {
	function baxel_meta_box_markup( $object ) {

		wp_nonce_field( basename( __FILE__ ), 'baxel-meta-box-nonce' );

		$baxel_woi_meta_box_checkbox_value = get_post_meta( $object->ID, 'baxel-woi-meta-box-checkbox', true );
		$baxel_sidebar_meta_box_checkbox_value = get_post_meta( $object->ID, 'baxel-sidebar-meta-box-checkbox', true );
		$baxel_share_meta_box_checkbox_value = get_post_meta( $object->ID, 'baxel-share-meta-box-checkbox', true ); ?>

        <?php if ( $object->post_type == 'post' ) { ?>

        <p><input name="baxel-woi-meta-box-checkbox" id="baxel-woi-meta-box-checkbox" type="checkbox" value="true"<?php if ( $baxel_woi_meta_box_checkbox_value == 'true' ) { echo ' checked'; } ?>><label for="baxel-woi-meta-box-checkbox"> <?php echo esc_html__( 'Hide Featured Image on Post Page', 'baxel' ); ?></label></p>

        <?php } ?>

        <p><input name="baxel-sidebar-meta-box-checkbox" id="baxel-sidebar-meta-box-checkbox" type="checkbox" value="true"<?php if ( $baxel_sidebar_meta_box_checkbox_value == 'true' ) { echo ' checked'; } ?>><label for="baxel-sidebar-meta-box-checkbox"> <?php echo esc_html__( 'Hide Sidebar on Post Page', 'baxel' ); ?></label></p>
        <p><input name="baxel-share-meta-box-checkbox" id="baxel-share-meta-box-checkbox" type="checkbox" value="true"<?php if ( $baxel_share_meta_box_checkbox_value == 'true' ) { echo ' checked'; } ?>><label for="baxel-share-meta-box-checkbox"> <?php echo esc_html__( 'Hide Share Icons on Post Page', 'baxel' ); ?></label></p>

	<?php }
}

if ( !function_exists( 'baxel_save_meta_box' ) ) {
	function baxel_save_meta_box( $post_id, $post, $update ) {

		if ( !isset( $_POST['baxel-meta-box-nonce'] ) || !wp_verify_nonce( $_POST['baxel-meta-box-nonce'], basename( __FILE__ ) ) ) { return $post_id; }
		if ( !current_user_can( 'edit_post', $post_id ) ) { return $post_id; }
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }

		$baxel_woi_meta_box_checkbox_value = '';
		$baxel_sidebar_meta_box_checkbox_value = '';
		$baxel_share_meta_box_checkbox_value = '';

		if( isset( $_POST['baxel-woi-meta-box-checkbox'] ) ) { $baxel_woi_meta_box_checkbox_value = $_POST['baxel-woi-meta-box-checkbox']; }
		if( isset( $_POST['baxel-sidebar-meta-box-checkbox'] ) ) { $baxel_sidebar_meta_box_checkbox_value = $_POST['baxel-sidebar-meta-box-checkbox']; }
		if( isset( $_POST['baxel-share-meta-box-checkbox'] ) ) { $baxel_share_meta_box_checkbox_value = $_POST['baxel-share-meta-box-checkbox']; }

		update_post_meta( $post_id, 'baxel-woi-meta-box-checkbox', $baxel_woi_meta_box_checkbox_value );
		update_post_meta( $post_id, 'baxel-sidebar-meta-box-checkbox', $baxel_sidebar_meta_box_checkbox_value );
		update_post_meta( $post_id, 'baxel-share-meta-box-checkbox', $baxel_share_meta_box_checkbox_value );

	}
}
add_action( 'save_post', 'baxel_save_meta_box', 10, 3 );
/* */

/* Find all galleries and make them slider. */
if ( !function_exists( 'baxel_gallery_to_slider' ) ) {
	function baxel_gallery_to_slider( $content ) {

		global $post;

		if ( get_post_format() == 'gallery' && has_shortcode( $post->post_content, 'gallery' ) ) {

			$galleries = get_post_galleries_images( $post );
			$image_list = '<div class="owl-carousel">';
			foreach( $galleries as $gallery ) {
				foreach( $gallery as $image_url ) {
					$image_list .= '<img alt="" src="' . esc_url( $image_url ) . '">';
				}
			}
			$image_list .= '</div>';
			$content = $image_list;

		}

		return $content;

	}
}
/* */

/* Get the first image of the post/gallery */
if ( !function_exists( 'baxel_get_the_first_image' ) ) {
	function baxel_get_the_first_image() {

		global $post;
		$first_img = '';

		$galleries = get_post_galleries_images( $post );

		if ( $galleries ) {

			foreach( $galleries as $gallery ) {
				$first_img = $gallery[0];
				break;
			}

		} else {

			$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
			if ( $output ) { $first_img = $matches[1][0]; }

		}

		return $first_img;

	}
}
/* */

/* Clear White Space */
if ( !function_exists( 'baxel_compress' ) ) {
	function baxel_compress( $buffer ) {

		$buffer = preg_replace( '~>\s+<~', '><', $buffer );
		return $buffer;

	}
}
/* */

/* Add responsive container to embeds for wordpress.tv */
if ( !function_exists( 'baxel_embed_html' ) ) {
	function baxel_embed_html( $html ) {

		$html = preg_replace(
			array(
				'{<embed src="//v.wordpress}',
				'{wmode="transparent">}'
			),
			array(
				'<div class="video-container"><embed src="//v.wordpress',
				'wmode="transparent"></div>'
			), $html
		);

		return $html;

	}
}
add_filter( 'embed_oembed_html', 'baxel_embed_html', 10, 3 );
/* */

/* Content Filter */
if ( !function_exists( 'baxel_filter_content' ) ) {
	function baxel_filter_content( $content ) {

		// Add "to_fit_vids class" to iframes to make the videos responsive in posts
		// Convert self hosted videos to HTML5
		$content = preg_replace(
			array(
				'{<iframe}',
				'{</iframe>}',
				'/\[video(.+?(?=http))/',
				'/\]\[\/video]/',
			),
			array(
				'<div class="to_fit_vids"><iframe',
				'</iframe></div>',
				'<div class="to_fit_vids"><video controls><source src="',
				' type="video/mp4"></video></div>',
			),
			$content
		);

		return $content;

	}
}
add_filter( 'the_content', 'baxel_filter_content' );
/* */

/* Find the first video of the post and display it instead of the featured image */
if ( !function_exists( 'baxel_featured_video' ) ) {
	function baxel_featured_video() {

		global $post;
		$result = '';
		$output = preg_match(
			'/(https?:\/\/(?:www\.)?vimeo\.com\/([^\s]+))|\[embed(.*)]|\[\/embed]|(https?:\/\/(?:www\.)?youtube\.com\/watch\?v=([^\s]+))|(\[video(.*)])/',
			$post->post_content,
			$match
		);

		if ( $output ) {
			if ( strpos( $match[0], 'video' ) ) {
				$result = preg_replace(
					array(
						'/\[video(.+?(?=http))/',
						'/\]\[\/video]/',
					),
					array(
						'<div class="article-featured-video to_fit_vids"><video controls><source src="',
						' type="video/mp4"></video></div>',
					),
					$match[0]
				);
			} else {
				$result = '<div class="article-featured-video to_fit_vids"><iframe src="' . preg_replace(
					array(
						'/\[embed]/',
						'/\[\/embed]/',
						'{https://vimeo.com}',
						'{https://www.youtube.com/watch\?v=}',
					 ),
					 array(
						'',
						'',
						'https://player.vimeo.com/video',
						'https://www.youtube.com/embed/',
					),
					esc_attr( $match[0] )
				) . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen width="960" height="540"></iframe></div>';
			}
		}

		return $result;

	}
}
/* */

/* Remove the first video from the content */
if ( !function_exists( 'baxel_remove_featured_video' ) ) {
	function baxel_remove_featured_video() {

		$result = preg_replace( '/\<div class="to_fit_vids"(.*)\<\/div>/', '', baxel_format_get_the_content(), 1 );
		return $result;

	}
}
/* */

/* Formatting the content like "the_content" while using "get_the_content" */
if ( !function_exists( 'baxel_format_get_the_content' ) ) {
	function baxel_format_get_the_content( $more_link_text = null, $stripteaser = false ) {

		$content = get_the_content( $more_link_text, $stripteaser );
		$content = apply_filters( 'the_content', $content );
		return $content;

	}
}
/* */

/* Combine Listing Styles */
if ( !function_exists( 'baxel_call_post_order' ) ) {
	function baxel_call_post_order() {

		//Call the post order in the loop
		global $baxel_counter;
		return $baxel_counter;

	}
}

if ( !function_exists( 'baxel_check_style_z' ) ) {
	function baxel_check_style_z() {

		$baxel_postPerPage = get_option( 'posts_per_page' );

		if ( is_archive() ) {
			$baxel_z_count = get_theme_mod( 'baxel_z_count_archive', 0 );
		} else {
			$baxel_z_count = get_theme_mod( 'baxel_z_count', 0 );
		}

		if ( $baxel_z_count > $baxel_postPerPage ) {
			$baxel_z_count = 0;
		}

		$baxel_postOrder = baxel_call_post_order();
		$baxel_postOrder ++;
		$baxel_styleZ_boo = false;

		if ( $baxel_z_count == 0 || is_single() ) {
			$baxel_styleZ_boo = false;
		} else {
			if ( $baxel_postOrder > $baxel_postPerPage - $baxel_z_count ) {
				$baxel_styleZ_boo = true;
			}
		}

		if ( is_search() ) {
			$baxel_styleZ_boo = true;
		}

		return $baxel_styleZ_boo;

	}
}
/* */

/* Set "Read More" button */
if ( !function_exists( 'baxel_set_more_button' ) ) {
	function baxel_set_more_button() {

		global $post;

		$baxel_readMore_1 = '<a class="btnReadMore" href="';
		$baxel_readMore_2 = esc_attr( baxel_translation( '_ReadMore' ) ) . '</a>';

		if ( get_theme_mod( 'baxel_show_read_more', 1 ) && !is_single() ) {

			if( !strstr( $post->post_content, '<!--more-->' ) ) { return '...' . $baxel_readMore_1 . esc_url( get_permalink() ) . '">' . $baxel_readMore_2; }

		}

	}
}
add_filter( 'excerpt_more', 'baxel_set_more_button' );
/* */

/* Append "Read More" button */
if ( !function_exists( 'baxel_append_excerpt' ) ) {
	function baxel_append_excerpt() {

		global $post;

		$baxel_readMore_1 = '<a class="btnReadMore" href="';
		$baxel_readMore_2 = esc_attr( baxel_translation( '_ReadMore' ) ) . '</a>';

		if ( get_theme_mod( 'baxel_show_excerpt_indexed', 1 ) ) {

			echo '<div class="article-pure-content clearfix">';

			if( strstr( $post->post_content, '<!--more-->' ) ) {

				$excerpt = get_the_excerpt();

				if ( get_theme_mod( 'baxel_show_read_more', 1 ) ) {

					echo wp_kses_post( $excerpt ) . $baxel_readMore_1 . esc_url( get_permalink() ) . '">' . $baxel_readMore_2 . '</div>';

				}

			} else {

				if ( $post->post_excerpt ) {

					$excerpt = get_the_excerpt();

					if ( get_theme_mod( 'baxel_show_read_more', 1 ) ) {

						echo wp_kses_post( $excerpt ) . $baxel_readMore_1 . esc_url( get_permalink() ) . '">' . $baxel_readMore_2 . '</div>';

					} else {

						echo wp_kses_post( $excerpt ) . '</div>';

					}

				} else {

					echo get_the_excerpt();
					echo '</div>';

				}

			}

		}

	}
}
/* */

/* Apply layout options */
if ( !function_exists( 'baxel_apply_layout' ) ) {
	function baxel_apply_layout() {

		/* Radio Default Values */
		$baxel_layout_style = get_theme_mod( 'baxel_layout_style', '1col_sidebar' );
		$baxel_layout_style_archive = get_theme_mod( 'baxel_layout_style_archive', '1col_sidebar' );
		/* */

		$meta_sidebar = get_post_meta( get_the_ID(), 'baxel-sidebar-meta-box-checkbox', true );
		$layout = '';

		if ( is_single() ) {

			if ( !is_attachment() ) {

				if ( ( get_post_format() == '' || get_post_format() == 'aside' ) && get_theme_mod( 'baxel_show_sidebar_standard', 1 ) && !$meta_sidebar ) {

					// Show sidebar at standard posts
					$layout = '-sidebar';

				} else if ( get_post_format() == 'gallery' && get_theme_mod( 'baxel_show_sidebar_gallery', 1 ) && !$meta_sidebar ) {

					// Show sidebar at gallery posts
					$layout = '-sidebar';

				} else if ( get_post_format() == 'video' && get_theme_mod( 'baxel_show_sidebar_video', 1 ) && !$meta_sidebar ) {

					// Show sidebar at video posts
					$layout = '-sidebar';

				}

			}

		} else if ( is_category() || is_author() || is_tag() || is_archive() || is_search() ) {

			if ( $baxel_layout_style_archive == '1col' ) {

				// No sidebar
				$layout = '';

			} else if ( $baxel_layout_style_archive == '2col' ) {

				// 2 columns //-c(olumn)c(ount)2
				$layout = '-cc2';

			} else if ( $baxel_layout_style_archive == '3col' || $baxel_layout_style_archive == '2_3col' ) {

				// 3 columns //-c(olumn)c(ount)3
				$layout = '-cc3';

			} else if ( $baxel_layout_style_archive == '1col_sidebar' ) {

				// Columns + Sidebar
				$layout = '-sidebar';

			} else if ( $baxel_layout_style_archive == '2col_sidebar' || $baxel_layout_style_archive == '1_2col_sidebar' ) {

				// Columns + Sidebar
				$layout = '-sidebar-cc2';

			}

		} else if ( is_page() ) {

			if ( is_front_page() ) {

				if ( get_theme_mod( 'baxel_show_sidebar_static', 1 ) && !$meta_sidebar ) {

					// Show sidebar on inner pages
					$layout = '-sidebar';

				}

			} else {

				if ( get_theme_mod( 'baxel_show_sidebar_page', 1 ) && !$meta_sidebar ) {

					// Show sidebar on inner pages
					$layout = '-sidebar';

				}

			}

		} else if ( is_404() ) {

			$layout = '';

		} else {

			if ( $baxel_layout_style == '1col' ) {

				// No sidebar
				$layout = '';

			} else if ( $baxel_layout_style == '2col' ) {

				// 2 columns //-c(olumn)c(ount)2
				$layout = '-cc2';

			} else if ( $baxel_layout_style == '3col' || $baxel_layout_style == '2_3col' ) {

				// 3 columns //-c(olumn)c(ount)3
				$layout = '-cc3';

			} else if ( $baxel_layout_style == '1col_sidebar' ) {

				// Columns + Sidebar
				$layout = '-sidebar';

			} else if ( $baxel_layout_style == '2col_sidebar' || $baxel_layout_style == '1_2col_sidebar' ) {

				// Columns + Sidebar
				$layout = '-sidebar-cc2';

			}

		}

		return $layout;

	}
}
/* */

/* Apply column options */
if ( !function_exists( 'baxel_apply_columns' ) ) {
	function baxel_apply_columns() {

		/* Radio Default Values */
		$baxel_layout_style = get_theme_mod( 'baxel_layout_style', '1col_sidebar' );
		$baxel_layout_style_archive = get_theme_mod( 'baxel_layout_style_archive', '1col_sidebar' );
		/* */

		$column = '';

		if ( is_category() || is_author() || is_tag() || is_archive() || is_search() ) {

			if ( $baxel_layout_style_archive == '1col' ) {

				// No sidebar
				$column = '';

			} else if ( $baxel_layout_style_archive == '2col' ) {

				// 2 Columns (No sidebar)
				$column = 'col-1-2';

			} else if ( $baxel_layout_style_archive == '3col' || $baxel_layout_style_archive == '2_3col' ) {

				// 3 Columns (No sidebar)
				$column = 'col-1-3';

			} else if ( $baxel_layout_style_archive == '1col_sidebar' ) {

				// 1 Column + Sidebar
				$column = '';

			} else if ( $baxel_layout_style_archive == '2col_sidebar' || $baxel_layout_style_archive == '1_2col_sidebar' ) {

				// 2 Columns + Sidebar
				$column = 'col-1-2-sidebar';

			}

		} else {

			if ( $baxel_layout_style == '1col' ) {

				// No sidebar
				$column = '';

			} else if ( $baxel_layout_style == '2col' ) {

				// 2 Columns (No sidebar)
				$column = 'col-1-2';

			} else if ( $baxel_layout_style == '3col' || $baxel_layout_style == '2_3col' ) {

				// 3 Columns (No sidebar)
				$column = 'col-1-3';

			} else if ( $baxel_layout_style == '1col_sidebar' ) {

				// 1 Column + Sidebar
				$column = '';

			} else if ( $baxel_layout_style == '2col_sidebar' || $baxel_layout_style == '1_2col_sidebar' ) {

				// 2 Columns + Sidebar
				$column = 'col-1-2-sidebar';

			}

		}

		return $column;

	}
}
/* */

/* Pagination */
if ( !function_exists( 'baxel_page_navigation' ) ) {
	function baxel_page_navigation() {

		global $wp_query, $indexPosts;

		$baxel_big = 999999999; // need an unlikely integer

		if ( get_theme_mod( 'baxel_slider_exclude_posts', 0 ) ) {

			if ( is_home() ) {

				$baxel_current_query_mnp = $indexPosts->max_num_pages;

			} else {

				$baxel_current_query_mnp = $wp_query->max_num_pages;

			}

		} else {

			$baxel_current_query_mnp = $wp_query->max_num_pages;

		}

		$baxel_paginate_links = paginate_links( array(

			'base' => str_replace( $baxel_big, '%#%', esc_url( get_pagenum_link( $baxel_big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total' => $baxel_current_query_mnp,
			'prev_text' => '<i class="fa fa-caret-left"></i>',
			'next_text' => '<i class="fa fa-caret-right"></i>',
			'end_size' => 1,
			'mid_size' => 1

		) );

		if ( $baxel_paginate_links ) {

			echo '<div class="pagenavi clearfix';

			if ( get_query_var( 'paged' ) <= 1 ) {

				echo ' pagenavi-fp';

			} else if ( get_query_var( 'paged' ) == $baxel_current_query_mnp ) {

				echo ' pagenavi-lp';

			} else {

				echo ' pagenavi-cp';

			}

			echo '">';
			echo wp_kses_post( $baxel_paginate_links );
			echo '</div>';

		}

	}
}

if ( !function_exists( 'baxel_post_navigation' ) ) {
	function baxel_post_navigation( $direction, $posting, $term ) {

		$post_navigation = '';

		if( $posting ) {

			$post_navigation .= '<a class="post-navi-' . $direction . ' clearfix" href="' . get_permalink( $posting->ID ) . '">' .
									'<div class="post-navi-inner">';
										$post_navigation .= '<div class="post-navi-' . $direction . '-info">' .
											'<div class="table-cell-middle">' .
												'<div class="post-navi-label">' . esc_attr( $term ) . '</div>' .
												'<div class="post-navi-title">' . get_the_title( $posting->ID ) . '</div>' .
											'</div>' .
										'</div>' .
									'</div>' .
								'</a>';

		}

		return $post_navigation;

	}
}
/* */

/* Social Icons */
if ( !function_exists( 'baxel_social_labels' ) ) {
	function baxel_social_labels() {

		$labels = array(
			esc_html__( 'Facebook', 'baxel' ),
			esc_html__( 'Twitter', 'baxel' ),
			esc_html__( 'Instagram', 'baxel' ),
			esc_html__( 'Pinterest', 'baxel' ),
			esc_html__( 'Google+', 'baxel' ),
			esc_html__( 'Tumblr', 'baxel' ),
			esc_html__( 'Flickr', 'baxel' ),
			esc_html__( 'Digg', 'baxel' ),
			esc_html__( 'LinkedIn', 'baxel' ),
			esc_html__( 'Vimeo', 'baxel' ),
			esc_html__( 'YouTube', 'baxel' ),
			esc_html__( 'Behance', 'baxel' ),
			esc_html__( 'Dribble', 'baxel' ),
			esc_html__( 'DeviantArt', 'baxel' ),
			esc_html__( 'Github', 'baxel' ),
			esc_html__( 'Bloglovin', 'baxel' ),
			esc_html__( 'Lastfm', 'baxel' ),
			esc_html__( 'SoundCloud', 'baxel' ),
			esc_html__( 'VK', 'baxel' )
		);

		return $labels;

	}
}

if ( !function_exists( 'baxel_social_icons' ) ) {
	function baxel_social_icons() {

		$icons = array(
			'fa-facebook',
			'fa-twitter',
			'fa-instagram',
			'fa-pinterest-p',
			'fa-google-plus',
			'fa-tumblr',
			'fa-flickr',
			'fa-digg',
			'fa-linkedin',
			'fa-vimeo',
			'fa-youtube',
			'fa-behance',
			'fa-dribbble',
			'fa-deviantart',
			'fa-github',
			'fa-heart',
			'fa-lastfm',
			'fa-soundcloud',
			'fa-vk'
		);

		return $icons;

	}
}

if ( !function_exists( 'baxel_social_names' ) ) {
	function baxel_social_names() {

		$account_names = array(
			'facebook',
			'twitter',
			'instagram',
			'pinterest',
			'google',
			'tumblr',
			'flickr',
			'digg',
			'linkedin',
			'vimeo',
			'youtube',
			'behance',
			'dribble',
			'deviantart',
			'github',
			'bloglovin',
			'lastfm',
			'soundcloud',
			'vk'
		);

		return $account_names;

	}
}

if ( !function_exists( 'baxel_insert_social_icons' ) ) {
	function baxel_insert_social_icons( $location ) {

		$baxel_social_accounts = array();

		foreach ( baxel_social_labels() as $val ) {

			array_push( $baxel_social_accounts, get_theme_mod( 'baxel_social_' . $val ) );

		}

		$baxel_social_faIcons = baxel_social_icons();
		global $baxel_social_show;
		$baxel_social_show = false;
		$baxel_social_html = '<div class="' . $location . '">';

		foreach ( $baxel_social_accounts as $key => $sa ) {

			if ( $sa != 'http://' && $sa != '' ) {

				$baxel_social_show = true;
				$baxel_social_html .= '<a class="social-menu-item" href="' . esc_url( $sa ) . '" target="_blank"><i class="fa ' . $baxel_social_faIcons[ $key ] . '"></i></a>';

			}

		}

		$baxel_social_html .= '</div>';

		if ( $location == 'footer-social' && ( !$baxel_social_show || !get_theme_mod( 'baxel_show_footer_social', 1 ) ) ) {

			if ( get_theme_mod( 'baxel_show_to_top', 1 ) && get_theme_mod( 'baxel_copyright_text', '2017 Baxel. All rights reserved.' ) ) {

				$baxel_social_html = '<div class="' . $location . '"><a href="javascript:void(0);" class="btn-to-top">' . esc_attr( baxel_translation( '_BackToTop' ) ) . '<i class="fa fa-caret-up"></i></a></div>';

			} else {

				$baxel_social_html = '<div class="' . $location . ' fs10"></div>';

			}

		}

		return $baxel_social_html;

	}
}
/* */

/* Place Slider */
if ( !function_exists( 'baxel_insert_slider' ) ) {
	function baxel_insert_slider() {

		$sliderShortcode = get_theme_mod( 'baxel_slider_shortcode', '' );

		if ( $sliderShortcode ) {

			if ( is_home() ) {

				if ( get_theme_mod( 'baxel_slider_during_pagination', 0 ) ) {

					echo do_shortcode( esc_attr( $sliderShortcode ) );

				} else if ( get_query_var( 'paged' ) <= 1 ) {

					echo do_shortcode( esc_attr( $sliderShortcode ) );

				}

			}

			if ( is_archive() && get_theme_mod( 'baxel_slider_archive', 0 ) ) {

				echo do_shortcode( esc_attr( $sliderShortcode ) );

			}

			if ( is_single() && get_theme_mod( 'baxel_slider_post', 0 ) ) {

				echo do_shortcode( esc_attr( $sliderShortcode ) );

			}

		}

	}
}
/* */

/* "Show Blog Posts" Feature for Slider */
if ( !function_exists( 'baxel_posts_to_slider' ) ) {
	function baxel_posts_to_slider() {

		$showposts = get_theme_mod( 'baxel_slider_posts_number', 5 );
		$category = get_theme_mod( 'baxel_slider_categories', '' );

		if ( $category ) {

			$loop_args = array(

				'showposts' => $showposts,
				'category_name' => $category,
				'ignore_sticky_posts' => 1

			);

		} else {

			$loop_args = array(

				'showposts' => $showposts,
				'ignore_sticky_posts' => 1

			);

		}

		$wp_query = new WP_Query( $loop_args );
		$slides = array();

		if ( $wp_query->have_posts() ) {

			while ( $wp_query->have_posts() ) {

				$wp_query->the_post();
				$slide_image = '<div class="null_slide_image"></div>';
				$slide_image_thumbnail = '<img alt="" class="null_slide_image_thumbnail">';
				$slide_image_path = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'baxel-slider-image' );
				$slide_image_thumbnail_path = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'baxel-thumbnail-image' );

				if ( $slide_image_path ) {

					$slide_image = '<img class="slide-image" alt="" src="' . esc_url( $slide_image_path[0] ) . '">';
					$slide_image_thumbnail = '<img alt="" src="' . esc_url( $slide_image_thumbnail_path[0] ) . '">';

				}

				$slides[] = '<a href="' . esc_url( get_the_permalink() ) . '">' . $slide_image . '<div class="slide-lens"></div><div class="slide-thumbnail-container clearfix">' . $slide_image_thumbnail . '<div class="slide-thumbnail-inner fading"><div class="table-cell-middle"><div class="slide-title">' . get_the_title() . '</div></div></div></div></a>';

			}

		}

		wp_reset_postdata();

		$bpts = '<div class="baxel-slider-container"><div class="owl-carousel">' . implode( '', $slides ) . '</div></div>';

		if ( get_theme_mod( 'baxel_slider_posts', 0 ) ) {

			if ( is_home() ) {

				if ( get_theme_mod( 'baxel_slider_during_pagination', 0 ) ) {

					echo wp_kses_post( $bpts );

				} else if ( get_query_var( 'paged' ) <= 1 ) {

					echo wp_kses_post( $bpts );

				}

			}

			if ( is_archive() && get_theme_mod( 'baxel_slider_archive', 0 ) ) {

				echo wp_kses_post( $bpts );

			}

			if ( is_single() && get_theme_mod( 'baxel_slider_post', 0 ) ) {

				echo wp_kses_post( $bpts );

			}

		}

	}
}
/* */

/* Exclude posts used in the slider */
if ( !function_exists( 'baxel_exclude_posts_from_slider' ) ) {
	function baxel_exclude_posts_from_slider() {

		$excludePostIDs = array();

		if ( get_theme_mod( 'baxel_slider_posts', 0 ) ) {

			$showposts = get_theme_mod( 'baxel_slider_posts_number', 5 );
			$category = get_theme_mod( 'baxel_slider_categories', '' );

			if ( $category ) {

				$loop_args = array(

					'showposts' => $showposts,
					'category_name' => $category,
					'ignore_sticky_posts' => 1

				);

			} else {

				$loop_args = array(

					'showposts' => $showposts,
					'ignore_sticky_posts' => 1

				);

			}

			$wp_query = new WP_Query( $loop_args );

			if ( $wp_query->have_posts() ) {

				while ( $wp_query->have_posts() ) {

					$wp_query->the_post();
					array_push( $excludePostIDs, get_the_ID() );

				}

			}

			wp_reset_postdata();

		} else {

			$loop_args = array(

					'post_type' => 'slider',
					'ignore_sticky_posts' => 1

				);

			$wp_query = new WP_Query( $loop_args );

			if ( $wp_query->have_posts() ) {

				while ( $wp_query->have_posts() ) {

					$wp_query->the_post();
					array_push( $excludePostIDs, get_post_meta( get_the_ID(), 'baxel-slide-to-post', true ) );

				}

			}

			wp_reset_postdata();

		}

		return $excludePostIDs;

	}
}
/* */

/* Hit Counter */
if ( !function_exists( 'baxel_get_post_views' ) ) {
	function baxel_get_post_views( $postID ) {

		$count_key = 'post_views_count';
		$count = get_post_meta( $postID, $count_key, true );

		if ( $count == '' ) {

			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, 0 );
			return 0;

		}

		return $count;

	}
}

if ( !function_exists( 'baxel_set_post_views' ) ) {
	function baxel_set_post_views( $postID ) {

		$count_key = 'post_views_count';
		$count = get_post_meta( $postID, $count_key, true );

		if ( $count == '' ) {

			$count = 0;
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, 0 );

		} else {

			$count ++;
			update_post_meta( $postID, $count_key, $count );

		}

	}
}
/* */

/* HEX to RGB */
if ( !function_exists( 'baxel_hex2rgb' ) ) {
	function baxel_hex2rgb( $hex ) {

		$hex = str_replace( '#', '', $hex );

		if ( strlen( $hex ) == 3 ) {

			$r = hexdec( substr( $hex, 0, 1 ).substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1).substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1).substr( $hex, 2, 1 ) );

		} else {

			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );

		}

		$rgb = array( $r, $g, $b );
		return implode( ',', $rgb );

	}
}
/* */

/* Nothing Found */
if ( !function_exists( 'baxel_nothing_found' ) ) {
	function baxel_nothing_found() {

		$template = '<div class="nothing-found"><i class="fa fa-ban"></i>' . esc_attr( baxel_translation( '_NothingFound' ) ) . '</div>';
		return $template;

	}
}
/* */

/* Widgets */
if ( !function_exists( 'baxel_widgets_init' ) ) {
	function baxel_widgets_init() {

		$fw_col_number = '';

		if ( get_theme_mod( 'baxel_footer_widgets_column', '3col' ) == '2col' ) {

			$fw_col_number = '-col2';

		} else if ( get_theme_mod( 'baxel_footer_widgets_column', '3col' ) == '4col' ) {

			$fw_col_number = '-col4';

		}

		$baxel_widget_before_widget = '<div id="%1$s" class="widget-item clearfix %2$s">';
		$baxel_widget_before_title = '<h2>';
		$baxel_widget_after_title = '</h2>';
		$baxel_widget_after_widget = '</div>';

		// Add Widget Areas
		register_sidebar( array(
			'name' => esc_html__( 'Sidebar - Default', 'baxel' ),
			'id' => 'baxel_sidebar_home',
			'before_widget' => $baxel_widget_before_widget,
			'before_title' => $baxel_widget_before_title,
			'after_title' => $baxel_widget_after_title,
			'after_widget' => $baxel_widget_after_widget,
		) );

		register_sidebar( array(
			'name' => esc_html__( 'Sidebar - Post', 'baxel' ),
			'id' => 'baxel_sidebar_post',
			'before_widget' => $baxel_widget_before_widget,
			'before_title' => $baxel_widget_before_title,
			'after_title' => $baxel_widget_after_title,
			'after_widget' => $baxel_widget_after_widget,
		) );

		register_sidebar( array(
			'name' => esc_html__( 'Sidebar - Page', 'baxel' ),
			'id' => 'baxel_sidebar_page',
			'before_widget' => $baxel_widget_before_widget,
			'before_title' => $baxel_widget_before_title,
			'after_title' => $baxel_widget_after_title,
			'after_widget' => $baxel_widget_after_widget,
		) );

		register_sidebar( array(
			'name' => esc_html__( 'Sidebar - Static Front Page', 'baxel' ),
			'id' => 'baxel_sidebar_static',
			'before_widget' => $baxel_widget_before_widget,
			'before_title' => $baxel_widget_before_title,
			'after_title' => $baxel_widget_after_title,
			'after_widget' => $baxel_widget_after_widget,
		) );

		register_sidebar( array(
			'name' => esc_html__( 'Sidebar - Archive', 'baxel' ),
			'id' => 'baxel_sidebar_archive',
			'before_widget' => $baxel_widget_before_widget,
			'before_title' => $baxel_widget_before_title,
			'after_title' => $baxel_widget_after_title,
			'after_widget' => $baxel_widget_after_widget,
		) );

		register_sidebar( array(
			'name' => esc_html__( 'Footer Widgets', 'baxel' ),
			'id' => 'baxel_footer_widgets',
			'before_widget' => '<div id="%1$s" class="widget-item-footer fw-columns' . $fw_col_number . ' clearfix %2$s">',
			'before_title' => $baxel_widget_before_title,
			'after_title' => $baxel_widget_after_title,
			'after_widget' => $baxel_widget_after_widget,
		) );

		// Register Widgets
		register_widget( 'baxel_widget_ads' );
		register_widget( 'baxel_widget_search' );
		register_widget( 'baxel_widget_social' );
		register_widget( 'baxel_widget_image' );
		register_widget( 'baxel_widget_empty_space' );
		register_widget( 'baxel_widget_recent_comments' );
		register_widget( 'baxel_widget_facebook' );
		register_widget( 'baxel_widget_post' );
		register_widget( 'baxel_widget_recent_posts' );
		register_widget( 'baxel_widget_popular_posts' );
		register_widget( 'baxel_widget_selected_posts' );
		register_widget( 'baxel_widget_category_posts' );

	}
}
add_action( 'widgets_init', 'baxel_widgets_init' );
/* */

/* Include Widgets */
include( get_template_directory() . '/lib/widgets/ads.php' );
include( get_template_directory() . '/lib/widgets/search.php' );
include( get_template_directory() . '/lib/widgets/social.php' );
include( get_template_directory() . '/lib/widgets/image.php' );
include( get_template_directory() . '/lib/widgets/empty-space.php' );
include( get_template_directory() . '/lib/widgets/recent-comments.php' );
include( get_template_directory() . '/lib/widgets/facebook-find-us.php' );
include( get_template_directory() . '/lib/widgets/post.php' );
include( get_template_directory() . '/lib/widgets/recent-posts.php' );
include( get_template_directory() . '/lib/widgets/popular-posts.php' );
include( get_template_directory() . '/lib/widgets/selected-posts.php' );
include( get_template_directory() . '/lib/widgets/cat-posts.php' );
/* */

/* Customize Default Tag Cloud Widget */
if ( !function_exists( 'baxel_tag_cloud_args' ) ) {
	function baxel_tag_cloud_args( $args ) {

		$args['format'] = 'flat';
		$args['separator'] = ', ';
		return $args;

	}
}
add_filter( 'widget_tag_cloud_args', 'baxel_tag_cloud_args' );
/* */

/* Footer Widgets Outer */
if ( !function_exists( 'baxel_footer_widgets_outer' ) ) {
	function baxel_footer_widgets_outer( $id ) {

		$fw_class = '';

		if ( $id == 'baxel_footer_widgets' ) {

			$fw_col_number = '';
			if ( get_theme_mod( 'baxel_footer_widgets_column', '3col' ) == '2col' ) { $fw_col_number = '-col2'; } else if ( get_theme_mod( 'baxel_footer_widgets_column', '3col' ) == '4col' ) { $fw_col_number = '-col4'; }
			$fw_class = 'widget-item-footer fw-columns' . $fw_col_number . ' ';

		}

		echo esc_attr( $fw_class );

	}
}
/* */

/* Sidebars */
if ( !function_exists( 'baxel_insert_sidebar' ) ) {
	function baxel_insert_sidebar( $where ) {

		echo '<div class="sidebar sidebar-' . $where . ' clearfix">';
		dynamic_sidebar( 'baxel_sidebar_' . $where );
		echo '</div>';

	}
}
/* */

/* Author Box */
if ( !function_exists( 'baxel_author_box' ) ) {
	function baxel_author_box() {

		if ( get_theme_mod( 'baxel_show_author_box', 1 ) ) {

			global $post;

			if ( is_single() && isset( $post->post_author ) ) {

				$user_description = get_the_author_meta( 'user_description', $post->post_author );

				if ( $user_description ) {

					$display_name = get_the_author_meta( 'display_name', $post->post_author );

					if ( !$display_name ) {
						$display_name = get_the_author_meta( 'nickname', $post->post_author );
					}

					$user_website = get_the_author_meta( 'url', $post->post_author );
					$user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author ) );

					$author_details = '<div class="author-box-about clearfix">' . esc_attr( baxel_translation( '_About' ) ) . '</div>' . get_avatar( get_the_author_meta( 'user_email' ) , 36 ) . '<div class="author-box-name clearfix">' . $display_name . '</div>';

					$author_details .= '<p>' . wp_kses_post( $user_description ) . '</p>';
					$author_details .= '<div class="author-box-links"><a href="'. $user_posts .'">' . esc_attr( baxel_translation( '_AllByAuthor' ) ) . '</a>';

					if ( $user_website ) {
						$author_details .= '<a href="' . $user_website .'" target="_blank" rel="nofollow">' . esc_attr( baxel_translation( '_AuthorWebsite' ) ) . '</a>';
					}

					$author_details .= '</div>';

					$content = '<div class="author-box clearfix"><div class="author-box-inner' . baxel_apply_layout() . '">' . $author_details . '</div></div>';

					return $content;

				}

			}

		}

	}
}
// Allow HTML in author box
remove_filter( 'pre_user_description', 'wp_filter_kses' );
/* */

/* Assign Menu Warnings */
function baxel_assign_primary_menu() {
	echo '<div class="assign-menu">' . esc_html__( 'Please assign a Primary Menu.', 'baxel' ) . '</div>';
}
/* */

/* Include the TGM_Plugin_Activation class. */
require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

if ( !function_exists( 'baxel_register_plugins' ) ) {
	function baxel_register_plugins() {

		$plugins = array(

			/*
			Contact Form 7
			Instagram Slider Widget
			Regenerate Thumbnails
			Reveal IDs
			Q2W3 Fixed Widget
			Baxel Slider
			*/

			array(
				'name' => 'Contact Form 7',
				'slug' => 'contact-form-7',
				'required' => false
			),

			array(
				'name' => 'Instagram Slider Widget',
				'slug' => 'instagram-slider-widget',
				'required' => false
			),

			array(
				'name' => 'Regenerate Thumbnails',
				'slug' => 'regenerate-thumbnails',
				'required' => false
			),

			array(
				'name' => 'Reveal IDs',
				'slug' => 'reveal-ids-for-wp-admin-25',
				'required' => false
			),

			array(
				'name' => 'Q2W3 Fixed Widget',
				'slug' => 'q2w3-fixed-widget',
				'required' => false
			),

			array(
				'name' => 'Baxel Slider',
				'slug' => 'baxel-slider',
				'source' => get_template_directory() . '/lib/plugins/baxel-slider.zip',
				'required' => false,
			),

		);

		$config = array(
			'id'           => 'baxel',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',

		);

		tgmpa( $plugins, $config );

	}
}
add_action( 'tgmpa_register', 'baxel_register_plugins' );
/* */

/* Translation */
if ( !function_exists( 'baxel_get_terms' ) ) {
	function baxel_get_terms() {

		$terms = array(
			'_Language' => get_bloginfo( 'language' ),
			'_ReadMore' => esc_html__( 'CONTINUE READING', 'baxel' ),
			'_PrevPost' => esc_html__( 'PREVIOUS POST', 'baxel' ),
			'_NextPost' => esc_html__( 'NEXT POST', 'baxel' ),
			'_Keyword' => esc_html__( 'Type keyword to search', 'baxel' ),
			'_Sticky' => esc_html__( 'Sticky', 'baxel' ),
			'_About' => esc_html__( 'ABOUT', 'baxel' ),
			'_AllByAuthor' => esc_html__( 'SEE ALL POSTS', 'baxel' ),
			'_AuthorWebsite' => esc_html__( 'VISIT AUTHOR SITE', 'baxel' ),
			'_By' => esc_html__( 'by', 'baxel' ),
			'_Share' => esc_html__( 'Share', 'baxel' ),
			'_RelatedPosts' => esc_html__( 'RELATED POSTS', 'baxel' ),
			'_Page' => esc_html__( 'Page', 'baxel' ),
			'_404' => esc_html__( 'PAGE NOT FOUND', 'baxel' ),
			'_NothingFound' => esc_html__( 'NOTHING FOUND', 'baxel' ),
			'_BackToTop' => esc_html__( 'Back to Top', 'baxel' ),
			'_SearchResults' => esc_html__( 'Search Results', 'baxel' ),
			'_Tag' => esc_html__( 'Tag', 'baxel' ),
			'_Category' => esc_html__( 'Category', 'baxel' ),
			'_Author' => esc_html__( 'Author', 'baxel' ),
			'_Archives' => esc_html__( 'Archives', 'baxel' ),
			'_Comment' => esc_html__( 'Comment', 'baxel' ),
			'_Comments' => esc_html__( 'Comments', 'baxel' ),
			'_Name' => esc_html__( 'Name', 'baxel' ),
			'_Email' => esc_html__( 'E-mail', 'baxel' ),
			'_MustBeLogged' => esc_html__( 'You must be logged in to post a comment.', 'baxel' ),
			'_Logged' => esc_html__( 'Logged In', 'baxel' ),
			'_LogOut' => esc_html__( 'Log Out', 'baxel' ),
			'_LeaveReply' => esc_html__( 'LEAVE A REPLY', 'baxel' ),
			'_CancelReply' => esc_html__( 'CANCEL REPLY', 'baxel' ),
			'_PostComment' => esc_html__( 'POST COMMENT', 'baxel' ),
			'_At' => esc_html__( 'at', 'baxel' ),
			'_Reply' => esc_html__( 'REPLY', 'baxel' ),
			'_Edit' => esc_html__( 'EDIT', 'baxel' ),
			'_Awaiting' => esc_html__( 'Comment awaiting approval.', 'baxel' ),
		);

		return $terms;

	}
}

if ( !function_exists( 'baxel_translation' ) ) {
	function baxel_translation( $term ) {

		$the_term = 'baxel_translate' . $term;

		foreach ( baxel_get_terms() as $key => $val ) {
			if ( $key == $term ) {
				if ( get_theme_mod( 'baxel_ignore_pot', 1 ) ) {
					$$the_term = get_theme_mod( $the_term, $val );
				} else {
					$$the_term = esc_attr( $val );
				}
				break;
			}
		}

		return $$the_term;

	}
}
/* */

/* Colors */
if ( !function_exists( 'baxel_get_colors' ) ) {
	function baxel_get_colors() {

		$colors = array(
			'_background' => '#d6ddd6',
			'_assistant_one' => '#FFF',
			'_assistant_two' => '#333',
			'_assistant_three' => '#4fc6a6',
			'_logo_text' => '#000',
			'_logo_background' => '#4fc6a6',
			'_menu_background' => '#FFF',
			'_menu_link' => '#000',
			'_menu_link_hover' => '#4fc6a6',
			'_slider_primary' => '#FFF',
			'_slider_secondary' => '#000',
			'_slider_tertiary' => '#4fc6a6',
			'_post_background' => '#FFF',
			'_post_date' => '#999',
			'_post_title' => '#000',
			'_post_content' => '#333',
			'_post_link' => '#4fc6a6',
			'_post_link_hover' => '#60c3d2',
			'_widget_background' => '#FFF',
			'_widget_title' => '#000',
			'_widget_content' => '#999',
			'_widget_link' => '#333',
			'_widget_link_hover' => '#4fc6a6',
			'_footer_background' => '#333',
			'_footer_widget_title' => '#CCC',
			'_footer_content' => '#999',
			'_footer_link' => '#FFF',
			'_footer_link_hover' => '#4fc6a6',
		);

		return $colors;

	}
}

if ( !function_exists( 'baxel_color' ) ) {
	function baxel_color( $color ) {

		$the_color = 'baxel_color' . $color;

		foreach ( baxel_get_colors() as $key => $val ) {
			if ( $key == $color ) {
				$$the_color = get_theme_mod( $the_color, $val );
				break;
			}
		}

		return $$the_color;

	}
}
/* */

/* Output Customize CSS */
if ( !function_exists( 'baxel_rewrite_css' ) ) {
	function baxel_rewrite_css() {

		$baxel_font_primary = get_theme_mod( 'baxel_font_primary', 'Raleway' );
		$baxel_font_secondary = get_theme_mod( 'baxel_font_secondary', 'Raleway' );
		$baxel_font_logotype = '';
		if ( !get_theme_mod( 'baxel_logo_image' ) ) { $baxel_font_logotype =  get_theme_mod( 'baxel_font_logotype', 'Ubuntu_Condensed' ); }

		$baxel_font_size_menu_item = get_theme_mod( 'baxel_font_size_menu_item', 13 );
		$baxel_font_size_post_title = get_theme_mod( 'baxel_font_size_post_title', 20 );
		$baxel_font_size_post_title_mobile = get_theme_mod( 'baxel_font_size_post_title_mobile', 20 );
		$baxel_font_size_post_content = get_theme_mod( 'baxel_font_size_post_content', 13 );
		$baxel_font_size_widget_title = get_theme_mod( 'baxel_font_size_widget_title', 13 );
		$baxel_font_size_widget_post_title = get_theme_mod( 'baxel_font_size_widget_post_title', 13 );

		/* */

		$menuContainerHeight = get_theme_mod( 'baxel_menu_container_height', 70 );
		$maxLogoHeight = get_theme_mod( 'baxel_max_logo_height', 100 );
		if ( $menuContainerHeight < 70 ) { $menuContainerHeight = 70; }

		$baxel_header_style = get_theme_mod( 'baxel_header_style', 'topped_lefted_bboxed' );
		$baxel_opt_LogoPos = substr( $baxel_header_style, 0, 6 );
		$baxel_opt_MenuPos = substr( $baxel_header_style, 7, 6 );
		$baxel_opt_MenuWidth = substr( $baxel_header_style, 14, 6 );

		if ( $baxel_opt_LogoPos == 'lefted' && $maxLogoHeight > $menuContainerHeight ) { $maxLogoHeight = $menuContainerHeight; }

		/* */

		$baxel_color_logo_background = baxel_color( '_logo_background' );
		if ( get_theme_mod( 'baxel_ignore_logo_background', 1 ) ) { $baxel_color_logo_background = baxel_color( '_background' ); }

		/* General */
		$css = '
			body { background-color: ' . esc_attr( baxel_color( '_background' ) ) . '; color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; }
			a,
			a:visited { color: ' . esc_attr( baxel_color( '_post_link' ) ) . '; }
			a:hover { color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }

			input,
			textarea,
			select { border-color: rgba(' . esc_attr( baxel_hex2rgb( baxel_color( '_post_content' ) ) ) . ', 0.2); color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }
			input[type="submit"] { color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; background-color: ' . esc_attr( baxel_color( '_post_link' ) ) . '; }
			input[type="submit"]:hover { color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; background-color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }
			table, th, td, hr { border-color: rgba(' . esc_attr( baxel_hex2rgb( baxel_color( '_post_content' ) ) ) . ', 0.1); }

			.pre-bq { background-color: ' . esc_attr( baxel_color( '_post_link' ) ) . '; color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }
		';

		/* Misc */
		$css .= '
			.nothing-found,
			.page-404 { background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; }
			.filter-bar { background-color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }

			#googleMap { height: ' . esc_attr( get_theme_mod( 'baxel_map_height', 500 ) ) . 'px; }
		';

		/* Post Formats */
		if ( get_theme_mod( 'baxel_gallery_position', 'content' ) == 'iof' && has_post_format( 'gallery' ) ) {
			$css .= '
               	.gallery,
				.tiled-gallery { display: none; }
            ';
		}

		/* Article */
		$css .= '
			article { background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }

			.article-date,
			.article-date:visited { color: ' . esc_attr( baxel_color( '_post_date' ) ) . '; }
			a.article-date:hover { color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }

			.article-title,
			.article-title a,
			.article-title a:visited { color: ' . esc_attr( baxel_color( '_post_title' ) ) . '; }
			.article-title a:hover { color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }

			a.article-author-outer,
			a.article-author-outer:visited { color: ' . esc_attr( baxel_color( '_post_date' ) ) . '; }
			a.article-author-outer:hover { color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }

			.btnReadMore,
			.btnReadMore:visited { color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; border-color: ' . esc_attr( baxel_color( '_post_link' ) ) . '; }
			.btnReadMore:hover { color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; border-color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }

			.sticky-icon { background-color: ' . esc_attr( baxel_color( '_post_link' ) ) . '; color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }

			.post-styleZ,
			.post-styleZ:visited { background-color: ' . esc_attr( baxel_color( '_assistant_one' ) ) . '; color: ' . esc_attr( baxel_color( '_assistant_two' ) ) . '; }
			.post-styleZ:hover,
			.post-styleZ:hover { background-color: ' . esc_attr( baxel_color( '_assistant_three' ) ) . '; color: ' . esc_attr( baxel_color( '_assistant_one' ) ) . '; }

			article .wp-caption p.wp-caption-text { background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }

			.categories-label,
			.pager-only { color: ' . esc_attr( baxel_color( '_post_date' ) ) . '; }
			.category-bar a,
			.category-bar a:visited { color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; }
			.category-bar a:hover { color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }
		';

		if ( !get_theme_mod( 'baxel_show_excerpt_indexed', 1 ) && !get_theme_mod( 'baxel_show_categories_indexed', 1 ) ) {
			$css .= '
				.posts-wrapper .article-content-outer,
				.posts-wrapper .article-content-outer-sidebar,
				.posts-wrapper .article-content-outer-cc2,
				.posts-wrapper .article-content-outer-sidebar-cc2,
				.posts-wrapper .article-content-outer-cc3 {
					padding: 0;
					border: none;
				}
			';
		}

		/* Author Box */
		$css .= '
			.author-box { background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }
			.author-box-about,
			.author-box-name { color: ' . esc_attr( baxel_color( '_post_title' ) ) . '; }
			.author-box-links a,
			.author-box-links a:visited { color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; border-color: ' . esc_attr( baxel_color( '_post_link' ) ) . '; }
			.author-box-links a:hover { color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; border-color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }
		';

		/* Related Posts */
		$css .= '
			.related-posts { background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }
			.related-posts h2 { color: ' . esc_attr( baxel_color( '_post_title' ) ) . '; }
			.related-posts a,
			.related-posts a:visited { color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }
			.related-posts a:hover .post-widget-container { color: ' . esc_attr( baxel_color( '_post_link' ) ) . '; background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }
		';

		/* Post Comments */
		$css .= '
			.comments { background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; }
			h2.comments-title { color: ' . esc_attr( baxel_color( '_post_title' ) ) . '; }
			.commenter-name,
			.commenter-name a,
			.commenter-name a:visited { color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; }
			.comment-date { color: ' . esc_attr( baxel_color( '_post_date' ) ) . '; }
			.comment-edit-link,
			.comment-edit-link:visited,
			.comment-reply-link,
			.comment-reply-link:visited,
			#cancel-comment-reply-link,
			#cancel-comment-reply-link:visited { color: ' . esc_attr( baxel_color( '_post_content' ) ) . '; border-color: ' . esc_attr( baxel_color( '_post_link' ) ) . '; }
			.comment-edit-link:hover,
			.comment-reply-link:hover,
			#cancel-comment-reply-link:hover { color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; border-color: ' . esc_attr( baxel_color( '_post_link_hover' ) ) . '; }
		';

		/* Post Navigation */
		$css .= '
			.post-navi a .post-navi-inner { background-color: ' . esc_attr( baxel_color( '_post_background' ) ) . '; color: ' . esc_attr( baxel_color( '_post_title' ) ) . '; }
			.post-navi a:hover .post-navi-inner { background-color: ' . esc_attr( baxel_color( '_assistant_three' ) ) . '; color: ' . esc_attr( baxel_color( '_assistant_one' ) ) . '; }
		';

		/* Page Navigation */
		$css .= '
			.page-numbers.dots,
			a.page-numbers,
			a.page-numbers:visited { color: ' . esc_attr( baxel_color( '_assistant_two' ) ) . '; }
			a.page-numbers:hover { color: ' . esc_attr( baxel_color( '_assistant_three' ) ) . '; }
			.page-numbers.current { background-color: ' . esc_attr( baxel_color( '_assistant_three' ) ) . '; color: ' . esc_attr( baxel_color( '_assistant_one' ) ) . '; }
			a.next.page-numbers,
			a.prev.page-numbers { background-color: ' . esc_attr( baxel_color( '_assistant_one' ) ) . '; color: ' . esc_attr( baxel_color( '_assistant_three' ) ) . '; }
			a.next.page-numbers:hover,
			a.prev.page-numbers:hover { background-color: ' . esc_attr( baxel_color( '_assistant_two' ) ) . '; color: ' . esc_attr( baxel_color( '_assistant_one' ) ) . '; }
		';

		/* Menu & Header */
		$css .= '
			.mobile-header,
			#sticky-menu-container { background-color: ' . esc_attr( baxel_color( '_menu_background' ) ) . '; }
			.mobile-menu-button,
			.slicknav_menu a,
			.slicknav_menu a:visited,
			.site-menu-outer .assign-menu { color: ' . esc_attr( baxel_color( '_menu_link' ) ) . '; }
			.slicknav_menu a:hover { color: ' . esc_attr( baxel_color( '_menu_link_hover' ) ) . '; }

			.logo-text a,
			.logo-text a:visited,
			.logo-text a:hover { color: ' . esc_attr( baxel_color( '_logo_text' ) ) . '; }
			.sticky-logo-container .logo-text a,
			.sticky-logo-container .logo-text a:visited,
			.sticky-logo-container .logo-text a:hover,
			.mobile-logo-container .logo-text a,
			.mobile-logo-container .logo-text a:visited,
			.mobile-logo-container .logo-text a:hover { color: ' . esc_attr( baxel_color( '_menu_link' ) ) . '; }
			h1.logo-text { font-size: ' . esc_attr( get_theme_mod( 'baxel_font_size_logo', 50 ) ) . 'px; }
			.mobile-header h1.logo-text,
			#sticky-menu h1.logo-text { font-size: 25px; }
		';

		if ( !get_theme_mod( 'baxel_show_sticky_logo', 1 ) ) { $css .= '.sticky-logo-outer { margin: 0; }'; }

		$css .= '
			.site-nav a,
			.site-nav a:visited,
			.header-social .social-menu-item,
			.top-search-button,
			.top-search-touch input,
			.top-search-touch i,
			.top-extra-inner .btn-to-top { color: ' . esc_attr( baxel_color( '_menu_link' ) ) . '; }
			.site-nav a:hover,
			.header-social .social-menu-item:hover,
			.top-search-button:hover,
			.top-extra-inner .btn-to-top:hover { opacity: 1; color: ' . esc_attr( baxel_color( '_menu_link_hover' ) ) . '; }
			.site-nav li ul { background-color: ' . esc_attr( baxel_color( '_menu_background' ) ) . '; border-color: ' . esc_attr( baxel_color( '_menu_link_hover' ) ) . '; }

			.site-top-container,
			.menu-sticky,
			.top-search-touch input { background-color: ' . esc_attr( baxel_color( '_menu_background' ) ) . '; }
			.top-search input { background-color: ' . esc_attr( baxel_color( '_menu_link' ) ) . '; color: ' . esc_attr( baxel_color( '_menu_background' ) ) . '; width: ' . esc_attr( get_theme_mod( 'baxel_top_search_width', 240 ) ) . 'px; }
		';

		if ( $baxel_opt_MenuPos == 'lefted' ) {
			/* Default */
		} else if ( $baxel_opt_MenuPos == 'center' ) {
			$css .= '
				.site-top-container { text-align: center; }
				.site-top-container .top-extra-outer { float: none; display: inline-block; margin-left: 40px; }
			';
		} else if ( $baxel_opt_MenuPos == 'mright' ) {
			$css .= '
				.site-top-container { text-align: right; }
				.site-top-container .top-extra-outer { margin-left: 40px; }
			';
			if ( $baxel_opt_LogoPos == 'lefted' ) {
				$css .= '
					.site-top-container { position: relative; }
					.site-logo-outer { position: absolute; left: 20px; }
				';
			}
		}

		if ( $baxel_opt_LogoPos == 'topped' || $baxel_opt_LogoPos == 'bottom' ) {

			if ( $baxel_opt_LogoPos == 'topped' || ( $baxel_opt_LogoPos == 'bottom' && ( !get_theme_mod( 'baxel_ignore_logo_background', 1 ) || $baxel_color_logo_background != baxel_color( '_background' ) ) ) ) { $css .= '.site-top { margin-bottom: 40px; }'; }

			$css .= '
				.site-logo-outer { display: block; text-align: center; padding: 40px 0 40px 0; background-color: ' . esc_attr( $baxel_color_logo_background ) . '; }
				.site-logo-container { display: inline-block; }

				.site-logo-container img { height: auto; }

				.site-logo-left-handler { display: inline-table; vertical-align: middle; margin: 0; }

				.site-logo-left-handler,
				.top-extra { height: ' . esc_attr( $menuContainerHeight ) . 'px; }
				.site-logo-container img { max-height: ' . esc_attr( $maxLogoHeight ) . 'px; }
			';

		} else if ( $baxel_opt_LogoPos == 'lefted' ) {
			$css .= '
				.site-top { margin-bottom: 40px; }
				.site-logo-outer,
				.site-logo-outer-handler { display: inline-table; vertical-align: middle; margin: 0 40px 0 0; text-align: left; }
				.site-logo-container { display: table-cell; vertical-align: middle; }
				.site-logo-container img { height: auto; }

				.site-logo-outer,
				.site-logo-outer-handler,
				.top-extra { height: ' . esc_attr( $menuContainerHeight ) . 'px; }
				.site-logo-container img { max-height: ' . esc_attr( $maxLogoHeight ) . 'px; }
			';
		}

		$css .= '
			.sticky-logo-outer,
			#sticky-menu .top-extra { height: 50px; }

			.site-top-container { padding-left: 40px; padding-right: 40px; }
		';

		if ( $baxel_opt_MenuWidth == 'bboxed' ) {
			$css .= '.site-top { max-width: 1180px; padding: 0 20px 0 20px; }';
		} else if ( $baxel_opt_MenuWidth == 'fulled' ) {
			$css .= '.site-top { max-width: 100%; padding: 0; }';
		} else if ( $baxel_opt_MenuWidth == 'fboxed' ) {
			$css .= '
				.site-top { max-width: 100%; padding: 0; }

				.site-top-container { max-width: 1180px; margin: auto; padding-left: 20px; padding-right: 20px; }
				.site-top-container-outer { background-color: ' . esc_attr( baxel_color( '_menu_background' ) ) . '; }
			';
		}

		// Header Shadow
		$css .= '.top-sdw { background-color: ' . esc_attr( baxel_color( '_background' ) ) . '; }';
		if ( $baxel_opt_LogoPos == 'lefted' || ( $baxel_opt_LogoPos == 'topped' && $baxel_opt_MenuWidth == 'fboxed' ) ) {
			$css .= '
				.site-top-container-outer { -webkit-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); -moz-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); -o-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); }
			';
		} else if ( $baxel_opt_LogoPos == 'topped' ) {
			$css .= '
				.site-top-container { -webkit-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); -moz-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); -o-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); }
			';
		} else if ( $baxel_opt_MenuWidth == 'fboxed' || $baxel_opt_MenuWidth == 'fulled' ) {
			$css .= '
				.top-sdw { display: inline; background-color: ' . esc_attr( $baxel_color_logo_background ) . '; }
				.site-logo-outer { border-top: 4px solid rgba(0,0,0,0.1); }
			';
		} else {
			$css .= '
				.site-top-container { -webkit-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); -moz-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); -o-box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); box-shadow: 3px 4px 0 0 rgba(0,0,0,0.1); }
				.top-sdw { display: inline; background-color: ' . esc_attr( $baxel_color_logo_background ) . '; }
				.site-logo-outer { border-top: 4px solid rgba(0,0,0,0.1); }
			';
		}

		/* Trigger Slicknav Menu */
		$css .= '
			@media all and (min-width: ' . esc_attr( get_theme_mod( 'baxel_trigger_slick_nav', 960 ) ) . 'px) {

				body { margin-top: 0; }
				#site-menu,
				#site-menu-sticky,
				#sticky-menu { display: block; }
				.mobile-header { display: none; }
				.site-top { margin-top: 0; display: block; }

			}
		';

		/* Slider */
		$css .= '
			.owl-prev,
			.owl-next { color: ' . esc_attr( baxel_color( '_slider_tertiary' ) ) . '; background-color: ' . esc_attr( baxel_color( '_slider_primary' ) ) . '; }
			.owl-dot { background-color: ' . esc_attr( baxel_color( '_slider_primary' ) ) . '; }
			.owl-dot.active { background-color: ' . esc_attr( baxel_color( '_slider_tertiary' ) ) . '; }
			.owl-prev:hover,
			.owl-next:hover { color: ' . esc_attr( baxel_color( '_slider_primary' ) ) . '; background-color: ' . esc_attr( baxel_color( '_slider_tertiary' ) ) . '; }
			.owl-dot:hover { background-color: ' . esc_attr( baxel_color( '_slider_secondary' ) ) . '; }
		';

		if ( !get_theme_mod( 'baxel_slider_dots', 0 ) ) {
			$css .= '
				.owl-dots { display: none; }
				@media all and (min-width: 860px) { .baxel-slider-container .owl-dots { display: none; } }
			';
		}

		$css .= '
			.slide-lens { background-color: rgba(' . esc_attr( baxel_hex2rgb( baxel_color( '_slider_primary' ) ) ) . ', 0.6); }
			.owl-item a .slide-thumbnail-inner,
			.slide-thumbnail-inner { background-color: rgba(' . esc_attr( baxel_hex2rgb( baxel_color( '_slider_primary' ) ) ) . ', 1); color: ' . esc_attr( baxel_color( '_slider_secondary' ) ) . '; }
			.owl-item a:hover .slide-thumbnail-inner { color: ' . esc_attr( baxel_color( '_slider_primary' ) ) . '; background-color: rgba(' . esc_attr( baxel_hex2rgb( baxel_color( '_slider_tertiary' ) ) ) . ', 1); }
			@media all and (min-width: 860px) {
				.owl-item a .slide-thumbnail-inner,
				.slide-thumbnail-inner { background-color: rgba(' . esc_attr( baxel_hex2rgb( baxel_color( '_slider_primary' ) ) ) . ', 0); }
				.owl-item a:hover .slide-thumbnail-inner { background-color: rgba(' . esc_attr( baxel_hex2rgb( baxel_color( '_slider_tertiary' ) ) ) . ', 0); }
				.owl-item a .slide-title { color: ' . esc_attr( baxel_color( '_slider_secondary' ) ) . '; background-color: ' . esc_attr( baxel_color( '_slider_primary' ) ) . '; }
				.owl-item a:hover .slide-title { color: ' . esc_attr( baxel_color( '_slider_primary' ) ) . '; background-color: ' . esc_attr( baxel_color( '_slider_tertiary' ) ) . '; }
			}
		';

		/* Sidebar Widgets */
		$css .= '
			.widget-item { color: ' . esc_attr( baxel_color( '_widget_content' ) ) . '; background-color: ' . esc_attr( baxel_color( '_widget_background' ) ) . '; }
			.widget-item a,
			.widget-item a:visited { color: ' . esc_attr( baxel_color( '_widget_link' ) ) . '; }
			.widget-item a .posts-widget-date { color: ' . esc_attr( baxel_color( '_widget_content' ) ) . '; }
			.widget-item a:hover { color: ' . esc_attr( baxel_color( '_widget_link_hover' ) ) . '; }

			.widget-item h2 { color: ' . esc_attr( baxel_color( '_widget_title' ) ) . '; }
			.post-widget-container,
			.image-widget-title { color: ' . esc_attr( baxel_color( '_widget_link' ) ) . '; background-color: ' . esc_attr( baxel_color( '_widget_background' ) ) . '; }
			a:hover .post-widget-container,
			a:hover .image-widget-title { color: ' . esc_attr( baxel_color( '_widget_background' ) ) . '; background-color: ' . esc_attr( baxel_color( '_widget_link_hover' ) ) . '; }

			h2 a.rsswidget,
			h2 a.rsswidget:visited,
			h2 a.rsswidget:hover { color: ' . esc_attr( baxel_color( '_widget_title' ) ) . '; }
		';

		/* Footer & Footer Widgets */
		$css .= '
			footer { color: ' . esc_attr( baxel_color( '_footer_content' ) ) . '; background-color: ' . esc_attr( baxel_color( '_footer_background' ) ) . '; }
			footer a,
			footer a:visited { color: ' . esc_attr( baxel_color( '_footer_link' ) ) . '; }
			footer a:hover { color: ' . esc_attr( baxel_color( '_footer_link_hover' ) ) . '; }

			.widget-item-footer input,
			.widget-item-footer textarea,
			.widget-item-footer select { background-color: ' . esc_attr( baxel_color( '_footer_background' ) ) . '; color: ' . esc_attr( baxel_color( '_footer_link' ) ) . '; border-color: ' . esc_attr( baxel_color( '_footer_link' ) ) . '; }
			.widget-item-footer input[type="submit"] { background-color: ' . esc_attr( baxel_color( '_footer_link_hover' ) ) . '; color: ' . esc_attr( baxel_color( '_footer_link' ) ) . '; }
			.widget-item-footer input[type="submit"]:hover { background-color: ' . esc_attr( baxel_color( '_footer_link' ) ) . '; color: ' . esc_attr( baxel_color( '_footer_link_hover' ) ) . '; }
			.widget-item-footer table, .widget-item-footer th, .widget-item-footer td, .widget-item-footer hr { border-color: rgba(' . esc_attr( baxel_hex2rgb( baxel_color( '_footer_content' ) ) ) . ', 0.1); }

			.widget-item-footer h2 { color: ' . esc_attr( baxel_color( '_footer_widget_title' ) ) . '; }

			.widget-item-footer a .posts-widget-date { color: ' . esc_attr( baxel_color( '_footer_content' ) ) . '; }

			.widget-item-footer .post-widget-container,
			.widget-item-footer .image-widget-title { color: ' . esc_attr( baxel_color( '_footer_background' ) ) . '; background-color: ' . esc_attr( baxel_color( '_footer_link' ) ) . '; }
			.widget-item-footer a:hover .post-widget-container,
			.widget-item-footer a:hover .image-widget-title { color: ' . esc_attr( baxel_color( '_footer_link' ) ) . '; background-color: ' . esc_attr( baxel_color( '_footer_link_hover' ) ) . '; }

			.widget-item-footer h2 a.rsswidget,
			.widget-item-footer h2 a.rsswidget:visited,
			.widget-item-footer h2 a.rsswidget:hover { color: ' . esc_attr( baxel_color( '_footer_widget_title' ) ) . '; }

			.instagram-label { background-color: ' . esc_attr( baxel_color( '_footer_link_hover' ) ) . '; color: ' . esc_attr( baxel_color( '_footer_link' ) ) . '; }
		';

		/* Fonts */
		foreach ( baxel_font_labels() as $key => $val ) {
			$add_underscore = str_replace( ' ', '_', $key );
			if ( $add_underscore == $baxel_font_primary ) { $font_primary = 'font-family: "' . $key . '", ' . $val . ';'; }
			if ( $add_underscore == $baxel_font_secondary ) { $font_secondary = 'font-family: "' . $key . '", ' . $val . ';'; }
			if ( $add_underscore == $baxel_font_logotype ) { $font_logotype = 'font-family: "' . $key . '", ' . $val . ';'; }
		}

		$css .= '
			.baxel-font-1,
			.site-nav,
			.slicknav_menu,
			.slide-title,
			.article-title,
			.author-box-about,
			.author-box-name,
			.btnReadMore,
			.related-posts h2,
			.comments-title,
			.comment-reply-title,
			.page-numbers,
			input[type="submit"],
			input.button,
			button,
			.widget-item h2,
			.widget-item-footer h2,
			.image-widget-title,
			.article-date-outer,
			.article-author-outer,
			.post-styleZ-date,
			.posts-widget-date,
			.post-widget-date,
			.post-navi-label,
			.comment-date,
			.comment-reply-link,
			.comment-edit-link,
			.author-box-links {
				' . $font_primary . '
			}

			.baxel-font-2,
			body,
			input,
			textarea,
			.slide-teaser {
				' . $font_secondary . '
			}
		';

		if ( $baxel_font_logotype ) { $css .= '.logo-text { ' . $font_logotype . ' }'; }

		$css .= '
			.site-nav { font-size: ' . esc_attr( $baxel_font_size_menu_item ) . 'px; }
			.article-title { font-size: ' . esc_attr( $baxel_font_size_post_title_mobile ) . 'px; }
			@media all and (min-width: 960px) { .main-container .article-title { font-size: ' . esc_attr( $baxel_font_size_post_title ) . 'px; } }
			@media all and (min-width: 1160px) { .main-container-sidebar .article-title { font-size: ' . esc_attr( $baxel_font_size_post_title ) . 'px; } }
			.article-pure-content { font-size: ' . esc_attr( $baxel_font_size_post_content ) . 'px; }
			.widget-item h2,
			.widget-item-footer h2,
			.image-widget-title { font-size: ' . esc_attr( $baxel_font_size_widget_title ) . 'px; }
			.posts-widget-title,
			.widget_categories,
			.widget_archive,
			.widget_nav_menu,
			.widget_meta,
			.widget_pages,
			.widget_recent_comments li a,
			.widget_recent_entries { font-size: ' . esc_attr( $baxel_font_size_widget_post_title ) . 'px; }
		';

		return $css;

	}
}
/* */
