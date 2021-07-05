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
              <input type="text" class="form-control" name="username" placeholder="Tài khoản" aria-label="Tài Khoản" aria-describedby="username-addon" required>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="password-addon"><i class="fas fa-lock"></i></span>
              </div>
              <input type="password" name="password" class="form-control" placeholder="Mật khẩu" aria-label="Mật khẩu" aria-describedby="password-addon" required>
            </div>
            @if($errors->any())
            <div class="text-center">
              <span class="text-danger">{{$errors->first()}}</span>
            </div>
            @endif
            <div class="row mb-4 align-items-center">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </div>
            </div>
           
          </form>
      </div>
    </div>
</div>
<script type="text/javascript">
</script>
@endsection