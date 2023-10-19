const Config = {
    app_name: '{{app_name}}',
    app_url: '{{app_url}}',
    server_url: '{{server_url}}',
    debug_mode: {{debug_mode}},
    hashed_slug: {{hashed_slug}},
    version: '{{version}}'
}

/***********************************************************
 * Route class..
 *------------------------------------------------------
 */
class RouteCls{
    routes = {};
    query_segments = false;
    route_slug = '';
    add( slug, file ){
        if( slug.substr( -2 ) == '/*' ){
            slug = slug.substr( 0, slug.length - 2 );
            var allow_segs = true;
        }
        else{
            var allow_segs = false;
        }

        this.routes[slug] = {file: file, allow_segs: allow_segs};
        //console.log( this.routes );
    }

    get_uri(){
        if( Config.hashed_slug ){
            var uri = window.location.hash ? window.location.hash.substr(1) : '';
        }
        else{
            var uri = window.location.href.replace( app_url(), '' );
        }

        return uri ? uri.replace(/^\/|\/$/g, '') : uri;
    }

    current_route(){
        var uri = this.get_uri();
        if( uri.includes('?') ){
            uri = uri.split('?')[0];
        }
        var route = this.routes[uri];
        if( route ){
            this.route_slug = uri;
            return route;
        }
        else{
            var tmp_uri = uri;
            for( var i = 0; i < uri.length; i++ ){
                if( tmp_uri == '' ) break;
                tmp_uri = tmp_uri.substr( 0, tmp_uri.lastIndexOf('/') );
                
                if( this.routes[tmp_uri] ){
                    route = this.routes[tmp_uri];
                    if( ! route.allow_segs ){
                        route = false;
                        break;
                    }

                    this.query_segments = uri.substr( tmp_uri.length );
                    if( this.query_segments ){
                        this.query_segments = this.query_segments.replace(/^\/|\/$/g, '').split('/');
                    }
                    else{
                        this.query_segments = false;
                    }
                    this.route_slug = tmp_uri;
                    return route;
                }
            }

            this.route_slug = '404';
            return false;
        }
    }

    get_slug(){
        return this.route_slug;
    }

    query_segs(){
        return this.query_segments;
    }
}

const Route = new RouteCls();

/***********************************************************
 * Set App Routes..
 *------------------------------------------------------
 */
{{router_entries}}