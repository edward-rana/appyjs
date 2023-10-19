<?php defined('BASE_DIR') || exit;
    
    site_title('404 page not found');
    get_header();
?>
<div id="titlebar" class="gradient notfound_mr_bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Page Not Found</h2>
          <nav id="breadcrumbs">
            <ul>
              <li><a href="index_1.html">Home</a></li>
              <li>Page Not Found</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
  
  <div class="not_found_block">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <section id="not-found" class="center">
            <h2>404</h2>
            <p>Page Not Found !</p>
            <div class="utf_error_description_part utf_ferror_description"> <strong class="f-primary animated v fadeInLeft">Sorry, this page does not exist</strong> <span class="f-primary animated v fadeInRight">The link you clicked might be corrupted, or the page may have been removed.</span> </div>

            <div class="row" style="margin-top: 2.3rem;">
                <div class="col-12 text-center">
                    <a href="<?php echo site_url(); ?>" class="button">Goto Homepage</a>
                </div>
            </div>
            <!-- <div class="row">
              <div class="col-lg-6 col-lg-offset-3">
                <div class="main_input_search_part gray-style margin-top-50 margin-bottom-10">
                  <div class="main_input_search_part_item">
                    <input type="text" placeholder="Enter your keyword" value=""/>
                  </div>
                  <button class="button">Search</button>
                </div>
              </div>
            </div> -->
          </section>
        </div>
      </div>
    </div>
  </div>

<?php get_footer(); ?>