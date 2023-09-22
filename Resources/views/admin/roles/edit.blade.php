@extends('layouts.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            Edit role
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="/admin/auth/roles">
                Back to roles
            </x-button>
        </div>
        <div class="page__content">
            <x-card>
                <form method="POST" action="/admin/auth/roles/edit/{{ $role->id }}">
                    @csrf
                    <x-input name="name" type="text" label="Name" :value="$role->name"/>
                    @foreach ($permissions as $permission)
                        <div class="form-field">
                            <label for="permission-{{ $permission->id }}">
                                {{ $permission->name }}
                            <input 
                                class="form-control"
                                type="checkbox"
                                name="permissions[]"
                                id="permission-{{ $permission->id }}"
                                value="{{ $permission->id }}"
                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : null }}
                                />
                        </div>
                    @endforeach

                    <x-button type="submit" color="primary">
                        Save
                    </x-button>
                </form>
            </x-card>
        </div>
    </section>
@endsection
