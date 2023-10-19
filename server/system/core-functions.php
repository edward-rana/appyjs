<?php
/**
 * @package Core Functions
 * @author Edward Rana
 * @version 1.0.8
 * @since 1.0.0
 */
//header('Cache-Control: no cache'); //no cache
//session_cache_limiter('private_no_expire'); // works
//session_cache_limiter('public'); // works too
session_start();
//Appycan framework version
define("APPYCAN_VERSION", "1.0.8");
$HOOK_ACTIONS = array();
$HOOK_FILTERS = array();
$AJAX_ACTIONS = [];
function uri_segments() {
    global $uri_segments;
    return explode('/', $uri_segments);
}
function query_segments() {
    global $uri_segments, $uri;
    return explode('/', trim(str_replace($uri, '', $uri_segments), '/'));
}
function appycan_version() {
    return APPYCAN_VERSION;
}
function current_url($str = '') {
    return trim("$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", '/') . $str;
}
function current_dir($str = '') {
    global $current_dir;
    return $current_dir . $str;
}
function base_dir($str = '') {
    return BASE_DIR . $str;
}
function base_url($str = '') {
    return BASE_URL . $str;
}
function storage_url($str = '') {
    return STORAGE_URL . $str;
}
function storage_dir($str = '') {
    return STORAGE_DIR . $str;
}
function plugins_dir($str = '') {
    return PLUGINS_DIR . $str;
}
function plugins_url($str = '') {
    return PLUGINS_URL . $str;
}
function site_url($str = '') {
    return SITE_URL . $str;
}
function theme_dir($str = '') {
    return THEME_DIR . $str;
}
function theme_url($str = '') {
    return THEME_URL . $str;
}
function model_dir($str = '') {
    return MODEL_DIR . $str;
}
function model_url($str = '') {
    return MODEL_URL . $str;
}
function get_config($name) {
    global $CONFIG;
    if (isset($CONFIG[$name])) {
        return $CONFIG[$name];
    }
    return '';
}
function app(){
    global $app;
    return $app;
}

function get_header( $args = '' ){
    $template_file = current_dir('header.php');
    if( file_exists( $template_file ) ){
        if( is_array( $args ) ){
            extract( $args );
        }
        require_once( $template_file );
    }
}

function get_footer( $args = '' ){
    $template_file = current_dir('footer.php');
    if( file_exists( $template_file ) ){
        if( is_array( $args ) ){
            extract( $args );
        }
        require_once( $template_file );
    }
}

function site_title($title = '') {
    app()->set_option('site_title', $title);
    add_action('site_title', function () use ($title) {
        echo $title;
    });
}
function the_title($suffix = '') {
    do_action('site_title');
    if (!$suffix) {
        global $CONFIG;
        $suffix = @$CONFIG['site_title_suffix'];
    }
    echo $suffix;
}
function add_action($hook, $callback_func, $priority = 50) {
    global $HOOK_ACTIONS;
    $HOOK_ACTIONS[$hook][] = array('priority' => $priority, 'callback_func' => $callback_func);
}
function do_action($hook, ...$params) {
    global $HOOK_ACTIONS;
    //print_r($HOOK_ACTIONS);
    if (isset($HOOK_ACTIONS[$hook])) {
        arsort($HOOK_ACTIONS[$hook], SORT_NUMERIC);
        foreach ($HOOK_ACTIONS[$hook] as $HOOK_ACTION) {
            $HOOK_ACTION['callback_func'](...$params);
        }
    }
}
function add_filter($hook, $callback_func, $priority = 50) {
    global $HOOK_FILTERS;
    $HOOK_FILTERS[$hook][] = array('priority' => $priority, 'callback_func' => $callback_func);
}
function apply_filter($hook, ...$params) {
    global $HOOK_FILTERS;
    $return = @$params[0];
    if (isset($HOOK_FILTERS[$hook])) {
        arsort($HOOK_FILTERS[$hook], SORT_NUMERIC);
        foreach ($HOOK_FILTERS[$hook] as $i => $HOOK_FILTER) {
            $return = $HOOK_FILTER['callback_func'](...$params);
        }
    }
    return $return;
}
function try_unserialize($str, $not_true_return = 'RESERVED_NULL_RETURN') {
    if (@unserialize($str) !== false) {
        return unserialize($str);
    } elseif ($not_true_return != 'RESERVED_NULL_RETURN') {
        return $not_true_return;
    }
    return $str;
}
function set_session($key, $val) {
    $_SESSION[$key] = $val;
}
function get_session($key, $destroy = false) {
    if (!$destroy) {
        return @$_SESSION[$key];
    } else {
        $sess_val = @$_SESSION[$key];
        unset($_SESSION[$key]);
        return $sess_val;
    }
}
function set_cookie($name, $value, $expire = '', $path = '', $domain = '', $secure = false, $httponly = false) {
    if (!$expire) $expire = time() + 86400 * 30;
    setcookie($name, $value, $expire);
}
function get_cookie($key, $destroy = false) {
    if (!$destroy) {
        return @$_COOKIE[$key];
    } else {
        $cookie_val = @$_COOKIE[$key];
        set_cookie($key, '', 1);
        unset($_COOKIE[$key]);
        return $cookie_val;
    }
}
function __($str, $translate = 'default') {
    return apply_filter('print_str', $str, $translate);
}
function esc_html__($str, $text_domain = 'default') {
    return htmlentities($str);
}
function esc_html_e($str, $text_domain = 'default') {
    echo esc_html__($str, $text_domain);
}
function esc_attr($str) {
    $strip_text = strip_tags($str);
    $result = preg_replace('/<(\w+)[^>]*>/', '<$1>', $strip_text);
    return $result;
}
function esc_script($str) {
    $str = preg_replace('/<script[^>]*>/', '<code>', $str);
    $str = preg_replace('/<\/script[^>]*>/', '</code>', $str);
    return $str;
}
function is_email($str) {
    if (!filter_var($str, FILTER_VALIDATE_EMAIL)) {
        return false;
    } else {
        return true;
    }
}
function get_image_sizes() {
    return apply_filter('get_image_sizes', array('thumbnail' => 250, 'medium' => 500));
}
function upload_file($name, $args = array()) {
    $default_args = array('auto_sizes' => false, 'image_sizes' => get_image_sizes());
    $args = array_merge($default_args, $args);
    $args = apply_filter('upload_file_args', $args);
    $ext = strtolower(pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION));
    if (!$ext || $ext == 'php' || $ext == 'py' || $ext == 'sh') {
        return array('status' => 'error', 'msg' => 'File format not allowed!');
    }
    if (@$args['allowed_types']) {
        if (strpos($args['allowed_types'], $ext) === false) {
            return array('status' => 'error', 'msg' => 'File type \'' . $ext . '\' not allowed!');
        }
    }
    if (@$args['min_size'] && $_FILES[$name]['size'] < $args['min_size']) { //In Bytes
        return array('status' => 'error', 'msg' => 'File size can\'t be less than ' . $args['min_size'] . ' Bytes');
    }
    if (@$args['size'] && $_FILES[$name]['size'] != $args['size']) { //In Bytes
        return array('status' => 'error', 'msg' => 'File size must be ' . $args['size'] . ' Bytes');
    }
    if (@$args['max_size'] && $_FILES[$name]['size'] > $args['max_size']) { //In Bytes
        return array('status' => 'error', 'msg' => 'File size can\'t be greater than ' . $args['max_size'] . ' Bytes');
    }
    $filename_w = md5($_FILES[$name]['name'] . rand(100, 99999) . uniqid());
    $filename = $filename_w . '.' . $ext;
    if ($args['dir']) {
        if (!file_exists(storage_dir('/') . $args['dir'])) {
            mkdir(storage_dir('/') . $args['dir'], 0777, true);
        }
        $target_file = storage_dir('/') . $args['dir'] . '/' . $filename;
        $target_file_w = storage_dir('/') . $args['dir'] . '/' . $filename_w;
        $filepath = $args['dir'] . '/' . $filename;
        $filepath_w = $args['dir'] . '/' . $filename_w;
    } else {
        $target_file = storage_dir('/') . $filename;
        $target_file_w = storage_dir('/') . $filename_w;
        $filepath = $filename;
        $filepath_w = $filename_w;
    }
    move_uploaded_file($_FILES[$name]["tmp_name"], $target_file);
    if (@$args['compress'] > 0) {
        if ($ext == 'jpg') $image = imagecreatefromjpeg($target_file);
        elseif ($ext == 'gif') $image = imagecreatefromgif($target_file);
        elseif ($ext == 'png') $image = imagecreatefrompng($target_file);
        imagejpeg($image, $target_file, $args['compress']);
    }
    $gen_sizes = array();
    if ($args['auto_sizes'] && in_array($ext, array('jpg', 'png', 'jpeg', 'gif'))) {
        foreach ($args['image_sizes'] as $size_name => $def_width) {
            $size = getimagesize($target_file);
            $ratio = $size[1] / $size[0]; // height/width
            // if( $ratio > 1) {
            //     $width = $def_width;
            //     $height = $def_width / $ratio;
            // }
            // else {
            //     $width = $def_width;
            //     $height = $def_width * $ratio;
            // }
            $width = $def_width;
            $height = $def_width * $ratio;
            $src = imagecreatefromstring(file_get_contents($target_file));
            $dst = imagecreatetruecolor($width, $height);
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            //imagecopy($dst, $src, 0, 0, 0, 0, $size[0], $size[1]);
            imagedestroy($src);
            if ($ext == 'jpg' || $ext == 'jpeg') {
                imagejpeg($dst, $target_file_w . '_' . $size_name . '.' . $ext);
            }
            elseif ($ext == 'png') {
                imagepng($dst, $target_file_w . '_' . $size_name . '.' . $ext);
            }
            elseif ($ext == 'gif') {
                imagegif($dst, $target_file_w . '_' . $size_name . '.' . $ext);
            }
            //imagepng($dst, $target_file_w.'_'.$size_name.'.'.$ext); // adjust format as needed
            imagedestroy($dst);
            $gen_sizes[$size_name] = $filepath_w . '_' . $size_name . '.' . $ext;
        }
    }
    $res = array('status' => 'success', 'msg' => 'File Uploaded!', 'filename' => $_FILES[$name]['name'], 'filepath' => $filepath, 'file_type' => $ext, 'file_size' => $_FILES[$name]['size']);
    if ($gen_sizes) {
        $res['sizes'] = $gen_sizes;
        $res['sizes']['original'] = $filepath;
    }
    return $res;
}
function redirect($url = '') {
    if ($url) {
        header("Location: " . $url);
        exit;
    } else {
        header("Refresh: 0");
        exit;
    }
}
function _echo($str, $symbol = '-') {
    if (!$str) {
        $str = $symbol;
    }
    echo $str;
}
function slugify($string, $divider = '-') {
    $string = utf8_encode($string);
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = preg_replace('/[^a-z0-9- ]/i', '', $string);
    $string = str_replace(' ', $divider, $string);
    $string = str_replace(['-', '_'], $divider, $string);
    $string = trim($string, $divider);
    $string = strtolower($string);
    return $string;
}
function ac_ajax($action, $callback) {
    if($action && @$_POST['action'] == $action) {
        global $AJAX_ACTIONS;
        $AJAX_ACTIONS[$action] = ['callback' => $callback];
    }
}
