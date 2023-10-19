<?php 
/**
 * @package Init
 * @author Edward Rana
 * @version 1.0.8
 * @since 1.0.0
 */

require_once( BASE_DIR.'/config.php' );

require_once( 'urls.php' );
require_once( 'connection.php' );

//Include classes files

require_once( 'core-functions.php' );

if( file_exists(theme_dir('/_functions.php')) ){
   require_once( theme_dir('/_functions.php') );
}

require_once 'routing.php';