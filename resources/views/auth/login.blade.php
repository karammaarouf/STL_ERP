<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layouts.partials.head')
</head>

<body class="rtl">
    <!-- Loader starts-->
    @include('layouts.partials.loader')
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    @include('layouts.partials.messages')
    <section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-card">
                        <form class="theme-form login-form text-right" method="post" action="{{ route('login') }}">
                            @csrf
                            <h4>{{ __('Login') }}</h4>
                            <h6>{{ __('Welcome back! Log in to your account.') }}</h6>
                            <div class="form-group">
                                <label>{{ __('Email Address') }}</label>
                                <div class="input-group"><span class="input-group-text"><i
                                            class="icon-email"></i></span>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" required="" placeholder="Test@gmail.com"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Password') }}</label>
                                <div class="input-group form-input"><span class="input-group-text"><i
                                            class="icon-lock"></i></span>
                                    <input class="form-control @error('email') is-invalid @enderror" type="password"
                                        name="password" required="" placeholder="*********">
                                    <div class="show-hide" style="right: auto; left: 30px;"><span class="show"></span></div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input id="checkbox1" type="checkbox">
                                    <label for="checkbox1">{{ __('Remember password') }}</label>
                                </div><a class="link" href="">{{ __('Forgot password?') }}</a>

                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">{{ __('Sign in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- latest jquery-->
    @include('layouts.partials.scripts')
</body>

</html>
