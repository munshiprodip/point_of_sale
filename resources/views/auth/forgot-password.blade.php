@extends("layouts.auth")

@section('content')
    <h3 class="mb-1 fw-bold">Forgot Password? 🔒</h3>
    <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required autofocus>
        </div>
        <button class="btn btn-primary d-grid w-100">Send Password Reset Link</button>
    </form>
    <div class="text-center">
        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
            <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
            Back to login
        </a>
    </div>
@endsection
