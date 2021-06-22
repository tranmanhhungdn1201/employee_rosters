@extends('master')
@section('content')
<div class="row container-login justify-content-center">
      <div class="form-login col-md-7 col-lg-5 card">
          <h3 class="form-login__title">Đăng nhập</h3>
          <form action="{{route('login')}}" method="POST">
            {{ csrf_field() }}
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="username-addon"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" class="form-control" name="username" placeholder="Tài khoản" aria-label="Tài Khoản" aria-describedby="username-addon">
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="password-addon"><i class="fas fa-lock"></i></span>
              </div>
              <input type="password" name="password" class="form-control" placeholder="Mật khẩu" aria-label="Mật khẩu" aria-describedby="password-addon">
            </div>
            <!-- <div class="form-group">
                <label>User Name</label>
                <input type="text" class="form-control" name="username" placeholder="User Name">
            </div> -->
            <!-- <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div> -->
            <div class="row mb-4 align-items-center">
                <div class="col-6">
                    <a href="">Quên mật khẩu</a>
                </div>
                <div class="col-6 text-right">
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                Chưa có tài khoản?<a href="">Đăng kí</a>
            </div>
            <!-- <div class="row justify-content-center">
                <a href="">Quên mật khẩu</a>
            </div> -->
            <!-- <button type="submit" class="btn btn-secondary">Register</button> -->
          </form>
      </div>
    </div>
</div>
<script type="text/javascript">
</script>
@endsection