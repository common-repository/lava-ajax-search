<?php
if( ! isset( $LAS_PARAM ) ) {
	return false;
}

$strFormCSS = '';
$isStripForm = isset( $LAS_PARAM[ 'strip_form' ] ) ? (boolean) $LAS_PARAM[ 'strip_form' ] === true : false;

if( false !== $LAS_PARAM[ 'height' ] ) {
	$strFormCSS = sprintf( 'style="height:%spx;"', $LAS_PARAM[ 'height' ] );
} ?>

<div class="lava-ajax-search-form-wrap">
	<?php
	if( ! $isStripForm ) {
		printf( '<form method="get" action="%1$s" %2$s>', esc_url( home_url( '/' ) ), $strFormCSS );
	}

	$strInputAttributes = '';
	$inputAttributes = Array(
		'type' => 'text',
		'name' => $LAS_PARAM['field_name'],
		'value' => $LAS_PARAM['default_value'],
		'autocomplete' => 'off',
		'placeholder' => $LAS_PARAM['placeholder'],
		'data-search-input' => '',
	);

	if('1' === $LAS_PARAM['main']) {
		$inputAttributes['placeholder'] = lava_ajaxSearch()->admin->get_settings('search_page_placeholder');
	}

	if(null !== $LAS_PARAM['results_target']) {
		$inputAttributes['data-results-target'] = $LAS_PARAM['results_target'];
	}

	$inputAttributes = apply_filters('Lava/ajax_search/render/input/attritues', $inputAttributes, $LAS_PARAM);

	foreach($inputAttributes as $attribute_key => $attribute_val) {
		$strInputAttributes .= sprintf(' ' . '%1$s="%2$s"', $attribute_key, $attribute_val);
	}
	$strInputAttributes .= ' ' . $strFormCSS;
	do_action('Lava/ajax_search/render/input/before'); ?>
	<input <?php echo $strInputAttributes; ?>>
	<?php
	if( $LAS_PARAM[ 'submit_button' ] ) { ?>
		<button type="submit"><?php esc_html_e( "Search", 'lvbp-ajax-search' ); ?></button>
		<?php
	}
	do_action('Lava/ajax_search/render/input/after');
	if( ! $isStripForm ) {
		printf( '</form>' );
	} ?>
	<div class="actions">
		<div class="loading">
			<i class="fa fa-spin fa-spinner"></i>
		</div>
		<div class="clear hidden">
			<i class="fa fa-close"></i>
		</div>
	</div>
</div>