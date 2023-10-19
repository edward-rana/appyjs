<?php
/**
 * @package include/module
 * @author Edward Rana
 */
namespace MDP;
if( !defined("BASE_DIR") ) exit;

class MediaPicker{
    public function __construct(){

        add_action('ac_footer', [$this, 'load_media_modal']);
        $this->load_assets();
    }

    protected function load_assets(){
        add_style( \MDP::plugin_url('assets/css/dropzone.css'), 'ac_head' );
        add_style( \MDP::plugin_url('assets/css/style.css'), 'ac_head' );

        add_script( \MDP::plugin_url('assets/js/dropzone.js'), 'ac_footer' );
        add_script( \MDP::plugin_url('assets/js/script.js'), 'ac_footer' );
    }

    public function load_media_modal(){
        \MDP::get_template('media-modal');
    }
}

new MediaPicker();