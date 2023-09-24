@extends('layouts.admin.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            {{ __('auth::users.edit.title') }}
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="/admin/auth/users">
                {{ __('auth::users.edit.back_to_overview') }}
            </x-button>
        </div>
        <div class="page__content">
            {{ session('errors')}}
            <x-card>
                <form method="POST" action="/admin/auth/users/edit/{{ $user->id }}">
                    @csrf
                    <x-input name="username" type="text" label="{{ __('auth::users.edit.form.username') }}"  :value="$user->username" />
                    <x-input name="email" type="email" label="{{ __('auth::users.edit.form.email') }}" :value="$user->email" />
                    <x-input name="name" type="text" label="{{ __('auth::users.edit.form.name') }}" :value="$user->name" />

                    <div class="form-field">
                        <label class="form-field__label" for="role">
                            {{ __('auth::users.edit.form.role') }}
                        </label>
                        <select name="role" id="role" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected($user->hasRole($role->name))>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-button type="submit" color="primary">
                        {{ __('common.save') }}
                    </x-button>
                </form>
            </x-card>
        </div>
    </section>
@endsection
