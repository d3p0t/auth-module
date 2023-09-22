@extends('layouts.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            Edit user
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="/admin/auth/users">
                Back to users
            </x-button>
        </div>
        <div class="page__content">
            <x-card>
                <form method="POST" action="/admin/auth/users/create">
                    @csrf
                    <x-input name="username" type="text" label="Username" :value="$user->username" />
                    <x-input name="email" type="email" label="Email" :value="$user->email" />
                    <div class="form-field">
                        <label class="form-field__label" for="role">
                            Role
                        </label>
                        <select name="role" id="role" class="form-control" :value="$user->role">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </x-card>
        </div>
    </section>
@endsection
