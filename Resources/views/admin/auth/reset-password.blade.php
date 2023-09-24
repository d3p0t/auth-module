@extends('layouts.admin.auth')

@section('content')
    <section class="auth">
        <x-card>
            <h1>Reset password</h1>
            
            @isset($error) 
                <x-alert type="danger">
                    {{ $error }}
                </x-alert>
            @else
                <form method="POST" action="/admin/auth/reset-password">
                    @csrf

                    <x-input name="email" type="email" id="email" label="Email"></x-input>
                    <x-input name="password" type="password" id="password" label="Password"></x-input>
                    <x-input name="password_confirmation" type="password" id="password_confirmation" label="Password confirmation"></x-input>
                    <input type="hidden" name="token" value="{{ $token }}">

                    <button type="submit" class="button button--primary">
                        Login
                    </button>
                </form>
            @endif
        </x-card>
        <div class="actions">
            <a href="/admin/auth/login">
                Back to login
            </a>
        </div>
    </section>
@endsection
