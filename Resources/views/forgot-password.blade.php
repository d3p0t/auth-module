@extends('layouts.master')

@section('content')
    <section class="auth">
        <x-card>
            <h1>Forgot password</h1>

            @if (session('status'))
                <x-alert type="success">
                    {{ session('status') }}
                </x-alert>
            @else
                <form method="POST" action="/auth/forgot-password">
                    @csrf
                    <x-input name="email" label="Email" type="email"></x-input>
                    <button type="submit" class="button button--primary">
                        Login
                    </button>
                </form>
            @endif
        </x-card>
        <div class="actions">
            <a href="/auth/login">Back to login</a>
        </div>
    </section>
@endsection
