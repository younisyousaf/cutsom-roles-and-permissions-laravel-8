@extends('layouts.layout')

@section('content')
    <div class="d-flex justify-content-center align-items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Welcome, {{ auth()->user()->name }}!</h2>
    </div>
@endsection
