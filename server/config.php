<?php 
/**
* @package Config
* @author Edward Rana
* @version 1.0.8
* @since 1.0.0
*/

define("DEBUG", true);
define("DB_HOSTNAME", "localhost");

define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "shopping_pro");

date_default_timezone_set("Asia/Kolkata"); // Time zone

/**----------------------------------------------------------------------*
* BASE_URL can be defined manually
*------------------------------------------------------------------------*
* If not defined manually then will fetch from SERVER on every page load 
*------------------------------------------------------------------------*
* BASE_URL and SITE_URL is same
**-----------------------------------------------------------------------*/

//define( "BASE_URL", 'https://yoursite.com' );

/**----------------------------------------------------------------------*
* Global array, use/modify anywhere
**-----------------------------------------------------------------------*/
$CONFIG = array(

	/**------------------------------------------------------------------*
	* Define 404 page view file without extension
	**-------------------------------------------------------------------*/
	'404' 			     	 => '404',

	/**------------------------------------------------------------------*
	* Theme name
	**-------------------------------------------------------------------*/
	'theme_name' 			 => 'shopping-pro',

	/**------------------------------------------------------------------*
	* Site title suffix. Will be appended to site title
	**-------------------------------------------------------------------*/
	'site_title_suffix' 	 => ' - Shopping Pro'
);