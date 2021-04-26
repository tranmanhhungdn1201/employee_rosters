@extends('master')
@section('content')

<div class="sidenav">
    <div class="login-main-text">
      <h2>Application<br> Login Page</h2>
      <p>Login or register from here to access.</p>
    </div>
</div>
<div class="main">
    <div class="col-md-6 col-sm-12">
      <div class="login-form">
          <form action="{{route('login')}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label>User Name</label>
                <input type="text" class="form-control" name="username" placeholder="User Name">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-black">Login</button>
            <button type="submit" class="btn btn-secondary">Register</button>
          </form>
      </div>
    </div>
</div>
<script type="text/javascript">
</script>
@endsection