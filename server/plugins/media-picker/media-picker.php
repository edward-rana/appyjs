<?php
/*
* Plugin name: Media Picker
* Description: Media picker for sites.
* Docs: Javascript code 
*   mediaPicker.show(types = '', callback = '', selected_ids = '', multiselect = false)
*
* text-domain: media-picker
*/
if( !defined("BASE_DIR") ) exit;

if( !defined("MDP_PLUGIN_DIR") ){
    define( "MDP_PLUGIN_DIR", plugins_dir('media-picker/') );
}

if( !defined("MDP_PLUGIN_URL") ){
    define( "MDP_PLUGIN_URL", plugins_url('media-picker/') );
}

require_once('include/mdp.php');

require_once('include/functions.php');

require_once('include/module.php');