html += ``;
    site_title('404 not found');
html += `
`+ render('navbar.topbar') +`

<div class="container-fluid p-5 bg-light text-dark text-center mt-3">
    <h1>404 not found</h1>
    <a href="`+ app_url() +`"><i class="fa fa-home"> Homepage</i></a>
</div>`;