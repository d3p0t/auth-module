@extends('layouts.admin.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            {{ __('auth::roles.create.title') }}
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="{{ route('auth::admin.roles.index') }}">
                {{ __('auth::roles.create.back_to_overview') }}
            </x-button>
        </div>
        <div class="page__content">
            <x-card>
                <form method="POST" action="{{ route('auth::admin.roles.store') }}">
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
