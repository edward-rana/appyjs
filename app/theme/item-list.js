html += ``;
    site_title('Item list');
    load_css('theme/assets/css/item-list');
    html += render('navbar.topbar');
    console.log( Route.query_segs() );
html += `

<div class="container-fluid p-5 bg-light text-dark text-center mt-3">
    <h1>Item List Example</h1>
</div>

<div class="container-fluid my-3">
    <div class="row g-2">
        <div class="col-md-3 px-3">
            `+ render( 'sidebar_item_list.default' ) +`
        </div>
        <div class="col-md-9 px-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="product py-4">
                        <span class="off bg-success">-25% OFF</span> 
                        <div class="text-center"> <img src="https://i.imgur.com/nOFet9u.jpg" width="200"> </div>
                        <div class="about text-center">
                            <h5>XRD Active Shoes</h5>
                            <span>$1,999.99</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product py-4">
                        <span class="off bg-warning">SALE</span> 
                        <div class="text-center"> <img src="https://i.imgur.com/VY0R9aV.png" width="200"> </div>
                        <div class="about text-center">
                            <h5>Hygen Smart watch </h5>
                            <span>$123.43</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product py-4">
                        <div class="text-center"> <img src="https://i.imgur.com/PSGrLdz.jpg" width="200"> </div>
                        <div class="about text-center">
                            <h5>Acer surface book 2.5</h5>
                            <span>$1,999.99</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product py-4">
                        <span class="off bg-success">-10% OFF</span> 
                        <div class="text-center"> <img src="https://i.imgur.com/OdRSpXG.jpg" width="200"> </div>
                        <div class="about text-center">
                            <h5>Dell XPS Surface</h5>
                            <span>$1,245.89</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product py-4">
                        <!-- <span class="off bg-success">-25% OFF</span> --> 
                        <div class="text-center"> <img src="https://i.imgur.com/X2AwTCY.jpg" width="200"> </div>
                        <div class="about text-center">
                            <h5>Acer surface book 5.5</h5>
                            <span>$2,999.99</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product py-4">
                        <span class="off bg-success">-5% OFF</span> 
                        <div class="text-center"> <img src="https://i.imgur.com/QQwcBpF.png" width="200"> </div>
                        <div class="about text-center">
                            <h5>Xps smart watch 5.0</h5>
                            <span>$999.99</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product py-4">
                        <span class="off bg-warning">SALE</span> 
                        <div class="text-center"> <img src="https://i.imgur.com/PSGrLdz.jpg" width="200"> </div>
                        <div class="about text-center">
                            <h5>Acer surface book 8.5</h5>
                            <span>$3,999.99</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product py-4">
                        <div class="text-center"> <img src="https://i.imgur.com/m22OQy9.jpg" width="200"> </div>
                        <div class="about text-center">
                            <h5>Tyko Running shoes</h5>
                            <span>$99.99</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product py-4">
                        <div class="text-center"> <img src="https://i.imgur.com/OdRSpXG.jpg" width="200"> </div>
                        <div class="about text-center">
                            <h5>Dell surface book 5</h5>
                            <span>$1,999.99</span> 
                        </div>
                        <div class="cart-button mt-3 px-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary text-uppercase">Add to cart</button> 
                            <div class="add"> <span class="product_fav"><i class="fa fa-heart-o"></i></span> <span class="product_fav"><i class="fa fa-opencart"></i></span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`;