@extends('layouts.authLayout')
@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">

        <div class="card p-4" style="width: 25rem;">
            @if (\Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ \Session::get('error') }}
                </div>
            @endif
            <h3 class="text-center mb-4">Login</h3>
            <form action="{{ route('userLogin') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter your password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
@endsection
