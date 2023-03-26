<?php
$baxel_show_share = get_theme_mod( 'baxel_show_share', 1 );
if ( is_page() ) {
	$baxel_show_share = get_theme_mod( 'baxel_show_share_page', 1 );
}
$meta_share = get_post_meta( get_the_ID(), 'baxel-share-meta-box-checkbox', true );
if ( $meta_share ) {
	$baxel_show_share = 0;
}
?>

<?php if ( $baxel_show_share /*&& ( is_single() || is_page() )*/ ) {
	$baxel_imagepath = baxel_get_the_first_image(); ?>
	<div class="baxel_widget_social">
    	<div class="categories-label"><?php echo esc_attr( baxel_translation( '_Share' ) ); ?>:</div>
        <ul class="clearfix">
            <li class="share-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li class="share-twitter"><a href="https://twitter.com/home?status=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li class="share-google"><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>              
            <?php			                                
            if ( has_post_thumbnail() ) {				                
                $baxel_thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
				$pinterest_path = $baxel_thumb_url[0];				
			} else {                        
                if ( $baxel_imagepath ) { $pinterest_path = $baxel_imagepath; } else { $pinterest_path = 0; }				
			}			
			if ( $pinterest_path ) { ?>            
            <li class="share-pinterest"><a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?><?php echo esc_attr( '&media=' ) . esc_url( $pinterest_path ) . esc_attr( '&description=' ) ?>" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>            
			<?php } ?>
        </ul>
    </div>    
<?php } ?>