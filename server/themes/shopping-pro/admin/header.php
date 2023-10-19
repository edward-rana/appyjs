<?php defined('BASE_DIR') || exit; ?><!DOCTYPE html>
<html lang="zxx">
<head>
<meta name="author" content="">
<meta name="description" content="">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php the_title(); ?></title>

<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon.png">
<!-- Style CSS -->
<link rel="stylesheet" href="<?php echo theme_url('assets/css/stylesheet.css'); ?>">
<link rel="stylesheet" href="<?php echo theme_url('assets/css/mmenu.css'); ?>">
<link rel="stylesheet" href="<?php echo theme_url('assets/css/perfect-scrollbar.css'); ?>">
<link rel="stylesheet" href="<?php echo theme_url('assets/css/style.css'); ?>" id="colors">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800&display=swap&subset=latin-ext,vietnamese" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800" rel="stylesheet" type="text/css">
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
</head>
<body>

<!-- Preloader Start -->
<div class="preloader">
    <div class="utf-preloader">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- Preloader End -->

<!-- Wrapper -->
<div id="main_wrapper"> 
  <header id="header_part" class="fixed fullwidth_block dashboard"> 
    <div id="header" class="not-sticky">
      <div class="container"> 
        <div class="utf_left_side"> 
          <div id="logo"> <a href="index_1.html"><img src="images/logo.png" alt=""></a> <a href="index_1.html" class="dashboard-logo"><img src="images/logo2.png" alt=""></a> </div>
          <div class="mmenu-trigger">
            <button class="hamburger utfbutton_collapse" type="button">
                <span class="utf_inner_button_box">
                    <span class="utf_inner_section"></span>
                </span>
            </button>
          </div>
          <nav id="navigation" class="style_one">
            <ul id="responsive">
              <li><a href="#">Home</a>
                <ul>
                  <li><a href="index_1.html">Home Version 1</a></li>
                  <li><a href="index_2.html">Home Version 2</a></li>
                  <li><a href="index_3.html">Home Version 3</a></li>
                  <li><a href="index_4.html">Home Version 4</a></li>
                  <li><a href="index_5.html">Home Version 5</a></li>
                  <li><a href="index_6.html">Home Version 6</a></li>
                  <li><a href="index_7.html">Home Version 7</a></li>
                </ul>
              </li>           
              <li><a href="#">Listings</a>
                <ul>
                  <li><a href="#">List Layout</a>
                    <ul>
                      <li><a href="listings_list_with_sidebar.html">Listing List Sidebar</a></li>
                      <li><a href="listings_list_full_width.html">Listing List Full Width</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Grid Layout</a>
                    <ul>
                      <li><a href="listings_grid_with_sidebar.html">Listing Grid Sidebar</a></li>
                      <li><a href="listings_two_column_map_grid.html">Listing Two Column Grid</a></li>
                      <li><a href="listings_grid_full_width.html">Listing Grid Full Width</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Half Listing Map</a>
                    <ul>
                      <li><a href="listings_half_screen_map_list.html">Listing Half List</a></li>
                      <li><a href="listings_half_screen_map_grid.html">Listing Half Grid</a></li>
                    </ul>
                  </li> 
                  <li><a href="#">Listing Details</a>
                    <ul>
                      <li><a href="listings_single_page_1.html">Single Listing Version 1</a></li>
                      <li><a href="listings_single_page_2.html">Single Listing Version 2</a></li>
                      <li><a href="listings_single_page_3.html">Single Listing Version 3</a></li>
                      <li><a href="listings_single_page_4.html">Single Listing Version 4</a></li>
                      <li><a href="listings_single_page_5.html">Single Listing Version 5</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li><a class="current" href="#">User Panel</a>
                <ul>
                  <li><a class="active" href="dashboard.html">Dashboard</a></li>
                  <li><a href="dashboard_add_listing.html">Add Listing</a></li>
                  <li><a href="dashboard_my_listing.html">My Listings</a></li>                
                  <li><a href="dashboard_bookings.html">Bookings</a></li>                 
                  <li><a href="dashboard_messages.html">Messages</a></li>
                  <li><a href="dashboard_wallet.html">Wallet</a></li>
                  <li><a href="dashboard_visitor_review.html">Reviews</a></li>
                  <li><a href="dashboard_bookmark.html">Bookmark</a></li>
                  <li><a href="dashboard_my_profile.html">My Profile</a></li>                 
                  <li><a href="dashboard_change_password.html">Change Password</a></li>
                  <li><a href="dashboard_invoice.html">Invoice</a></li>               
                </ul>
              </li>
              <li><a href="#">Blog</a>
                  <ul>
                    <li><a href="blog_page.html">Blog Grid</a></li>
                    <li><a href="blog_page_left_sidebar.html">Blog Left Sidebar</a></li>
                    <li><a href="blog_page_right_sidebar.html">Blog Right Sidebar</a></li>
                    <li><a href="blog_detail_left_sidebar.html">Blog Detail Leftside</a></li>
                    <li><a href="blog_detail_right_sidebar.html">Blog Detail Rightside</a></li>                 
                  </ul>
              </li>
              <li><a href="#">Pages</a>
                <ul>
                  <li><a href="page_about.html">About Us</a></li>
                  <li><a href="#">Categorie Type</a>
                    <ul>
                      <li><a href="page_categorie_one.html">Categorie One</a></li>
                      <li><a href="page_categorie_two.html">Categorie Two</a></li>                      
                    </ul>   
                  </li>
                  <li><a href="add_listing.html">Add Listing</a></li>
                  <li><a href="listing_booking.html">Booking Listing</a></li>
                  <li><a href="page_pricing.html">Pricing Plan</a></li>     
                  <li><a href="wishlist_listings.html">Wishlist Page</a></li>   
                  <li><a href="page_filtering_style.html">Filtering Style</a></li>              
                  <li><a href="typography.html">Typography</a></li>
                  <li><a href="page_element.html">Page Element</a></li>
                  <li><a href="page_faqs.html">Page Faq</a></li>            
                  <li><a href="#">Icons</a>
                    <ul>
                      <li><a href="page_icons_one.html">Icon-Mind Icon</a></li>
                      <li><a href="page_icons_two.html">Simple Line Icon</a></li>
                      <li><a href="page_icons_three.html">Font Awesome Icon</a></li>
                    </ul>
                  </li> 
                  <li><a href="page_not_found.html">Page Error 404</a></li>
                  <li><a href="page_coming_soon.html">Coming Soon</a></li>                  
                  <li><a href="contact.html">Contact</a></li>
                </ul>
              </li>              
            </ul>
          </nav>
          <div class="clearfix"></div>
        </div>
        <div class="utf_right_side"> 
          <div class="header_widget"> 
            <div class="dashboard_header_button_item has-noti js-item-menu">
                <i class="sl sl-icon-bell"></i>
                <div class="dashboard_notifi_dropdown js-dropdown">
                    <div class="dashboard_notifi_title">
                        <p>You Have 2 Notifications</p>
                    </div>
                    <div class="dashboard_notifi_item">
                        <div class="bg-c1 red">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="content">
                            <p>Your Listing <b>Burger House (MG Road)</b> Has Been Approved!</p>
                            <span class="date">2 hours ago</span>
                        </div>
                    </div>
                    <div class="dashboard_notifi_item">
                        <div class="bg-c1 green">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="content">
                            <p>You Have 7 Unread Messages</p>
                            <span class="date">5 hours ago</span>
                        </div>
                    </div>
                    <div class="dashboard_notify_bottom text-center pad-tb-20">
                        <a href="#">View All Notification</a>
                    </div>
                </div>
            </div>
            <div class="utf_user_menu">
              <div class="utf_user_name"><span><img src="images/dashboard-avatar.jpg" alt=""></span>Hi, John!</div>
              <ul>
                <li><a href="dashboard.html"><i class="sl sl-icon-layers"></i> Dashboard</a></li>
                <li><a href="dashboard_my_profile.html"><i class="sl sl-icon-user"></i> My Profile</a></li>
                <li><a href="dashboard_my_listing.html"><i class="sl sl-icon-list"></i> My Listing</a></li>
                <li><a href="dashboard_messages.html"><i class="sl sl-icon-envelope-open"></i> Messages</a></li>
                <li><a href="dashboard_bookings.html"><i class="sl sl-icon-docs"></i> Booking</a></li>
                <li><a href="index_1.html"><i class="sl sl-icon-power"></i> Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="clearfix"></div>

    <!-- Dashboard -->
  <div id="dashboard"> 
    <a href="#" class="utf_dashboard_nav_responsive"><i class="fa fa-reorder"></i> Dashboard Sidebar Menu</a>
    <div class="utf_dashboard_navigation js-scrollbar">
      <div class="utf_dashboard_navigation_inner_block">
        <ul>
          <li class="active"><a href="<?php echo site_url('/admin'); ?>"><i class="sl sl-icon-layers"></i> Dashboard</a></li>       
          <li><a href="dashboard_add_listing.html"><i class="sl sl-icon-plus"></i> Add Listing</a></li>           
          <li>
            <a href="#"><i class="sl sl-icon-layers"></i> Listings</a>
            <ul>
                <li><a href="<?php echo site_url('/admin/listings'); ?>">All Listings <span class="nav-tag green">10</span></a></li>
                <li><a href="dashboard_my_listing.html">Active <span class="nav-tag green">10</span></a></li>
                <li><a href="dashboard_my_listing.html">Pending <span class="nav-tag yellow">4</span></a></li>
            </ul>   
          </li>              
          <li><a href="dashboard_bookings.html"><i class="sl sl-icon-docs"></i> Bookings</a></li>         
          <li><a href="dashboard_messages.html"><i class="sl sl-icon-envelope-open"></i> Messages</a></li>
          <li><a href="dashboard_wallet.html"><i class="sl sl-icon-wallet"></i> Wallet</a></li>                 
          <li>
            <a href="#"><i class="sl sl-icon-star"></i> Reviews</a>
            <ul>
                <li><a href="dashboard_visitor_review.html">Visitor Reviews <span class="nav-tag green">4</span></a></li>
                <li><a href="dashboard_submitted_review.html">Submitted Reviews <span class="nav-tag yellow">5</span></a></li>                  
            </ul>   
          </li>       
          <li><a href="dashboard_bookmark.html"><i class="sl sl-icon-heart"></i> Bookmark</a></li>                                           
          <li><a href="dashboard_my_profile.html"><i class="sl sl-icon-user"></i> My Profile</a></li>
          <li><a href="dashboard_change_password.html"><i class="sl sl-icon-key"></i> Change Password</a></li>
          <li><a href="index_1.html"><i class="sl sl-icon-power"></i> Logout</a></li>
        </ul>
      </div>
    </div>
    <div class="utf_dashboard_content">
        <div id="titleba" class="dashboard_gradient">
            <div class="row">
              <div class="col-md-12">
                <nav id="breadcrumbs" style="text-align: left;">
                  <ul>
                    <li><a href="<?php echo site_url('/admin'); ?>">Dashboard</a></li>
                    <li><?php echo app()->get_option('site_title'); ?></li>
                  </ul>
                </nav>
              </div>
            </div>
      </div>