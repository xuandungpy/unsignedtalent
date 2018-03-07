<?php

get_template_part( 'library/layout' );

// bootstrap navigation walker for menus
get_template_part( 'library/functions/wp_bootstrap_navwalker' );
get_template_part( 'library/functions/class', 'tgm-plugin-activation' ); // intergrated plugins TGM
get_template_part( 'library/functions/activate', 'plugins' ); // get pluginsd
get_template_part( 'library/functions/class', 'ajax' ); // get pluginsd

/** Classes **/
get_template_part( 'library/classes/class', 'array' );
get_template_part( 'library/classes/javo', 'get-option' );
get_template_part( 'library/classes/class', 'basic-shortcode' );
get_template_part( 'library/classes/class', 'buddypress' );
// get_template_part( 'library/classes/class', 'buddypress-dir' );

/** Admin Panel **/
get_template_part( 'library/admin/class', 'admin' );
get_template_part( 'library/admin/class', 'admin-metabox' );
get_template_part( 'library/admin/class', 'admin-helper' );

get_template_part( 'library/admin/functions', 'nav' );

/** Header */
get_template_part( 'library/header/class', 'header' );

/** Widgets **/
get_template_part( 'library/widgets/wg-javo', 'recent-photos' );
get_template_part( 'library/widgets/wg-javo', 'recent-post' );
get_template_part( 'library/widgets/wg-javo', 'contact-us' );