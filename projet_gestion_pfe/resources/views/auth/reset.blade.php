@extends('layouts.app')

@section('content')
<div class="reset-container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="reset-form" style="background-color: rgba(255, 255, 255, 0.7); padding: 30px; border-radius: 10px; width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Reset Your Password</h2>
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
            </div>

            <button type="submit" 
            class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition">
Reset    </button>        </form>
    </div>
</div>
@endsection
