<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader();
  </script>
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="./" class="h1"><b>Login</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form id="login-frm" action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <a href="<?php echo base_url ?>">Go to Website</a>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script>
    $(document).ready(function() {
      end_loader();
      $('#login-frm').submit(function(e) {
        e.preventDefault();
        start_loader();
        $.ajax({
          url: '../classes/Login.php?f=login',
          data: $(this).serialize(),
          method: 'POST',
          dataType: 'json',
          error: function(err) {
            console.error('AJAX Error Details:', {
              status: err.status,
              statusText: err.statusText,
              responseText: err.responseText
            });
            alert_toast('An error occurred: ' + err.status + ' ' + err.statusText, 'error');
            end_loader();
          },
          success: function(resp) {
            console.log('Server Response:', resp);
            if (resp.status === 'success') {
              location.href = resp.redirect;
            } else if (resp.status === 'incorrect') {
              alert_toast(resp.message, 'danger');
              end_loader();
            } else {
              alert_toast('Unexpected response: ' + JSON.stringify(resp), 'warning');
              end_loader();
            }
          }
        });
      });
    });
  </script>
</body>
</html>   