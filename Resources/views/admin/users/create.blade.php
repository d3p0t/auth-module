@extends('layouts.admin.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            {{ __('auth::users.create.title') }}
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="/admin/auth/users">
                {{ __('auth::users.create.back_to_overview') }}
            </x-button>
        </div>
        <div class="page__content">
            <x-card>
                <form method="POST" action="/admin/auth/users/create">
                    @csrf
                    <x-input name="username" type="text" label="{{ __('auth::users.create.form.username') }}" />
                    <x-input name="email" type="email" label="{{ __('auth::users.create.form.email') }}" />
                    <x-input name="name" type="text" label="{{ __('auth::users.create.form.name') }}" />
                    <x-input name="password" type="password" label="{{ __('auth::users.create.form.password') }}" />

                    <div class="form-field">
                        <label class="form-field__label" for="role">
                            {{ __('auth::users.create.form.role') }}
                        </label>
                        <select name="role" id="role" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                            <option value="foo">Foo</option>
                        </select>
                        @if ($errors->has('role'))
                            <span class="form-field__error">
                                {{ $errors->first('role') }}
                            </span>
                        @endif
                    </div>
                    <x-button type="submit" color="primary">
                        {{ __('common.save') }}
                    </x-button>
                </form>
            </x-card>
        </div>
    </section>
@endsection
