@extends('layouts.public.master')

@section('content') 
    <section class="auth">
        <x-card>
            <h1>Login</h1>
            @if (session('status'))
                <x-alert type="success">
                    {{ session('status') }}
                </x-alert>
            @endif
            @include('auth::partials.login', ['action' => '/auth/login'])
        </x-card>
        <div class="actions">
            <a href="/auth/forgot-password">Forgot password ? </a>
        </div>
    </section>
@endsection
