<?php
$fitline_args = array_merge(
	array(
		'style'      => 'normal',
		'class'      => '',
		'ajax'       => false,
		'post_types' => '',
	),
	(array) get_query_var( 'fitline_search_args' )
);
?><div class="search_wrap search_style_<?php echo esc_attr( $fitline_args['style'] ) . ( ! empty( $fitline_args['class'] ) ? ' ' . esc_attr( $fitline_args['class'] ) : '' ); ?>">
	<div class="search_form_wrap">
		<form role="search" method="get" class="search_form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="hidden" value="<?php
				if ( ! empty( $args[ 'post_types' ] ) ) {
					echo esc_attr( is_array( $args[ 'post_types' ] ) ? join( ',', $args[ 'post_types' ] ) : $args[ 'post_types' ] );
				}
			?>" name="post_types">
			<input type="text" class="search_field" placeholder="<?php esc_attr_e( 'Search', 'fitline' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
			<button type="submit" class="search_submit icon-search"></button>
		</form>
	</div>
</div>
