<?php

class jvbpd_custom_nav {

	public static $instance = null;

	public function __construct() {
		$this->registerHooks();
	}

	public function getAppendMenus() {
		return Array(
			array(
				'name' => __( 'My Menu', 'jvfrmtd' ),
				'slug' => 'my_menu',
				'link' => "#"
			),
			array(
				'name' => __( 'My Notifications', 'jvfrmtd' ),
				'slug' => 'my_notifications',
				'link' => "#"
			),
			array(
				'name' => __( 'Add New Button', 'jvfrmtd' ),
				'slug' => 'add_new_button',
				'link' => "#"
			),
			array(
				'name' => __( 'Right sidebar opener', 'jvfrmtd' ),
				'slug' => 'right_sidebar_opener',
				'link' => "#"
			),
			array(
				'name' => __( 'Social Link', 'jvfrmtd' ),
				'slug' => 'socal_link',
				'link' => "#"
			),
			array(
				'name' => __( 'Search', 'jvfrmtd' ),
				'slug' => 'search_in_nav',
				'link' => "#"
			),
		);
	}

	public function registerHooks() {
		if( is_admin() ) {
			add_action( 'load-nav-menus.php', array( $this, 'add_nav_menu_meta_box' ) );
		}
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'setup_nav_menu_item' ), 12, 1 );
	}

	public function add_nav_menu_meta_box() {
		add_meta_box( 'custom-javo-nav-menu', __( 'Javo', 'jvfrmtd' ), array( $this, 'nav_menu_meta_box' ), 'nav-menus', 'side', 'default' );
	}

	public function nav_menu_meta_box() {
		global $nav_menu_selected_id;

		$walker = new jvbpd_Nav_Menu_Checklist( false );
		$args   = array( 'walker' => $walker );

		$post_type_name = 'javo';

		$tabs = array();

		$menu_items = $this->getAppendMenus();

		$menu_items[] = array(
			'name' => __( 'Login', 'jvfrmtd' ),
			'slug' => 'login',
			'link' => '#'
		);
		$menu_items[] = array(
			'name' => __( 'Logout', 'jvfrmtd' ),
			'slug' => 'logout',
			'link' => "#"
		);
		$menu_items[] = array(
			'name' => __( 'Register', 'jvfrmtd' ),
			'slug' => 'register',
			'link' => "#"
		);

		$menu_items = apply_filters( 'jvbpd_nav_menu_items', $menu_items );

		$page_args = array();
		if (!empty($menu_items)) {
			foreach ( $menu_items as $item ) {
				$item_name = '';

				$item_name = preg_replace( '/([.0-9]+)/', '', $item['name'] );
				$item_name = trim( strip_tags( $item_name ) );

				$page_args[ $item['slug'] ] = (object) array(
					'ID'             => -1,
					'post_title'     => $item_name,
					'post_author'    => 0,
					'post_date'      => 0,
					'post_excerpt'   => $item['slug'],
					'post_type'      => 'page',
					'post_status'    => 'publish',
					'comment_status' => 'closed',
					'guid'           => $item['link']
				);
			}

		} else {
			_e( 'No items available here for the moment' , 'jvfrmtd' );
			return;
		}
		$tabs['pages']  = $page_args;
		?>

		<div id="jvbpd-menu" class="posttypediv">
			<div id="tabs-panel-posttype-<?php echo esc_attr( $post_type_name ); ?>-loggedin" class="tabs-panel tabs-panel-active">
				<ul id="jvbpd-menu-checklist-loggedin" class="categorychecklist form-no-clear">
					<?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $tabs['pages'] ), 0, (object) $args );?>
				</ul>
			</div>
			<p class="button-controls">
				<span class="add-to-menu">
					<input type="submit"<?php if ( function_exists( 'wp_nav_menu_disabled_check' ) ) : wp_nav_menu_disabled_check( $nav_menu_selected_id ); endif; ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu', 'jvfrmtd' ); ?>" name="add-custom-menu-item" id="submit-jvbpd-menu" />
					<span class="spinner"></span>
				</span>
			</p>
		</div><!-- /#jvbpd-menu -->

		<?php
	}

	public function setup_nav_menu_item( $menu_item ) {
		if ( is_admin() ) {
			return $menu_item;
		}
		if ( ! isset( $menu_item->classes ) || ! is_array( $menu_item->classes ) ) {
			return $menu_item;
		}
		$css_target = preg_match('/\sjvbpd-(.*)-nav/', implode(' ', $menu_item->classes), $matches);

		if ( empty( $matches[1] ) ) {
			return $menu_item;
		}

		switch ( $matches[1] ) {
			case 'login' :
				if ( is_user_logged_in() ) {
					$menu_item->_invalid = true;
				} else {
					$menu_item->url = wp_login_url();
					$menu_item->classes = "jvbpd-show-login";
				}

				break;

			case 'logout' :
				if ( ! is_user_logged_in() ) {
					$menu_item->_invalid = true;
				} else {
					$menu_item->url = wp_logout_url( home_url( '/' ) );
				}

				break;

			case 'register' :
				if ( is_user_logged_in() ) {
					$menu_item->_invalid = true;
				} else {
					$menu_item->url = wp_registration_url();
				}

				break;

			default:
				break;
		}

		$menu_item = apply_filters('jvbpd_setup_nav_item_' . $matches[1], $menu_item );

		if ( empty( $menu_item->url ) ) {
			$menu_item->_invalid = true;
		}

		return $menu_item;
	}
	public static function getInstance() {
		if( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

if( !function_exists( 'jvbpd_customNav' ) ) {
	function jvbpd_customNav() {
		return jvbpd_custom_nav::getInstance();
	}
	add_action( 'init', 'jvbpd_customNav' );
}

class jvbpd_Nav_Menu_Checklist extends Walker_Nav_Menu {

	public function __construct( $fields = false ) {
		if ( $fields ) {
			$this->db_fields = $fields;
		}
	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class='children'>\n";
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent</ul>";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_nav_menu_placeholder;

		$_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
		$possible_object_id = isset( $item->post_type ) && 'nav_menu_item' == $item->post_type ? $item->object_id : $_nav_menu_placeholder;
		$possible_db_id = ( ! empty( $item->ID ) ) && ( 0 < $possible_object_id ) ? (int) $item->ID : 0;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$output .= $indent . '<li>';
		$output .= '<label class="menu-item-title">';
		$output .= '<input type="checkbox" class="menu-item-checkbox';

		if ( property_exists( $item, 'label' ) ) {
			$title = $item->label;
		}

		$output .= '" name="menu-item[' . $possible_object_id . '][menu-item-object-id]" value="'. esc_attr( $item->object_id ) .'" /> ';
		$output .= isset( $title ) ? esc_html( $title ) : esc_html( $item->title );
		$output .= '</label>';

		if ( empty( $item->url ) ) {
			$item->url = $item->guid;
		}

		if ( ! in_array( array( 'jvbpd-menu', 'jvbpd-'. $item->post_excerpt .'-nav' ), $item->classes ) ) {
			$item->classes[] = 'jvbpd-menu';
			$item->classes[] = 'jvbpd-'. $item->post_excerpt .'-nav';
		}

		$output .= '<input type="hidden" class="menu-item-db-id" name="menu-item[' . $possible_object_id . '][menu-item-db-id]" value="' . $possible_db_id . '" />';
		$output .= '<input type="hidden" class="menu-item-object" name="menu-item[' . $possible_object_id . '][menu-item-object]" value="'. esc_attr( $item->object ) .'" />';
		$output .= '<input type="hidden" class="menu-item-parent-id" name="menu-item[' . $possible_object_id . '][menu-item-parent-id]" value="'. esc_attr( $item->menu_item_parent ) .'" />';
		$output .= '<input type="hidden" class="menu-item-type" name="menu-item[' . $possible_object_id . '][menu-item-type]" value="custom" />';
		$output .= '<input type="hidden" class="menu-item-title" name="menu-item[' . $possible_object_id . '][menu-item-title]" value="'. esc_attr( $item->title ) .'" />';
		$output .= '<input type="hidden" class="menu-item-url" name="menu-item[' . $possible_object_id . '][menu-item-url]" value="'. esc_attr( $item->url ) .'" />';
		$output .= '<input type="hidden" class="menu-item-target" name="menu-item[' . $possible_object_id . '][menu-item-target]" value="'. esc_attr( $item->target ) .'" />';
		$output .= '<input type="hidden" class="menu-item-attr_title" name="menu-item[' . $possible_object_id . '][menu-item-attr_title]" value="'. esc_attr( $item->attr_title ) .'" />';
		$output .= '<input type="hidden" class="menu-item-classes" name="menu-item[' . $possible_object_id . '][menu-item-classes]" value="'. esc_attr( implode( ' ', $item->classes ) ) .'" />';
		$output .= '<input type="hidden" class="menu-item-xfn" name="menu-item[' . $possible_object_id . '][menu-item-xfn]" value="'. esc_attr( $item->xfn ) .'" />';
	}
}