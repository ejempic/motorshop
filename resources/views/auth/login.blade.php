@extends('layouts.app')

@section('content')

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">MT</h1>

            </div>
            <h3>Welcome to {{config('app.name')}}</h3>
            <p>
            </p>
            <p>Login in to test Site</p>
            <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input id="username" type="text"
                           class="form-control @error('email') is-invalid @enderror" name="username" placeholder="Username"
                           value="{{ old('username') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password"
                           required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

{{--                <a href="#"><small>Forgot password?</small></a>--}}
{{--                <p class="text-muted text-center"><small>Do not have an account?</small></p>--}}
{{--                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>--}}
            </form>
            <p class="m-t"><small>Project by Earl Empic © 2021</small></p>
        </div>
    </div>
@endsection
