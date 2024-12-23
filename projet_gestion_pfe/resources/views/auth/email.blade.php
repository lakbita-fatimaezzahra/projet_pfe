@extends('layouts.app')

@section('content')
<div class="reset-container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="reset-form" style="background-color: rgba(9, 112, 0, 0.7); padding: 30px; border-radius: 10px; width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Reset Your Password</h2>
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
        </form>
    </div>
</div>
@endsection
