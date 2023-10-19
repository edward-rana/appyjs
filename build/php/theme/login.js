html += ``;
    site_title('Login');
html += `

`+ render('navbar.topbar') +`

<div class="container-fluid p-5 bg-light text-dark text-center mt-3">
    <h1>Login Example</h1>
</div>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="" method="post" onsubmit="return false">
                <div class="mb-3 mt-3">
                    <label for="uname" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="myCheck"  name="remember" required>
                    <label class="form-check-label" for="myCheck">I agree on blabla.</label>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Check this checkbox to continue.</div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" onclick="$(this).closest('form').addClass('was-validated');"><i class="fa fa-send"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>`;