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
            {{ __('auth::roles.create.title') }}
        </h1>
        <div class="page__actions">
            <a href="{{ route('auth::admin.roles.index') }}">
                <mwc-button raised olor="primary">
                    {{ __('auth::roles.create.back_to_overview') }}
                </mwc-button>
            </a>
        </div>
        <div class="page__content">
            <x-card>
                <form method="POST" action="{{ route('auth::admin.roles.store') }}">
                    @csrf
                    <x-input name="name" type="text" label="Name" />
                    <h4>
                        {{ __('auth::roles.create.form.permissions') }}
                    </h4>
                    <div class="permissions">
                        @foreach ($permissions as $permission)
                            <mwc-formfield label="{{ $permission->name }}">
                                <mwc-checkbox 
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    id="permission-{{ $permission->id }}"
                                    ></mwc-checkbox>
                            </mwc-formfield>
                        @endforeach
                    </div>

                    <mwc-button raised type="submit" color="primary">
                        Save
                    </mwc-button>
                </form>
            </x-card>
        </div>
    </section>
@endsection
