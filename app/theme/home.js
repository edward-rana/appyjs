html += ``;
    site_title('Home');
html += `

`+ render('navbar.topbar') +`

<div class="container-fluid p-5 bg-light text-dark text-center mt-3">
    <h3>Wow! AppyJS-v`+ Config.version +` Bootstrap Page</h3>
    <p class="mb-1">Resize this responsive page to see the effect!</p>
    <i class="text-muted" style="font-size: 0.8rem;">Toggle device toolbar on your browser to check mobile view.</i>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-4">
            <h3>Column 1</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
        </div>
        <div class="col-sm-4">
            <h3>Column 2</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
        </div>
        <div class="col-sm-4">
            <h3>Column 3</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
        </div>
    </div>
</div>`;