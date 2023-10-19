RD.add_part( "navbar.topbar", `\`\`+ function(){ var attr_data = undefined; var data = ( ( ! parsed_data ) ? attr_data : parsed_data ); var html = \`
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark shadow" onrender="activate_current_navlink();">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: gold" onclick="redirect('#'); return false;">AppyJS<\/a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"><\/span>
            <\/button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="\`+ page_url() +\`" onclick="redirect('\`+ page_url() +\`'); return false;"><i class="fa fa-home"><\/i> Home<\/a>
                    <\/li>
                    <li class="nav-item">
                        <a class="nav-link" href="\`+ page_url('login') +\`" onclick="redirect('\`+ page_url('login') +\`'); return false;">Login<\/a>
                    <\/li>
                    <li class="nav-item">
                        <a class="nav-link" href="\`+ page_url('item-list') +\`" onclick="redirect('\`+ page_url('item-list') +\`'); return false;">Item List<\/a>
                    <\/li>
                    <li class="nav-item">
                        <a class="nav-link" href="\`+ page_url('single-item?id=2') +\`" onclick="redirect('\`+ page_url('single-item?id=2') +\`'); return false;">Item Single<\/a>
                    <\/li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" onclick="redirect('javascript:void(0);'); return false;">Dropdown<\/a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="redirect('#'); return false;">Link<\/a><\/li>
                            <li><a class="dropdown-item" href="#" onclick="redirect('#'); return false;">Another link<\/a><\/li>
                            <li><a class="dropdown-item" href="#" onclick="redirect('#'); return false;">A third link<\/a><\/li>
                        <\/ul>
                    <\/li>
                <\/ul>
            <\/div>
        <\/div>
    <\/nav>
\`; return html; }();` );html += `

`;
    const activate_current_navlink = function(){
        let page = page_url( Route.get_slug() );
        //console.log( page );
      
        $('.nav-link[href="'+page+'"]').addClass('active');
    }
html += ``;