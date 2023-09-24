@extends('layouts.admin.admin')

@section('content')
    <style>
        .permissions {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
        }
    </style>
    <section class="page">
        <h1 class="page__title">
            {{ __('auth::roles.edit.title') }}
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="{{ route('auth::admin.roles.index') }}">
                {{ __('auth::roles.edit.back_to_overview') }}
            </x-button>
        </div>
        <div class="page__content">
            <x-card>
                <form method="POST" action="{{ route('auth::admin.roles.update', $role->id) }}">
                    @csrf
                    <x-input name="name" type="text" label="{{ __('auth::roles.edit.form.name') }}" :value="$role->name"/>
                    <h4>
                        {{ __('auth::roles.edit.form.permissions') }}
                    </h4>
                    <div class="permissions">
                        @foreach ($permissions as $permission)
                            <div class="form-field">
                                <label for="permission-{{ $permission->id }}">
                                <input 
                                    class="form-control"
                                    type="checkbox"
                                    name="permissions[]"
                                    id="permission-{{ $permission->id }}"
                                    value="{{ $permission->id }}"
                                    {{ $role->can($permission->name) ? 'checked' : null }}
                                    />
                                    {{ $permission->name }}
                            </div>
                        @endforeach
                    </div>
                    <x-button type="submit" color="primary">
                        {{ __('common.save') }}
                    </x-button>
                </form>
            </x-card>
        </div>
    </section>
@endsection
