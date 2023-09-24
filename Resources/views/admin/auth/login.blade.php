@extends('layouts.admin.auth')

@section('content') 
    <section class="auth">
        <x-card>
            <h1>Login</h1>
            @if (session('status'))
                <x-alert type="success">
                    {{ session('status') }}
                </x-alert>
            @endif

            @include('auth::partials.login', ['action' => '/admin/auth/login', 'redirect' => App\Providers\RouteServiceProvider::ADMIN ])

        </x-card>
        <div class="actions">
            <a href="/admin/auth/forgot-password">Forgot password ? </a>
        </div>
    </section>
@endsection
