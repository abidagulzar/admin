<?php

$sh_FooterWidgets = get_theme_mod( 'baxel_show_footer_widgets', 1 );
$sh_FooterBTT = get_theme_mod( 'baxel_show_to_top', 1 );
$sh_FooterSocial = get_theme_mod( 'baxel_show_footer_social', 1 );
$copyrightText = get_theme_mod( 'baxel_copyright_text', '2017 Baxel. All rights reserved.' );
$instagramShortcode = get_theme_mod( 'baxel_instagram_shortcode', '' );

?>

	<?php if ( $sh_FooterWidgets || $sh_FooterBTT || $sh_FooterSocial || $instagramShortcode || $copyrightText ) { ?>
    <div id="footer-box-outer" class="footer-box-outer">
        <footer class="clearfix">  
        
        	<?php /* Instagram Slider Widget */
			if ( $instagramShortcode && get_theme_mod( 'baxel_instagram_position_top', 0 ) ) {
				
				echo '<div class="instagram-label">' . esc_attr( get_theme_mod( 'baxel_instagram_label', 'INSTAGRAM FEED' ) ) . '</div>';
				echo do_shortcode( $instagramShortcode );
				
			}
			/* */ ?>        
                
			<?php if ( is_active_sidebar( 'baxel_footer_widgets' ) && $sh_FooterWidgets ) {
                
                ob_start( 'baxel_compress' ); ?>
                
                <div class="footer-box-inner clearfix">                                            
                    <div class="footer-widget-area">
                        <div class="footer-widget-area-inner<?php if ( get_theme_mod( 'baxel_footer_widgets_column', '3col' ) == '2col' ) { echo '-col2'; } else if ( get_theme_mod( 'baxel_footer_widgets_column', '3col' ) == '4col' ) { echo '-col4'; } ?> clearfix"><?php dynamic_sidebar( 'baxel_footer_widgets' ); ?></div>								
                    </div>                    
                </div>
            
            <?php ob_end_flush(); } ?>
            
            <?php
            global $baxel_social_show;
			if ( $copyrightText && ( !get_theme_mod( 'baxel_show_footer_social', 1 ) || !$baxel_social_show ) ) { $sh_FooterBTT = 0; }
			?>
            
            <?php if ( $sh_FooterWidgets || $sh_FooterBTT || $sh_FooterSocial || $copyrightText ) { ?>
            <div class="footer-bottom-outer<?php if ( !is_active_sidebar( 'baxel_footer_widgets' ) || !$sh_FooterWidgets ) { echo ' fbo-wo-w'; } ?>">
                <div class="footer-bottom clearfix">
                	<div class="footer-text"><?php echo wp_kses_post( $copyrightText ); ?></div><div class="footer-btt-outer"><?php if ( $sh_FooterBTT ) { ?><a href="javascript:void(0);" class="btn-to-top"><?php echo esc_attr( baxel_translation( '_BackToTop' ) ); ?><i class="fa fa-caret-up"></i></a><?php } ?></div><?php echo baxel_insert_social_icons( 'footer-social' ); ?>
                </div>
            </div>
            <?php } ?>
            
            <?php /* Instagram Slider Widget */
			if ( $instagramShortcode && !get_theme_mod( 'baxel_instagram_position_top', 0 ) ) {
				
				echo '<div class="instagram-label">' . esc_attr( get_theme_mod( 'baxel_instagram_label', 'INSTAGRAM FEED' ) ) . '</div>';
				echo do_shortcode( $instagramShortcode );
				
			}
			/* */ ?>
                        
        </footer>
    </div>
    <?php } ?>
        
<?php wp_footer(); ?>
</body>
</html>