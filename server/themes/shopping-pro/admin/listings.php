<?php defined('BASE_DIR') || exit;

    site_title('Listings');
    get_header();
?>

<div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
          <div class="utf_dashboard_list_box table-responsive recent_booking">
            <!-- <h4>Recent Booking</h4> -->
            <form>
                <div class="filter-box row" style="padding: 5px 15px;">
                    <div class="col-md-4">
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option>All</option>
                            <option>Active</option>
                            <option>Pending</option>
                            <option>Expired</option>
                        </select>
                        <button type="submit" class="button" style="margin-top: 2.8rem;">Filter</button>
                    </div>
                    <div class="col-md-4">
                        
                    </div>
                </div>
            </form>
            <div class="dashboard-list-box table-responsive invoices with-icons">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="checkboxes"><input id="listing_h" type="checkbox"><label for="listing_h" style="margin-bottom: 20px;"></label></th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Booking Date</th>
                    <th>Payment Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="checkboxes"><input id="listing_2" type="checkbox"><label for="listing_2" style="margin-bottom: 20px;"></label></td>
                    <td><img alt="" class="img-fluid rounded-circle shadow-lg" src="images/thumb-1.jpg" width="50" height="50"></td>
                    <td>Kathy Brown</td>
                    <td>12 Jan 2022</td>
                    <td>Paypal</td>
                    <td><span class="badge badge-pill badge-primary text-uppercase">Booked</span></td>
                    <td style="display: flex;">
                        <a href="dashboard_bookings.html" title="View" class="button">View</a>
                        <a href="dashboard_bookings.html" title="Edit" class="button" style="margin-left: 1rem; background: green;">Edit</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>

<?php get_footer(); ?>