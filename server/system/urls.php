<?php 
/**
 * @package Url & Dir setups
 * @author Edward Rana
 * @version 1.0.8
 * @since 1.0.0
 */ 

$uri_segments = '';

$query_segments = '';

//print_r($_SERVER);
$query_string = '';

//print_r($_SERVER);

if( isset( $_SERVER['QUERY_STRING'] ) && strpos($_SERVER['QUERY_STRING'], 'path=') !== false ){
	$query_string = rtrim( str_replace('path=', '', $_SERVER['QUERY_STRING']), '/\\');
}

if( strpos($query_string, '&') !== false ){
	$query_string = rtrim( explode('&', $query_string)[0], '/\\' );
}

$uri = rtrim($query_string, '/\\');
	
$uri_segments = $uri;

if( !defined("SITE_URL") ){
	define( "SITE_URL", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']. str_replace('/index.php', '', $_SERVER['PHP_SELF'] ) );
}

define( "THEME_URL", SITE_URL.'/themes/'.$CONFIG['theme_name'].'/' );

define( "THEME_DIR", BASE_DIR.'themes/'.$CONFIG['theme_name'].'/' );

define( "STORAGE_URL", SITE_URL.'/storage/' );

define( "STORAGE_DIR", BASE_DIR.'storage/' );

define( "PLUGINS_DIR", BASE_DIR.'plugins/' );

define( "PLUGINS_URL", SITE_URL.'/plugins/' );

define( "MODEL_URL", THEME_URL.'models/' );

define( "MODEL_DIR", THEME_DIR.'models/' );