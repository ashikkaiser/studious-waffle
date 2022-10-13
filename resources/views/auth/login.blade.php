<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />

    <!-- step 1 css -->
    <link rel="stylesheet" href="/assets/css/step1.css" />

    <!-- login css  -->
    <link rel="stylesheet" href="/assets/css/login.css" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <style>
        .is-invalid {
            border: 1px solid red !important;
        }
    </style>
    <title>Login /Signup</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="login-area">
                    <a href="/">
                        <div class="login-logo">
                            <img src="{{ site()->logo }}" class="img-fluid" alt="" />
                            <p>For tradespeople</p>
                        </div>
                    </a>
                    {{-- @php
                        dd($errors);
                    @endphp --}}
                    <div class="login-btn-area">
                        <button class="sign-btn" data-bs-target="#singIn" data-bs-toggle="modal">
                            Log in
                        </button>
                        <div class="modal" id="singIn" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sign In</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form class="modal-form" action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                placeholder="email" value="{{ old('email') }}" required
                                                autocomplete="email" autofocus>
                                            <label for="">Your Email...</label>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password"
                                                placeholder="password">



                                            <label for="">Your Password...</label>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <button class="sub-btn">Log In</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <p>Not a Checkatrade member?</p>
                        <h6 data-bs-target="#singUp" data-bs-toggle="modal">Create account</h6>
                        <div class="modal" id="singUp" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Create account</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form class="modal-form" action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="first_name" class="form-control"
                                                placeholder="First Name" value="{{ old('first_name') }}" />
                                            <label for="">Your First Name...</label>
                                            @if ($errors->has('first_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" required name="last_name"
                                                value="{{ old('last_name') }}" class="form-control"
                                                placeholder="Last Name" />
                                            <label for="">Your Last Name...</label>
                                            @if ($errors->has('last_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" required name="email" value="{{ old('email') }}"
                                                class="form-control" placeholder="Email" />
                                            <label for="">Your Email...</label>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="tel" required name="phone"
                                                value="{{ old('phone') }}" class="form-control"
                                                placeholder="Phone" />
                                            <label for="">Your Phone...</label>
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="post_code" value="{{ old('post_code') }}"
                                                id="post_code" class="form-control" placeholder="Post Code" />
                                            <label for="">Your Postalcode...</label>
                                            @if ($errors->has('post_code'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('post_code') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" required name="password" class="form-control"
                                                placeholder="Password" />
                                            <label for="">Your Password...</label>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <button class="sub-btn" type="submit" href="step2.html">Sign Up</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Boostrap Jquery -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Js -->
    <script src="/assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('#post_code').on('keyup', function() {
                var post_code = $(this).val();
                console.log(post_code)
                const isValidate = isValidUKPostcode(post_code);
                if (isValidate.error) {
                    $('#post_code').addClass('is-invalid');
                    $('#post_code').removeClass('is-valid');
                } else {
                    $('#post_code').addClass('is-valid');
                    $('#post_code').removeClass('is-invalid');
                    $('#post_code').val(isValidate.formatedPostCode);
                }


            });
        });
    </script>

</body>

</html>




{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
