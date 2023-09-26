@extends('layouts.admin.app')

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
            <a href="{{ route('auth::admin.roles.index') }}">
                <mwc-button raised color="primary">
                    {{ __('auth::roles.edit.back_to_overview') }}
                </mwd-button>
            </a>
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
                                <mwc-formfield label="{{ $permission->name }}">
                                    <mwc-checkbox 
                                        name="permissions[]"
                                        id="permission-{{ $permission->id }}"
                                        value="{{ $permission->id }}"
                                        {{ $role->permissions->pluck('name')->contains($permission->name) ? 'checked' : null }}
                                        ></mwc-checkbox>
                                </mwc-formfield>
                            </div>
                        @endforeach
                    </div>
                    <mwc-button raised type="submit" color="primary" onclick="event.target.closest('form').submit()">
                        {{ __('common.save') }}
                    </mwc-button>
                </form>
            </x-card>
        </div>
    </section>
@endsection
