<?php

/**
 *
 * Initialize and loads the entire framework
 *
 * @package plugin-name
 *
 * */

$modules = array(

	'BootStart',
	'OptionsManager',
	'SiteBackup'

);

// Loading all the files
foreach ( $modules as $module ) require_once( $module . '.php' );
