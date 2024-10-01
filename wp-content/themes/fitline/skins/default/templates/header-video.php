<?php
/**
 * The template to display the background video in the header
 *
 * @package FITLINE
 * @since FITLINE 1.0.14
 */
$fitline_header_video = fitline_get_header_video();
$fitline_embed_video  = '';
if ( ! empty( $fitline_header_video ) && ! fitline_is_from_uploads( $fitline_header_video ) ) {
	if ( fitline_is_youtube_url( $fitline_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $fitline_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php fitline_show_layout( fitline_get_embed_video( $fitline_header_video ) ); ?></div>
		<?php
	}
}
