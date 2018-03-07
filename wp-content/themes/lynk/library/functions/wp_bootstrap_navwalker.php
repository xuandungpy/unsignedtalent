<?php
/**
 * Class Name: bs4Navwalker
 * GitHub URI: https://github.com/dominicbusinaro/bs4navwalker
 * Description: A custom WordPress nav walker class for Bootstrap 4 (v4.0.0-alpha.1) nav menus in a custom theme using the WordPress built in menu manager
 * Version: 0.1
 * Author: Dominic Businaro - @dominicbusinaro
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
class bs4Navwalker extends Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"dropdown-menu\">\n";
    }
    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }
    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        // New
        $class_names .= ' nav-item';

        if (in_array('menu-item-has-children', $classes)) {
            $class_names .= ' dropdown';
        }
        if (in_array('current-menu-item', $classes)) {
            $class_names .= ' active';
        }
        //
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        // print_r($class_names);
        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        // New
        if ($depth === 0) {
            $output .= $indent . '<li' . $id . $class_names .'>';
        }
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        // New
        if ($depth === 0) {
            $atts['class'] = 'nav-link';
        }
        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $atts['class']       .= ' dropdown-toggle';
            $atts['data-toggle']  = 'dropdown';
        }
        if ($depth > 0) {
            $atts['class'] = 'dropdown-item';
        }
        if (in_array('current-menu-item', $item->classes)) {
            $atts['class'] .= ' active';
        }
        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if (isset($args->has_children) && $depth === 0) {
            $output .= "</li>\n";
        }
    }
}


class jvnavwalker extends Walker_Nav_Menu {

	public $strPrependStartElContent = null;

	// add classes to ul sub-menus
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
			'nav sub-menu-second',
			( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
			( $display_depth >=2 ? 'nav nav-third-level' : '' ),
			'menu-depth-' . $display_depth
			);

		$strUlStyle ='';
		if( ! is_null( $this->strPrependStartElContent ) ) {
			$classes[] = 'wide-nav-overlay';
			$strUlStyle = sprintf( 'style="background-image:url(%s);"', $this->strPrependStartElContent );
			$this->strPrependStartElContent = null;
		}
		$class_names = implode( ' ', $classes );

		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '" ' . $strUlStyle . '>' . "\n";

	}

     function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
         global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);

		$appenHTML = '';

		if( $item->wide_menu == 'yes' ) {
			$depth_classes[] = 'wide-container';
			if( isset( $item->nav_bg ) && 0 < intVal( $item->nav_bg ) ) {
				$arrNavBackground = wp_get_attachment_image_src( $item->nav_bg, 'full' );
				if( false !== $arrNavBackground ) {
					$this->strPrependStartElContent = $arrNavBackground[0];
				}
			}
			if( 'all' == $item->wide_menu_category || 0 < intval( $item->wide_menu_category ) ) {
				ob_start();
				jvbpd_layout()->load_template(
					'parts/part-menu-wide-category',
					array(
						'jvbpd_menu_args' => (object) Array(
							'term_id' => intVal( $item->wide_menu_category ),
						),
					)
				);
				$appenCONTENT = ob_get_clean();
				$appenHTML = sprintf( '<ul class="nav sub-menu-second menu-depth-1 wide-nav-overlay"><li>%s</li></ul>', $appenCONTENT );
			}
		}

		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		if( 0 < intVal( $args->walker->has_children ) ){
			$arrow = "<span class='fa arrow'></span>";
		}else{
			$arrow ="";
		}

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// build html
		$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$strIcon = !empty( $item->nav_icon ) ? '<i class="nav-icon ' . $item->nav_icon . '"></i> ' : '<i class="nav-icon"></i>';

		$item_output = sprintf( '%1$s<a%2$s>%8$s<span class="menu-titles">%3$s%4$s%5$s%6$s</span></a>%7$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$arrow,
			$args->link_after,
			$args->after,
			$strIcon
		);

		$item_output .= $appenHTML;

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}


