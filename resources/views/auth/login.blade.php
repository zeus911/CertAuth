@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
             {{--  <div class="card-header">{{ __('CertAuth') }} <span class="badge badge-light">PoC</span></div>  --}}
             <div class="card-header"><h2><span class="badge badge-light">CertAuth PoC</span></h2></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><i class="fas fa-envelope"></i> {{ __('') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="E-Mail Address" name="email" value="{{ old('email') }}" required autofocus>
                                <p class="text-danger">User: admin@example.com</p>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><i class="fas fa-key"></i> {{ __('') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>
                                <p class="text-danger">Password: 123456</p>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="otc" class="col-md-4 col-form-label text-md-right"><i class="fas fa-key"></i> {{ __('') }}</label>

                                <div class="col-md-6">
                                    <input id="otc" type="password" class="form-control{{ $errors->has('otc') ? ' is-invalid' : '' }}" placeholder="One-Time-Code" name="otc" required>
                                    <p class="text-danger">Demo OTC: 0000</p>
                                    @if ($errors->has('otc'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('otc') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


{{--                         <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
 --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                                </button>

                                {{--  @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif  --}}
                            </div>
                        </div>
                        <div><i class="fas fa-code-branch"></i> 0.2</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
