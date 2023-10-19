RD.add_part( "navbar.topbar", `\`\`+ function(){ var attr_data = undefined; var data = ( ( ! parsed_data ) ? attr_data : parsed_data ); var html = \`
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark shadow" onrender="activate_current_navlink();">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: gold">AppyJS<\/a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"><\/span>
            <\/button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-home"><\/i> Home<\/a>
                    <\/li>
                    <li class="nav-item">
                        <a class="nav-link" href="#login">Login<\/a>
                    <\/li>
                    <li class="nav-item">
                        <a class="nav-link" href="#item-list">Item List<\/a>
                    <\/li>
                    <li class="nav-item">
                        <a class="nav-link" href="#item-single?item_id=1">Item Single<\/a>
                    <\/li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">Dropdown<\/a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Link<\/a><\/li>
                            <li><a class="dropdown-item" href="#">Another link<\/a><\/li>
                            <li><a class="dropdown-item" href="#">A third link<\/a><\/li>
                        <\/ul>
                    <\/li>
                <\/ul>
            <\/div>
        <\/div>
    <\/nav>
\`; return html; }();` );html += `

`;
    const activate_current_navlink = function(){
        let page = Route.get_uri();
      
        $('.nav-link[href="#'+page+'"]').addClass('active');
    }
html += ``;