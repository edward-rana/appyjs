<?php 
/**
 * @package Routing
 * @author Edward Rana
 * @version 1.0.8
 * @since 1.0.0
 */

class App extends Loader{

    public $option_data = [];
    public $executed_route = false;

    public function __construct(){
        $this->router = new Router();
        //$this->exec_route();
    }

    public function get_option( $option_name ){
        if( isset( $this->option_data[$option_name] ) ){
            return $this->option_data[$option_name];
        }
        return '';
    }

    public function set_option( $option_name, $value ){
        $this->option_data[$option_name] = $value;
    }

    public function exec_route(){

        if( $this->executed_route ) return;
        $this->executed_route = true;

        if( file_exists(theme_dir('_router.php')) ){
           require_once( theme_dir('_router.php') );
           do_action('pre_router_exec');
        }
        else{
            die("'theme_name' OR '_router.php' - Invalid");
        }

        /*--- ===================# First method #================= ---*/

        global $uri, $current_dir;
        //echo $uri;
        //print_r($this->router->Routes);

        if( $uri == 'ajax.php' ){
            $current_dir = theme_dir();

            require_once( BASE_DIR.'system/ajax.php' );
            exit;
        }

        $Response_code = 404;

        if( @$this->router->Routes[$uri] ){
            //echo 'Page found';

            $in_file = @$this->router->Routes[$uri]['file'].'.php';

            if( file_exists($in_file) ){ 

                $current_dir = substr($in_file, 0, strrpos($in_file, '/')).'/';

                if( file_exists($current_dir.'_init.php') ){
                    require_once $current_dir.'_init.php';
                }

                require_once $in_file;

                exit;
            }
        }
        else{
            //echo strrpos($uri, '/');
            if( strpos($uri, '/') === false ){
                $uri = '/'.$uri;
            }
            
            while(1){
                if( strpos($uri, '/') === false ){
                    break;
                }

                $uri = substr($uri, 0, strrpos($uri, '/'));

                if( @$this->router->Routes[$uri] ){

                    if( @$this->router->Routes[$uri]['allow_segs'] ){

                        if( file_exists(@$this->router->Routes[$uri]['file'].'.php') ){

                            $in_file = @$this->router->Routes[$uri]['file'].'.php';

                            if( file_exists($in_file) ){

                                $current_dir = substr($in_file, 0, strrpos($in_file, '/')).'/';

                                if( file_exists($current_dir.'_init.php') ){
                                    require_once $current_dir.'_init.php';
                                }

                                require_once $in_file;

                                exit;
                            }
                        }
                    }
                    else{
                        break;
                    }
                }
            }
        }

        if( $Response_code == 404 ){
            global $CONFIG;
            $current_dir = theme_dir();
            if( file_exists(theme_dir(@$CONFIG['404'].'.php')) ){
                require_once(theme_dir($CONFIG['404'].'.php'));
            }
            else{
                header("HTTP/1.0 404");
            } 
        } 
        else{
            header("HTTP/1.0 ".$Response_code);
        } 

        /*--- /===================# First method #================= ---*/
    }
}

class Router{
    public $Routes = array();
    public function add( $slug, $file, $allow_segments = false ){

        $this->Routes[$slug] = array('file' => theme_dir($file), 'allow_segs' => $allow_segments);

        return $this;
    }
}

class Loader{

    public function load_model( $model, ...$params ){

        $model = trim($model, '/');

        $segs = explode('/', $model);

        if( !$segs ) return $this;

        //print_r($segs);

        if( file_exists(model_dir($model.'.php')) ){
            require_once model_dir($model.'.php');
        }
        else{
            return;
        }

        if( count($segs) < 2 ){
            //$arg1 = $segs[0];
            
            return $this->$model = new $model(...$params);
        }
        else{
            $arg1 = $segs[0];
            $arg2 = $segs[1];
            return @$this->$arg1->$arg2 = new $arg2(...$params);
        }
    }

    public function load_lib( $lib, ...$params ){
        $lib = trim($lib, '/');

        $segs = explode('/', $lib);

        if( !$segs ) return $this;

        //print_r($segs);

        if( file_exists(base_dir('system/libraries/'.$lib.'.php')) ){
            require_once base_dir('system/libraries/'.$lib.'.php');
        }

        if( count($segs) < 2 ){
            $arg1 = $segs[0];
            
            return $this->$arg1 = new $arg1(...$params);
        }
        else{
            $arg1 = $segs[0];
            $arg2 = $segs[1];
            return @$this->$arg1->$arg2 = new $arg2(...$params);
        }
    }
}

$current_dir = '';
$app = new App();

require_once( 'core-functions.php' );

if( file_exists(theme_dir('/_functions.php')) ){
   require_once( theme_dir('/_functions.php') );
}

$app->exec_route();