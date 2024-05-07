<?php
require_once ("../db/connect.php");

$titlePage = "เข้าสู่ระบบ";

if(!empty($_SESSION["adm_id"])){
  header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("includes/head.php"); ?>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a class="h3"><b>เข้าสู่ระบบ</b></a>
      </div>
      <div class="card-body">
        <form id="form" action="login_chk.php" method="POST">
          <div class="form-group mb-3">
            <label class="form-label" for="adm_username">ชื่อผู้ใช้ หรือ อีเมล : </label><span class="text-danger">*</span>
            <input class="form-control" type="text" name="adm_username" placeholder="กรุณากรอกชื่อผู้ใช้ หรือ อีเมล">
          </div>
          <div class="form-group mb-3">
            <label for="adm_password" class="form-label">รหัสผ่าน : </label><span class="text-danger">*</span>
            <div class="input-group">
              <input type="password" class="form-control" name="adm_password" placeholder="กรุณากรอกรหัสผ่าน">
              <button class="btn btn-outline-secondary password-toggle" type="button">
                <i class="fa-solid fa-eye-slash"></i>
              </button>
            </div>
          </div>
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
            <div class="col-12">
              <button type="submit" name="btn-login" class="btn btn-primary btn-block">เข้าสู่ระบบ</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <p class="mb-1">
          <a href="forgot-password.html">ลืมรหัสผ่าน?</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <?php require_once("includes/vendor.php"); ?>
  <!-- Show/Hidden Password  -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const passwordToggles = document.querySelectorAll('.password-toggle');

      passwordToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
          const passwordField = this.previousElementSibling;
          const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordField.setAttribute('type', type);

          const icon = this.querySelector('i');
          icon.classList.toggle('fa-eye-slash', type === 'password');
          icon.classList.toggle('fa-eye', type !== 'password');
        });
      });
    });
  </script>

  <!-- Validate Form -->
  <script>
    $(function() {
      $('#form').validate({
        rules: {
          adm_username: {
            required: true,
          },
          adm_password: {
            required: true,
          },
        },
        messages: {
          adm_username: {
            required: "กรุณากรอก ชื่อผู้ใช้ ของท่าน",
          },
          adm_password: {
            required: "กรุณากรอก รหัสผ่าน ของท่าน",
          },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
</body>

</html>
<!-- หากเกิด Error จากฝั่ง server  -->
<?php require_once("includes/sweetalert2.php"); ?>