$(function(){
    let page = Route.current_router();
    $('.nav-link[href="#'+page+'"]').addClass('active');
});