@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> 
            <div class="card">
             {{--  <div class="card-header">{{ __('CertAuth') }} <span class="badge badge-light">PoC</span></div>  --}}
             <div class="card-header">
                 <h1><i class="fas fa-copyright"></i>ertAuth</h1>
            </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right"><i class="fas fa-envelope"></i> {{ __('') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username: Demo" name="username" value="{{ old('username') }}" required autofocus>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><i class="fas fa-key"></i> {{ __('') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password: demo123" name="password" required>
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
                                    <input id="otc" type="password" class="form-control{{ $errors->has('otc') ? ' is-invalid' : '' }}" placeholder="One-Time-Code: 0000" name="otc" required>
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
                        <div><i class="fas fa-code-branch"></i> 1.0</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
