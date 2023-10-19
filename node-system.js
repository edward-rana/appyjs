fs = require('fs');
global.path = require('path');

open = require('open');

version = '1.0.0';

app_dirname = 'app'; // Without trailing slashes..

schema = 'http';
hostname = 'localhost';
port = 9735;
express_app_url = schema + '://' + hostname +':'+port;

const jsdom = require('jsdom');
const dom = new jsdom.JSDOM();
const window = dom.window;
const document = window.document;

$ = require('jquery')(window);

/**
 * All Ok! Exec.. main codes..
 */
fs.readFile( 'src/Config.json', 'utf8', (err, str) => {
    if( err ){
        console.error(err);
        return;
    }
    config = aj_get_json( str );
    cmd = get_cmd_args();
    app_url = ( config.app_url ? config.app_url : express_app_url );

    generate_app_config();

    if( cmd.action == 'start' && cmd.args == 'server' ){
        start_server();
    }
    watch_file_updates();

    log( 'All Okay!! Start coding in "src" directory..' );
    log( 'App url: ' + app_url );
});

/**
 * Helper functions..
 */
const generate_app_config = function(){
    if( ! file_exists('App-Config.json') ){
        var S4 = function(){
           return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
        };
        var secret_key = (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
        var app_config = {
            secret_key: secret_key
        };
        aj_write_file( 'App-Config.json', JSON.stringify( app_config ) );
    }
};

const start_server = function(){
    const express = require('express');

    app = express();
    app.use( express.static( app_dirname ) );
    app.get('*', (req, res) => {
        res.sendFile( __dirname + '/'+ app_dirname +'/index.html' );
    });

    app.listen(port, hostname, () => {
        console.log( 'Express server running at: ' + express_app_url );
        log( 'Note: Asset files will be loaded from App url if hashed_slug = false. You can run app on external servers (eg: Xampp, ..) by setting up app_url. More info to run on another server visit: https://github.com/edward-rana/appyjs');
        open( app_url );
    });
};

const watch_file_updates = function(){
    const chokidar = require('chokidar');
    const watcher = chokidar.watch('src', {ignored: /^\./, persistent: true, awaitWriteFinish: true});

    watcher.on('add', function(path){
        //console.log('File', path, 'has been added');
    });

    watcher.on('change', function(path){
        console.log('File', path, 'has been changed');
        aj_update_file( path );
    });

    watcher.on('unlink', function(path){
        console.log('File', path, 'has been removed');
        aj_delete_file( path );
    });

    watcher.on('error', function(error){
        console.error('Error happened', error);
    });
};

const aj_update_file = ( path ) => {
    fs.readFile( path, 'utf8', (err, str) => {
        if( err ){
            console.error(err);
            return;
        }
        //log( path );
        if( str ){
            str = str.trim();
        }

        if( path == 'src\\Config.json' ){
            var json = aj_get_json( str );
            aj_generate_config( json, 'Config' );
            return;
        }
        else if( path == 'src\\Router.json' ){
            var json = aj_get_json( str );
            aj_generate_config( json, 'Router' );
            return;
        }
        else if( path.substr( 0, 9 ) != 'src\\theme' ){
            return;
        }

        var ext = aj_file_extension( path );
        var app_path = app_dirname + path.substr( app_dirname.length );
        if( ext != 'html' ){
            //log("Just update file!");
            aj_write_file( app_path, str );
            return;
        }

        const root = $('<root>'+str+'</root>');
        
        var rd_parts_str = '';
        if( path.includes('src\\theme\\rd-parts') && root.find('rd').length > 0 ){
            root.find('rd').each(function(){
                var node = $(this);
                var part_name = path.replace('src\\theme\\rd-parts\\', '');
                part_name = part_name.replaceAll('\\', '.').replace('.html', '.') + node.attr('name');
        
                var task = node.attr('task');
                var data = node.attr('data');
                if( data && data.trim() == '' ){
                    data = '{}';
                }

                var on_render = node.attr('onrender');
                if( on_render && node.children().length > 0 ){
                    node.children().first().attr('onrender', on_render);
                }

                node.find('a').each(function(){
                    $(this).attr('onclick', 'redirect(\''+ $(this).attr('href')+'\'); return false;');
                });

                var rd_part_str = '';
                if( ! task || task == 'render' ){
                    // :: Task:: Render ..
                    rd_part_str = '``+ function(){ var attr_data = ' + data +'; var data = ( ( ! parsed_data ) ? attr_data : parsed_data ); var html = `' + aj_translate_code( node.html() ) + '`; return html; }();';
                }
                else if( task == 'ajax' ){
                    // :: Task:: Ajax ..
                    rd_part_str = '``+ function(){ var html = `' + aj_translate_code( node.html() ) + '`; return html; }();';

                    rd_part_str = '``+ function(){ var attr_data = ' + data + '; var data = ( ( ! parsed_data ) ? attr_data : parsed_data ); var url = data.url; var rd_ajax_key = \'rdajx_\'+ Math.random().toString(16).slice(2); delete data.url; App.ajax( url, data, function( data ){ var html = ' + rd_part_str + ' $(\'[rd_ajax="\'+rd_ajax_key+\'"]\').replaceWith( html ); }); return \'<div rd_ajax="\'+ rd_ajax_key +\'"></div>\'; }();';
                }

                if( rd_part_str ){
                    rd_part_str = rd_part_str.replaceAll('`', '\\`');
                    rd_part_str = rd_part_str.replaceAll('</', '<\\/');

                    rd_part_str = 'RD.add_part( "' + part_name + '", `' + rd_part_str + '` );';

                    rd_parts_str += rd_part_str;
                    node.remove();
                }
            });

            str = root.html();
        }

        if( str.trim() ){
            str = aj_translate_code( str );
            str = rd_parts_str + 'html += `' + str + '`;';
        }
        else{
            str = rd_parts_str;
        }

        app_path = app_path.replace('.html', '.js');
        aj_write_file( app_path, str );
        //log( str );
    });
};

const aj_delete_file = function( path ){
    var app_path = app_dirname + path.substr( app_dirname.length );
    app_path = app_path.replace('.html', '.js');
    if( file_exists( app_path ) ){
        fs.unlinkSync( app_path );
    }
}

const aj_file_extension = function(filename){
    var ext = /^.+\.([^.]+)$/.exec(filename);
    return ext == null ? "" : ext[1];
};

const aj_translate_code = function( str, var_name = 'html' ){
    if( str.trim() == '' ) return '';
    str = str.replaceAll('{{', '`+').replaceAll('}}', '+`');

    str = str.replaceAll('<script>', '`;').replaceAll('</script>', var_name + ' += `');
    return str;
};

const aj_generate_config = function( json, from_src ){
    if( ! json ){
        log('"'+from_src+'.json" not a valid json data.');
    }

    if( from_src == 'Config' ){
        var config_json = json;
        var router_json =  read_file('src/Router.json');
        router_json = aj_get_json( router_json );
    }
    else if( from_src == 'Router' ){
        var router_json = json;
        var config_json =  read_file('src/Config.json');
        config_json = aj_get_json( config_json );
    }
    else{
        return;
    }

    // Generate config.js
    if( router_json && typeof router_json === 'object' ){
        var routes = [];
        for( var slug in router_json ){
            routes.push( 'Route.add("'+slug+'", "'+router_json[slug]+'");' );
        }
        config_json.router_entries = routes.join("\n");
    }
    else{
        config_json.router_entries = '';
        console.warn('"src/Router.json" - is not a valid router json data.');
    }

    if( ! config_json.hasOwnProperty('version') ){
        config_json.version = version;
    }

    if( typeof config_json.hashed_slug !== 'boolean' ){
        config_json.hashed_slug = true;
        config.hashed_slug = true;
    }
    else{
        config.hashed_slug = config_json.hashed_slug;
    }
    
    if( ! config_json.app_url ){
        app_url = express_app_url;
        config_json.app_url = app_url;
    }
    else{
        app_url = config_json.app_url;
    }

    var gen_config = read_file('samples/config-sample.js');

    var config_props = [
        'app_name', 'app_url', 'server_url', 'debug_mode', 'hashed_slug',
        'version', 'router_entries' 
    ];

    for( var i in config_props ){
        var prop = config_props[i];
        if( config_json.hasOwnProperty( prop ) ){
            gen_config = gen_config.replaceAll( '{{'+prop+'}}', config_json[prop] );
        }
        else{
            gen_config = gen_config.replaceAll( '{{'+prop+'}}', '' );
        }
    }

    aj_write_file(app_dirname+'/system/config.js', gen_config);

    // Generate index..
    var styles = [];
    for( var i in config_json.styles ){
        var style = config_json.styles[i];
        if( ! style ) continue;
        if( typeof style === 'object' ){
            var build_str = '<link rel="stylesheet" type="text/css" href="';
            if( typeof style[0] !== 'undefined' ){
                build_str += build_asset_link( style[0] ) + ( typeof style[2] !== 'undefined' ? '?v='+style[2] : '' ) + '"';
            }
            else{
                continue;
            }
            if( typeof style[1] !== 'undefined' ){
                build_str += ' id="' + style[1] +'-style"';
            }
            build_str += '>';
            styles.push( '    '+build_str );
        }
        else{
            styles.push('    <link rel="stylesheet" type="text/css" href="'+build_asset_link( style )+'?v='+version+'">');
        }
    }
    styles[0] = styles[0].trim();
    config_json.styles = styles.join("\n");

    var scripts = [];
    for( var i in config_json.scripts ){
        var script = config_json.scripts[i];
        if( ! script ) continue;
        if( typeof script === 'object' ){
            var build_str = '<script src="';
            if( typeof script[0] !== 'undefined' ){
                build_str += build_asset_link( script[0] ) + ( typeof script[2] !== 'undefined' ? '?v='+script[2] : '' ) + '"';
            }
            else{
                continue;
            }
            if( typeof script[1] !== 'undefined' ){
                build_str += ' id="' + script[1] +'-script"';
            }
            build_str += '></script>';
            scripts.push( '    '+build_str );
        }
        else{
           scripts.push('    <script src="'+build_asset_link(script)+'?v='+version+'"></script>'); 
        }   
    }

    scripts[0] = scripts[0].trim();
    config_json.scripts = scripts.join("\n");

    var gen_index_html = read_file('samples/index-sample.html');

    var index_props = [
        'app_name', 'asset_url', 'body_class', 'append_body',
        'version', 'scripts', 'styles'
    ];

    if( config_json.hashed_slug ){
        config_json.asset_url = '';
    }
    else{
        config_json.asset_url = app_url + '/';
    }

    for( var i in index_props ){
        var prop = index_props[i];
        if( config_json.hasOwnProperty( prop ) ){
            gen_index_html = gen_index_html.replaceAll( '{{'+prop+'}}', config_json[prop] );
        }
        else{
            gen_index_html = gen_index_html.replaceAll( '{{'+prop+'}}', '' );
        }
    }

    var gen_index_php = gen_index_html.replace('{{site_title}}', `<?php $metas_html = '';
    if( function_exists('aj_page_title_metas') ){
        $metas_html = aj_page_title_metas();
    }
    echo ( $metas_html ? $metas_html : '<title>Default</title>'.PHP_EOL );
    ?>`);
    gen_index_php = `<?php require_once( 'system/functions.php' ); ?>\n`+gen_index_php;

    gen_index_html = gen_index_html.replace('{{site_title}}', '<title>Default</title>');

    aj_write_file(app_dirname+'/index.html', gen_index_html);
    aj_write_file(app_dirname+'/index.php', gen_index_php);

    if( ! file_exists( app_dirname+'/system/functions.php' ) ){

        var str_functions = read_file('samples/php-functions-sample.php');
        str_functions = str_functions.replace('{{server_url}}', config_json.server_url);
        var app_config = aj_get_json( read_file( 'App-Config.json' ) );
        if( app_config ){
            str_functions = str_functions.replace('{{secret_key}}', app_config.secret_key);
        }
        aj_write_file( app_dirname + '/system/functions.php', str_functions );
    }

    if( ! file_exists( app_dirname+'/.htaccess' ) ){
        aj_write_file( app_dirname + '/.htaccess', read_file('samples/.htaccess-sample') );
    }
};

const file_exists = function( file ){
    if( fs.existsSync( file ) ){
        return true;
    }
    return false;
};

const aj_get_json = function( str ){
    try{
        return JSON.parse( str );
    }
    catch( err ){
        return '';
    }
};

const read_file = function( file ){
    if( file_exists( file ) ){
        return fs.readFileSync(file, { encoding: 'utf8', flag: 'r' });
    }
    return '';
};

const aj_write_file = function( path, data ){
    var dir = global.path.dirname( path );
    if( ! file_exists( dir ) ){
        fs.mkdirSync(dir, { recursive: true });
        fs.writeFileSync(path, data);
    }
    else{
        fs.writeFileSync(path, data);
    }
    aj_reload_page();
};

const aj_reload_page = function(){
    //log('Reload page..');  
};

const log = function( str ){
    console.log( str );
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

const build_asset_link = function( src ){
    if( is_full_url( src ) ){
        return src;
    }
    return ( config.hashed_slug ? '' : (app_url + '/') ) + src.replace(/^\/|\/$/g, '');
};

const get_cmd_args = function(){
    var cmd = process.title;
    var action = '';
    var args = '';
    if( cmd.includes('npm test') ){
        args = cmd.replace('npm test', '');
        args = args.trim();
        action = 'test';
    }
    else if( cmd.includes('npm start') ){
        args = cmd.replace('npm start', '');
        args = args.trim();
        action = 'start';
    }
    else if( cmd.includes('npm run') ){
        args = cmd.replace('npm run', '');
        args = args.trim();
        action = 'run';
    }
    else if( cmd.includes('npm build') ){
        args = cmd.replace('npm build', '');
        args = args.trim();
        action = 'build';
    }
    
    return {action: action, args: args};
}

// var Files  = [];

// function ThroughDirectory(Directory) {
//     FS.readdirSync(Directory).forEach(File => {
//         const Absolute = Path.join(Directory, File);
//         if (FS.statSync(Absolute).isDirectory()) return ThroughDirectory(Absolute);
//         else return Files.push(Absolute);
//     });
// }

// ThroughDirectory("./input/directory/");