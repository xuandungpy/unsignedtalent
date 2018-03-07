<?php
class jvbpd_theme_admin {

	public static $instance = null;
	const NAV_FIELD_KEY = 'jvbpd_nav_option';
	public $option_format = 'jvbpd_%s_featured';
	public $notices = Array();

	public function __construct() {

		// Include FIles
		$this->load_files();

		// Uploader Memory Check
		$this->memoryCheck();

		// Display admin notice
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		// Custom user panel
		add_action( 'admin_init', array( $this, 'customBackendUsersPage' ) );

		// Custom Category Marker
		add_action( 'admin_enqueue_scripts', Array($this, 'admin_enqueue_callback' ));

		// Navigation Additional More Variables
		add_action( 'init', array( $this, 'customNavFields' ) );

	}

	public function load_files() {
		get_template_part( 'library/classes/edit_custom_walker');
		get_template_part( 'library/admin/class', 'init-helper' );
	}

	public function load_template( $args=Array(), $param=Array() ) {
		$options = shortcode_atts(
			Array(
				'once' => true,
				'ext' => '.php',
				'path' => JVBPD_ADM_DIR,
				'sub' => false,
				'name' => '',
			), $args
		);

		if( is_array( $param ) ) {
			extract( $param );
		}

		$filePath = Array();
		$filePath[] = $options[ 'path' ];

		if( !empty( $options[ 'sub' ] ) ) {
			$filePath[] = $options[ 'sub' ];
		}

		$filePath[] = $options[ 'name' ];
		$fileName = sprintf( '%1$s%2$s', join( '/', $filePath ), $options[ 'ext' ] );

		if( file_exists( $fileName ) ) {
			if( $options[ 'once' ] ) {
				require_once( $fileName );
			}else{
				require( $fileName );
			}
		}
	}

	public function customCategoryTerm(){
		add_action( 'category_edit_form_fields', Array($this,'edit_featured_term'), 10, 2);
		add_action( 'category_add_form_fields', Array($this, 'add_featured_term'));
		add_action( 'created_category', Array($this, 'save_featured_term'), 10, 2);
		add_action( 'edited_category', Array($this, 'save_featured_term'), 10, 2);
		add_action( 'deleted_term_taxonomy', Array($this, 'remove_featured_term'));
		add_filter( 'manage_edit-category_columns' , Array($this, 'featured_term_columns'));
		add_filter( 'manage_category_custom_column' , Array($this, 'manage_featured_term_columns'), 10, 3);
	}

	public function customBackendUsersPage() {}

	public function customNavFields(){
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'apparence_menu_define_vars' ) );
		add_action( 'wp_update_nav_menu_item', array( $this, 'apparence_menu_save_vars' ), 10, 3 );
		add_action( 'wp_edit_nav_menu_walker', array( $this, 'apparence_menu_walker' ), 10, 2 );
		add_action( 'wp_content_panel_nav_menu_item', array( $this, 'apparence_menu_append_option' ), 10, 2 );
	}

	public function admin_notices() {

		if( empty( $this->notices ) )
			return false;

		foreach( $this->notices as $notice_id => $arrNotice ) {

			switch( $arrNotice[ 'type' ] ) {
				case 'error' : $strNoticeType = 'notice-error'; break;
				case 'warning' : $strNoticeType = 'notice-warning'; break;
				case 'warning-lg' : $strNoticeType = 'notice-warning-lg'; break;
				case 'success' : $strNoticeType = 'notice-success'; break;
				case 'info' : default : $strNoticeType = 'notice-info';
			}

			printf(
				'<div class="jvbpd-notice %1$s %2$s"><p>%3$s</p></div>',
				$strNoticeType,
				$notice_id,
				$arrNotice[ 'comment' ]
			);
		}

	}

	public function addNotice( $err_id='', $typeMessage='', $strMessage='' ) {
		$this->notices[ $err_id ] = Array(
			'type' => $typeMessage,
			'comment' => $strMessage,
		);
	}

	public function removeNotice( $err_id ) {
		unset( $this->notices[ $err_id ] );
	}

	public function memoryCheck() {

		$intPHP_Memory = intVal( ini_get( 'memory_limit' ) );
		$intPHP_Memory_Allow = 128;

		$intWP_Memory = defined( 'WP_MEMORY_LIMIT' ) ? intVal( WP_MEMORY_LIMIT ) : 0;

		if( is_multisite() ){
			$intWP_Memory_Allow = 64;
		}else{
			$intWP_Memory_Allow = 40;
		}

		if(
			( $intPHP_Memory >= $intPHP_Memory_Allow ) &&
			( $intWP_Memory >= $intWP_Memory_Allow )
		) return false;

		$strDetailLink = sprintf(
			'<br><a href="%1$s" target="_blank">%2$s</a>',
			esc_url( 'wordimpress.com/how-to-easily-increase-wordpress-and-phps-memory-limit/' ),
			esc_html__( "How to increase", 'jvfrmtd' )
		);

		$this->addNotice(
			'memory_limit_error',
			'warning-lg',
			sprintf(
				__( '<strong>Javo Themes</strong><br>%5$sPHP Memory: %1$s( Recommended: %2$s ), WordPress Memory: %3$s( Recommended: %4$s )%6$s', 'jvfrmtd' ),
				$intPHP_Memory,
				$intPHP_Memory_Allow,
				$intWP_Memory,
				$intWP_Memory_Allow,
				__( "Your max uploading size is less than 128MB. It may cause some problems. Please increase your uploading size.", 'jvfrmtd' ) . '<br>',
				$strDetailLink
			)
		);
	}

	public function admin_enqueue_callback(){
		if ( function_exists('wp_enqueue_media') ) {
			wp_enqueue_media();
		}
	}

	public function getFeatured( $term_id=0 ) {
		return get_option( sprintf( $this->option_format, $term_id ) );
	}

	public function setFeatured( $term_id=0, $value='' ) {
		return update_option( sprintf( $this->option_format, $term_id ), $value );
	}

	public function removeFeatured( $term_id=0 ) {
		return delete_option( sprintf( $this->option_format, $term_id ) );
	}

	public function add_featured_term( $tag )
	{
		?>
		<div class="form-field jv-uploader-wrap">
			<label for="jvbpd_category_featured"><?php esc_html_e('Category Featured Image', 'jvfrmtd' );?></label>
			<img style="max-width:80%;"><br>
			<input type="text" name="jvbpd_category_featured" id="jvbpd_category_featured" data-id class="hidden">
			<button type="button" class="button button-primary upload" data-featured-field="[name='jvbpd_category_featured']"><?php esc_html_e('Change', 'jvfrmtd' );?></button>
			<button type="button" class="button remove"><?php esc_html_e( 'Remove' , 'jvfrmtd' );?></button>
		</div>
		<?php
	}

	public function edit_featured_term($tag, $taxonomy) {
		$jvbpd_featured		= $this->getFeatured( $tag->term_id );
		$jvbpd_featured_src	= wp_get_attachment_image_src( $jvbpd_featured );
		$jvbpd_featured_src	= $jvbpd_featured_src[0];
		?>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="jvbpd_category_featured"><?php esc_html_e('Category Featured Image', 'jvfrmtd' );?></label>
			</th>
			<td class="jv-uploader-wrap">
				<img src="<?php echo esc_url_raw( $jvbpd_featured_src );?>" style="max-width:80%;"><br>
				<input type="text" name="jvbpd_category_featured" id="jvbpd_category_featured" data-id value="<?php echo esc_attr( $jvbpd_featured ); ?>" class="hidden">
				<button type="button" class="button button-primary upload" data-featured-field="[name='jvbpd_category_featured']"><?php esc_html_e('Change', 'jvfrmtd' );?></button>
				<button type="button" class="button remove"><?php esc_html_e( 'Remove' , 'jvfrmtd' );?></button>
			</td>
		</tr>
		<?php
	}

	public function save_featured_term($term_id, $tt_id) {
		if (!$term_id) return;

		if (isset($_POST['jvbpd_category_featured'])){
			$this->setFeatured( $term_id, $_POST['jvbpd_category_featured'] );
		}
	}

	public function remove_featured_term( $id ) {
		$this->removeFeatured( $id );
	}

	public function featured_term_columns($category_columns) {
		$new_columns		= array(
			'cb'			=> '<input type="checkbox">'
			, 'name'		=> esc_html__('Name', 'jvfrmtd' )
			, 'description'	=> esc_html__('Description', 'jvfrmtd' )
			, 'featured'	=> esc_html__('Featured Preview', 'jvfrmtd' )
			, 'slug'		=> esc_html__('Slug', 'jvfrmtd' )
			, 'posts'		=> esc_html__('Items', 'jvfrmtd' )
		);
		return $new_columns;
	}

	public function manage_featured_term_columns($output, $column_name, $cat_id){
		$jvbpd_featured		= $this->getFeatured( $cat_id );
		$jvbpd_featured_src	= wp_get_attachment_image_src( $jvbpd_featured, 'thumbnail' );
		$jvbpd_featured_src	= $jvbpd_featured_src[0];

		switch ($column_name) {
			case 'featured':

				if(!empty($jvbpd_featured)){
					$output .= '<img src="'.$jvbpd_featured_src.'" style="max-width:100%;" alt="">';
				}
			break;
		};
		return $output;
	}

	public function apparence_menu_define_vars( $_mnu_item ){
		if( ! isset( $_mnu_item->ID ) ){
			return $_mnu_item;
		}
		$_mnu_item->anchor = get_post_meta( $_mnu_item->ID, '_menu_item_anchor', true );
		$_mnu_item->scrollspy = get_post_meta( $_mnu_item->ID, '_menu_item_scrollspy', true );
		$_mnu_item->nav_icon = get_post_meta( $_mnu_item->ID, '_menu_item_icon', true );
		$_mnu_item->wide_menu = get_post_meta( $_mnu_item->ID, '_wide_menu', true );
		$_mnu_item->nav_bg = get_post_meta( $_mnu_item->ID, '_nav_bg', true );
		$_mnu_item->wide_menu_category = get_post_meta( $_mnu_item->ID, '_wide_menu_category', true );
		return $_mnu_item;
	}

	public function apparence_menu_walker( $walker_name, $menu_id ){
		return 'Walker_Nav_Menu_Edit_Custom';
	}

	public function apparence_menu_save_vars( $_mnu_ID, $_mnu_item_ID, $args  ){
		$arrOptions = Array(
			'_menu_item_anchor', '_menu_item_scrollspy', '_menu_item_icon', '_wide_menu', '_nav_bg', '_wide_menu_category',
		);
		foreach( $arrOptions as $optionName ) {
			$strValue = isset(  $_POST[ $optionName ][ $_mnu_item_ID ] ) ? $_POST[ $optionName ][ $_mnu_item_ID ] : false;
			update_post_meta( $_mnu_item_ID, $optionName, $strValue );
		}
	}

	public function getNavField( $item_id=0, $item_field_key=''  ){
		 return sprintf( '%s[%s]', $item_field_key, $item_id );
	}

	public function apparence_menu_append_option( $item, $item_id=0 ) {
		require( JVBPD_ADM_DIR . '/templates/part-edit-nav-custom-field.php' );
	}

	public static function getInstance() {
		if( is_null( self::$instance ) )  {
			self::$instance = new self;
		}
		return self::$instance;
	}
}
if( ! function_exists( 'jvbpd_admin' ) ) {
	function jvbpd_admin() {
		return jvbpd_theme_admin::getInstance();
	}
	jvbpd_admin();
}