@extends('layouts.layout')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Welcome, {{ auth()->user()->name }}!</h2>
@endsection
