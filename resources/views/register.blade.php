@extends('layouts.master')

@section('title', 'Eco Bohol - Register')

@section('header')

@stop

@section('content')
<div>
    <div class="flex flex-col justify-center items-center h-screen bg-green-200">
        <form action="/register" method="POST"
            class="justify-center items-center w-1/2 bg-white shadow-md rounded-md p-5">
            <h1 class="text-4xl mb-10 text-center">Register</h1>
            @csrf
            <div class="flex space-x-4 mb-5">
                <div>
                    <div class="w-full">
                        <label for="name">Username</label>
                        <input class="login-input mb-2" type="text" name="name">
                        @error('name')
                        <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label>Email</label>
                        <input class="login-input mb-2" type="text" name="email">
                        @error('email')
                        <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label>Password</label>
                        <input class="login-input mb-2" type="password" name="password">
                        <label>Confirm Password</label>
                        <input class="login-input mb-2" type="password" name="password_confirmation">
                        @error('password')
                        <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    {{-- <div class="text-left w-full mb-2">
                        <label for="office">Office</label>
                        <input class="login-input" type="text" name="office" id="office">
                    </div> --}}
                    <div class="text-left w-full mb-2">
                        <label for="position">Position</label>
                        <input class="login-input" type="text" name="position" id="position">
                    </div>
                    <div class="text-left w-full mb-2">
                        <label for="user_role">Register as:</label>
                        <select class="login-input" name="user_role" id="user_role">
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="officer">Officer</option>
                            <option value="researcher">Researcher</option>
                        </select>
                        <em class="text-sm">Subject for review by administration.</em>
                    </div>
                </div>
            </div>
            <button class="primary-btn w-full text-white" type="submit">Register</button>
        </form>
        <a href="/" class="mt-2">Back to Homepage</a>
    </div>
</div>

@stop