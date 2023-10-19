<?php 
/**
 * @package Ajax
 * @author Edward Rana
 * @version 1.0.8
 * @since 1.0.0
 */

global $AJAX_ACTIONS;

if( !@$_POST['action'] ) exit;

if( @$AJAX_ACTIONS[$_POST['action']] ){
    $ajax_action = $AJAX_ACTIONS[$_POST['action']];
    if( is_callable($ajax_action['callback']) ){
        $ajax_action['callback']( $_POST );
    }
}