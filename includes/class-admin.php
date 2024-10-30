<?php

class Lava_Ajax_Search_Admin {

	const GROUPKEY_FORMAT = 'lava_bp_%s_search';
	public $post_type = 'post';

	public function __construct() {}

	public function register(){
		$this->setVariables();
		$this->register_hooks();
	}

	public function setVariables() {
		$this->optionGroup = sprintf( self::GROUPKEY_FORMAT, $this->post_type );
		$this->options = get_option( $this->getOptionFieldName() );
	}

	public function register_hooks() {
		add_action( 'admin_init', Array( $this, 'register_options' ) );
		//add_filter( "lava_{$this->post_type}_admin_tab"	, Array( $this, 'add_addons_tab' ) );
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	public function add_addons_tab( $args ) {
		return wp_parse_args(
			Array(
				'bp_search'		=> Array(
					'label'		=> __( "Ajax Search", 'lvbp-ajax-search' ),
					'group'	=> $this->optionGroup,
					'file'		=> lava_ajaxSearch()->template_path . '/template-admin-index.php',
				)
			), $args
		);
	}

	public function register_menu() {
		add_options_page( 'Lava ajax search settings', 'Lava Ajax Search', 'manage_options', 'lava-ajax-search', array( $this, 'option_page' ) );
	}

	public function option_page() {
		lava_ajaxSearch()->template->load_template( Array( 'file' => 'admin-index' ) );
	}

	public function register_options() {
		add_action('current_screen', Array($this, 'current_screen'));
		register_setting( $this->optionGroup , $this->getOptionFieldName() );
	}

	public function current_screen( $option_name=false ){
		if('settings_page_lava-ajax-search' == get_current_screen()->id) {
			add_action('admin_enqueue_scripts', Array($this, 'settings_page_enqueue'));
		}
	}

	public function settings_page_enqueue() {
		$arrEnqueues = Array(
			'styles' => Array(
				'backend.css' => Array( 'ver' => '1.0.0' ),
			),
			'scripts' => Array(
				'backend.js' => Array( 'ver' => '1.0.0' ),
			),
		);
		if( !empty( $arrEnqueues ) ) {
			foreach( $arrEnqueues['scripts'] as $fileName => $fileMeta ) {
				wp_register_script( lava_ajaxSearch()->template->getEnqueuehandle($fileName), lava_ajaxSearch()->assets_url . 'js/' . $fileName, array( 'jquery' ), $fileMeta[ 'ver' ], true );
			}
			foreach( $arrEnqueues['styles'] as $fileName => $fileMeta ) {
				wp_enqueue_style( lava_ajaxSearch()->template->getEnqueuehandle( $fileName ), lava_ajaxSearch()->assets_url . 'css/' . $fileName );
			}
		}
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script(lava_ajaxSearch()->template->getEnqueuehandle('backend.js'));
	}

	public function getOptionFieldName( $option_name=false ){    // option field name

		$strFieldName = $this->optionGroup . '_param';

		if( $option_name )
			$strFieldName = sprintf( '%1$s[%2$s]', $strFieldName, $option_name );

		return $strFieldName;
	}

	public function get_settings( $option_key, $default=false ) {
		if( array_key_exists( $option_key, (Array) $this->options ) )
			if( $value = $this->options[ $option_key ] )
				$default = $value;
		return $default;
	}
}