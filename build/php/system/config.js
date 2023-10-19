const Config = {
    app_name: 'AppyJS',
    server_url: 'http://localhost:81/shopping-pro/server',
    debug_mode: true,
    version: '1.0.0'
}

/***********************************************************
 * Route class..
 *------------------------------------------------------
 */
class RouteCls{
    routers = {};
    add( slug, file ){
        this.routers[slug] = file;
        //console.log( this.routers );
    }

    get_uri(){
        if( window.location.hash ){
            return window.location.hash.substr(1);
        }
        else{
            return '';
        }
    }

    current_router(){
        let router = this.routers[this.get_uri()];
        if( router ){
            return router;
        }
        else{
            return false;
        }
    }

    real_slug(){
        const nextURL = 'http://localhost:81/shopping-pro/app/page_b';
        const nextTitle = 'My new page title';
        const nextState = { additionalInformation: 'Updated the URL with JS' };
        try{
            // This will create a new entry in the browser's history, without reloading
            window.history.pushState(nextState, nextTitle, nextURL);

            // This will replace the current entry in the browser's history, without reloading
            window.history.replaceState(nextState, nextTitle, nextURL);
        }
        catch(e){

        }
    }
}

const Route = new RouteCls();

Route.add("", "home");
Route.add("login", "login");
Route.add("item-list", "item-list");