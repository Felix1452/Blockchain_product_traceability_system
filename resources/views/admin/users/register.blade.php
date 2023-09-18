
<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="#">
            <b>ĐĂNG KÍ</b>
            <img style="width: 20%" src="/template/images/icons/logo-01.png" alt="IMG-LOGO"></a>
    </div>
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Đăng ký thành viên mới</p>
            @include('admin.alert')
            <form action="/admin/users/register/store" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Full name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" name="mobile" placeholder="Số điện thoại">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="repass" placeholder="Retype password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                    </div>
                    @csrf
                </div>
            </form>
        </div>
        <a href="<?php echo route('login')?>" class="btn btn-light">Tôi đã có tài khoản</a>

    </div>
</div>
@include('admin.footer')
</body>
</html>

