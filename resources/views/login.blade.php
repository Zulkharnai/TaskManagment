<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('public/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('public/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Admin</b>LTE
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="LoginForm">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="user_email" id="user_email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="user_password" id="user_password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div id="show_error" class="" style="display:none;"></div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>

          <!-- /.col -->
          <div class="col-4">
            <button type="button" class="btn btn-primary btn-block" onclick="LoginUser()" id="btnSubmit">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script>
function alertmsg(msg, type) {
    $("#show_error").removeClass().html('').show();
    $("#show_error").addClass(`alert alert-${type} text-center`).html(msg);
    $("#show_error").fadeOut(2000);
}
    function LoginUser() {
        $("#btnSubmit").prop("disabled", true);

        $.post("{{ route('LoginUser') }}", $('#LoginForm').serialize())
            .done((res) => {
                if (res.success) {
                    alertmsg(res.message, "success");
                    if(res.data.user_type == 0){
                        window.location.href = "{{route('Dashboard')}}";
                    }else{
                        window.location.href = "{{route('EmployeeDashboard')}}";
                    }
                    $('#LoginForm')[0].reset();
                } else if (res.validate) {
                    alertmsg(res.message, "warning")
                } else {
                    alertmsg(res.message, "danger")
                }
            })
            .fail((err) => {
                alertmsg("Something went wrong", "danger");
            });
            $("#btnSubmit").prop("disabled", false);
}
</script>
<!-- jQuery -->
<script src="{{url('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('public/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
