@extends('layouts.master')

@section('content') 
    <section class="auth">
        <x-card>
            <h1>Login</h1>
            @if (session('status'))
                <x-alert type="success">
                    {{ session('status') }}
                </x-alert>
            @endif

            <form method="POST" action="/auth/login">
                @csrf

                <x-input name="username" type="text" label="Username"></x-input>
                <x-input name="password" type="password" label="Password"></x-input>

                <button type="submit" class="button button--primary">
                    Login
                </button>
            </form>
        </x-card>
        <div class="actions">
            <a href="/auth/forgot-password">Forgot password ? </a>
        </div>
    </section>
@endsection
