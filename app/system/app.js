/**********************************************************
 * System App
 *------------------------------------------------------
 * @author Edward Rana
 * @version 1.0.0
 * @link Edward Rana <edward.rana6@gmail.com>
 *------------------------------------------------------
 */

/***********************************************************
 * Define global variables..
 *-----------------------------------------------------
 */
var html = '';

/***********************************************************
 * App - Class..
 *-----------------------------------------------------
 */
class AppCls{

    constructor(){

        window.onload = () => {
            console.log('AppyJS App Initialized..');
            this.app_root = document.querySelector("#app_root");

            if( typeof $ === 'undefined' ){
                if( typeof jQuery !== 'undefined' ){
                    window['$'] = jQuery;
                    this.init();
                }
                else{
                    const l_jquery = this.load_js('https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min');
                    l_jquery.addEventListener('load', () => {
                        console.log('Recommended jQuery-3.7.1 is auto-loaded by AppyJS.');
                        this.init();
                    });
                }
            }
            else{
                this.init();
            }
        };
    }

    assets_and_event_listeners(){
        if( Config.hashed_slug ){
            window.onhashchange = () => {
                this.render_template();
            };
        }
    }

    init(){
        const func_file = this.load_js('theme/functions');

        func_file.addEventListener('load', () => {
            if( typeof Config === 'undefined' ){
                let tmp_intv = setInterval(() => {
                    if( typeof Config !== 'undefined' ){
                        this.assets_and_event_listeners();
                        this.render_template();
                        clearInterval( tmp_intv );
                    }
                }, 10);
            }
            else{
                this.assets_and_event_listeners();
                this.render_template();
            }
        });

        func_file.addEventListener( 'error', (e) => {
            document.querySelector('body').innerHTML = '<code style="margin-top: 25px;">"functions.js"</code> file missing in theme. Add and reload.';
            document.querySelector('app_theme').innerHTML = '';
        });
    }

    render_template(){
        //console.log( Route.get_uri() );
        var route = Route.current_route();

        if( ! route ){
            route = '404';
        }
        else{
            route = route.file;
        }

        html = '';
        this.app_root.innerHTML = '';
        let page_file_holder = document.querySelector('app_page');
        page_file_holder.innerHTML = '';

        let page_file = this.load_js( 'theme/'+route, page_file_holder );

        page_file.addEventListener( 'load', () => {
            //console.log("File loaded");
            //console.log( html );

            this.app_root.innerHTML = html;

            do_action( 'after_page_load' );
        });
        
        page_file.addEventListener( 'error', (e) => {
            redirect( page_url('404') );
            console.log("Error on loading file", e);
        });
    }

    load_js( FILE_URL, appendTo = document.querySelector("app_theme") ){
        FILE_URL = get_asset_url( FILE_URL );
        let scriptEle = document.createElement("script");

        if( Config.debug_mode ){
            scriptEle.setAttribute("src", FILE_URL+'.js?ver=' + Math.floor(Math.random() * 99999) );
        }
        else{
            scriptEle.setAttribute("src", FILE_URL+'.js');
        }
        
        scriptEle.setAttribute("async", true);

        appendTo.appendChild(scriptEle);

        return scriptEle;
    }

    ajax( url, data, callback ){
        // console.log( data.constructor.name.toLowerCase() );
        // return;
        
        if( typeof data !== 'object' || ! url ) return false;

        //CDVR.loader(true);
        var args = {
            url: url,
            method: "POST",
            data: data,
            complete: function( xhr, status ){
                //CDVR.loader(false);

                console.log( xhr.responseText );

                if( status === 'success' ){
                    try{
                        var data = JSON.parse( xhr.responseText );
                    }
                    catch( e ){
                        var data = {status: 'error', msg: 'Unable to resolve server response.'};
                    }
                }
                else{
                    var data = {status: 'error', msg: 'Internal server error.'};
                }

                callback( data );
            }
        };

        if( data.constructor.name.toLowerCase() == 'formdata' ){
            args.processData = false;
            args.contentType = false;
        }

        $.ajax( args );
    }
}

/***********************************************************
 * RD Class..
 *------------------------------------------------------
 */
class clsRD{
    rd_parts = {};

    render( part_name, parsed_data = false, callback = false ){

        if( this.is_loaded( part_name ) ){
            if( ! callback ){
                return eval( this.rd_parts[part_name] );
            }
            else{
                callback( eval( this.rd_parts[part_name] ) );
            }
        }
        else{ //Loading part..
            let part_file = part_name.split('.')[0];
            let rd_key = part_name +'_'+ Math.random().toString(16).slice(2);

            let file = App.load_js( 'theme/rd-parts/'+part_file );
            file.addEventListener( 'load', () => {
                //console.log( this.rd_parts );
                if( callback ){
                    callback( eval( this.rd_parts[part_name] ) );
                }
                else{
                    //console.log( this.rd_parts[part_name] );
                    $('[rd_part="'+rd_key+'"]').replaceWith( eval( this.rd_parts[part_name] ) );
                }
                this.trigger_render_event();
            });

            return '<div rd_part="'+rd_key+'"></div>';
        }
    }

    is_loaded( part_name ){
        if( this.rd_parts[part_name] ){
            return true;
        }
        else{
            return false;
        }
    }

    trigger_render_event(){
        $('[onrender]').each(function(){
            eval( $(this).attr('onrender') );
            $(this).removeAttr( 'onrender' );
        });
    }

    add_part( part_name, raw_code ){
        this.rd_parts[part_name] = raw_code;
        console.log( this.rd_parts );
    }
}

/***********************************************************
 * Core Functions..
 *------------------------------------------------------
 */
const APP_ACTIONS = {};
const APP_FILTERS = {};
const add_action = function( action, callback, priority = 99, param_count = 1 ){
    if( ! APP_ACTIONS[action] ){
        APP_ACTIONS[action] = [];
    }

    if( ! APP_ACTIONS[action][priority] ){
        APP_ACTIONS[action][priority] = [];
    }

    APP_ACTIONS[action][priority].push({callback: callback, param_count: param_count});
};

const do_action = function( action, ...params ){
    //console.log( params );

    if( ! APP_ACTIONS[action] ) return '';

    APP_ACTIONS[action].reverse();

    let return_data = '';

    for( var i in APP_ACTIONS[action] ){
        
        var aas = APP_ACTIONS[action][i];
        for( var j in aas ){
            var aa = aas[j];

            //params = params.slice(0, aa.param_count);
            return_data = aa['callback']( ...params );
        }
    }

    //console.log( APP_ACTIONS );

    return return_data;
};

const render = function( part_name, parsed_data = false, callback = false ){
    return RD.render( part_name, parsed_data, callback );
};

const load_js = function( FILE_URL, callback = false ){
    const appendTo = document.querySelector('app_page');
    var file = App.load_js( FILE_URL, appendTo );
    if( ! callback ){
        return file;
    }

    file.addEventListener( 'load', () => {
        callback( true );
    });

    file.addEventListener( 'error', ( ev ) => {
        callback( false );
    });
};

const load_css = function( FILE_URL, callback = false ){
    const appendTo = document.querySelector('app_page');
    FILE_URL = get_asset_url( FILE_URL );
    let style = document.createElement("link");

    if( App.debug_mode ){
        style.setAttribute("href", FILE_URL+'.css?ver=' + Math.floor(Math.random() * 99999) );
    }
    else{
        style.setAttribute("href", FILE_URL+'.css');
    }
    
    style.setAttribute("rel", "stylesheet");
    style.setAttribute("type", "text/css");

    appendTo.appendChild( style );

    if( ! callback ){
        return style;
    }

    style.addEventListener( 'load', () => {
        callback( true );
    });

    style.addEventListener( 'error', ( ev ) => {
        callback( false );
    });
};

const redirect = function( url = '' ){
    if( Config.hashed_slug ){
         window.location.href = url;
    }
    else{
        const nextURL = url;
        const nextTitle = 'Redirected..';
        const nextState = { additionalInformation: 'Updated the URL with AppyJS.' };
        try{
            // This will create a new entry in the browser's history, without reloading
            window.history.pushState(nextState, nextTitle, nextURL);
            // This will replace the current entry in the browser's history, without reloading
            window.history.replaceState(nextState, nextTitle, nextURL);
            App.render_template();
        }
        catch(e){
            console.error( e );
        } 
    }
};

const site_title = function( title, suffix = Config.app_name ){
    $('title').text( title + ' - '+ suffix );
};

const app_url = function( str = '' ){
    return Config.app_url + str;
};

const page_url = function( str = '' ){
    if( ! Config.hashed_slug ){
        return Config.app_url + '/' + str;
    }
    else{
        return '#'+str;
    }
    //return Config.app_url + ( ( Config.hashed_slug && str ) ? '#' : '/' ) + str;
};

const is_full_url = function( url ){
    const starts = ['https://', 'http://', '//'];
    for( var i in starts ){
        var str = starts[i];
        if( str == url.substr(0, str.length) ){
            return true;
        }
    }
    return false;
};

const get_asset_url = function( src ){
    return src;
    // if( is_full_url( src ) ){
    //     return src;
    // }
    // return app_url( '/' + src.replace(/^\/|\/$/g, '') );
};

/***********************************************************
 * Init actions..
 *-----------------------------------------------------
 */
add_action('after_page_load', function(){
    RD.trigger_render_event();
});

/***********************************************************
 * Call classes..
 *-----------------------------------------------------
 */
const RD = new clsRD();
const App = new AppCls();

var hh = '';
function base_url() {
    var re = new RegExp(/^.*\//);
    hh = re.exec(window.location.href);
    return hh;
}

console.log( base_url() );