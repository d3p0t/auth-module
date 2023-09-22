@extends('layouts.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            Create new role
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="/admin/auth/roles">
                Back to roles
            </x-button>
        </div>
        <div class="page__content">
            <x-card>
                <form method="POST" action="/admin/auth/roles/create">
                    @csrf
                    <x-input name="name" type="text" label="Name" />
                    @foreach ($permissions as $permission)
                        <div class="form-field">
                            <label for="permission-{{ $permission->id }}">
                                {{ $permission->name }}
                            <input 
                                class="form-control"
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                id="permission-{{ $permission->id }}"
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
