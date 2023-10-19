<?php
/**
 * @package include/mdp
 * @author Edward Rana
 */
if( !defined("BASE_DIR") ) exit;

if( !class_exists('MDP') ){

    class MDP{
        public static function plugin_dir( $str = '' ){
            return MDP_PLUGIN_DIR.$str;
        }

        public static function plugin_url( $str = '' ){
            return MDP_PLUGIN_URL.$str;
        }

        public static function get_template( $file ){
            if( !$file || !is_string( $file) ) return '';

            if( file_exists( self::plugin_dir('templates/'.$file.'.php') ) ){
                require_once( self::plugin_dir('templates/'.$file.'.php') );
            }
        }
    }
}