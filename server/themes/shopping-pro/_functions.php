<?php
/**
 * @package functions
 * @author Edward Rana
 * @version 1.0.8
 * @since 1.0.0
 */
defined('BASE_DIR') || exit;

if( ! function_exists('build_res') ){
    function build_res( $status, $msg = '', $data = '' ){
        if( is_array($status) ){
            $res = $status;
        }
        else{
            $res = ['status' => $status, 'msg' => $msg];
        }

        if( $data && is_array( $data ) ){
            $res = array_merge( $res, $data );
        }

        return $res;
    }
}

if( ! function_exists('json_res') ){
    function json_res( $status, $msg = '', $data = '' ){
        $res = build_res( $status, $msg, $data );
        echo json_encode( $res, JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES );
        exit;
    }
}