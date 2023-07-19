@extends('layouts.master')

@section('title', 'Eco Bohol - Login')

@section('header')

@stop

@section('content')
<div>
    <div class="flex flex-col justify-center items-center h-screen bg-green-700">
        <form action="/login" method="POST"
            class="flex flex-col justify-center items-center w-3/4 md:w-1/2 lg:w-1/5 bg-white shadow-md rounded-md p-5">
            <img src="/static/img/EcoBohol.png" alt="">
            {{-- <h1 class="text-xl md:text-2xl lg:text-4xl font-semibold mb-10">Eco Bohol Login</h1> --}}
            @csrf
            <div class="w-full">
                <label>Email</label>
                <input class="login-input mb-2" type="text" name="email" value="{{ old('email') }}">
                @error('email')
                <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full mb-5">
                <label>Password</label>
                <input class="login-input mb-2" type="password" name="password">
                @error('password')
                <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <button class="primary-btn w-full text-white" type="submit">Login</button>
            <a href="/stakeholder/register" class=" mt-5 text-lg text-blue-400
                hover:text-blue-600 hover:underline">Register as
                Stakeholder</a>
            {{-- <button class="primary-btn w-full text-white" type="submit">Login</button> --}}
        </form>
        <a href="/" class="mt-2 text-white">Back to Homepage</a>
    </div>
</div>

@stop