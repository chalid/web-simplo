@extends('layouts.backend.auth')

@section('content')
<!-- Card -->
<div class="card smooth-shadow-md">
    <!-- Card body -->
    <div class="card-body p-6">
        <div class="mb-4">
            <a href="/">
                <img src="{{ asset('assets/backend/images/logo/logo.png') }}" class="mb-2 text-inverse" width="100" alt="{{ config('app.name', 'Laravel') }}">
            <p class="mb-6">{{ __('Email Address') }}</p>
        </div>
        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Username -->
                <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address here" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!-- Password -->
                <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="**************" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!-- Checkbox -->
                <div class="d-lg-flex justify-content-between align-items-center mb-4">
                <div class="form-check custom-checkbox">
                    <input type="checkbox" class="form-check-input" id="rememberme">
                    <label class="form-check-label" for="rememberme">Remember me</label>
                </div>
            </div>
            <div>
                <!-- Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </div>
                <div class="d-md-flex justify-content-between mt-4">
                    @if (Route::has('register'))
                    <div class="mb-2 mb-md-0">
                        <a href="{{ route('register') }}" class="fs-5">Create An Account </a>
                    </div>
                    @endif
                    @if (Route::has('password.request'))
                    <div>
                        <a class="text-inherit fs-5" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
