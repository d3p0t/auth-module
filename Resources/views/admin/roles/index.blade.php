@extends('layouts.admin.app')

@section('content')
    <section class="page">
        <h1 class="page__title">
            {{ __('auth::roles.title') }}
        </h1>
        <div class="page__actions">
            @can('create roles')
                <a href="{{ route('auth::admin.roles.create') }}">
                    <mwc-button raised color="primary">
                        {{ __('auth::roles.create.title') }}
                    </mwc-button>
                </a>
            @endcan
        </div>
        <div class="page__content">
            @if (session('status')) 
                <x-alert type="success">
                    {{ session('status') }}
                </x-alert>
            @endif
            <x-card>
                <x-table :columns="[ ['label' => '#', 'sort' => true, 'sort_by' => 'id' ], [ 'label' => 'auth::roles.table.name', 'sort' => true, 'sort_by' => 'name' ], [ 'label' => 'auth::roles.table.users', 'sort' => false ], ['label' => 'common.actions', 'sort' => false] ]">
                    <x-slot:body>
                      @foreach ($roles->items() as $role)
                            <tr>
                                <td>
                                    {{ $role->id }}
                                </td>
                                <td>
                                    {{ $role->name }}
                                </td>
                                <td>
                                    {{ $role->users->count() }}
                                </td>
                                <td>
                                    @if ($role->is_internal)
                                        -
                                    @else
                                        @can('update roles')
                                            <a href="{{ route('auth::admin.roles.edit', $role->id) }}">
                                                <mwc-button color="primary">
                                                    {{ __('common.edit') }}
                                                </mwc-button>
                                            </a>
                                        @endcan
                                        @if ($role->users->isEmpty())
                                            @can('delete roles')
                                                <a href="{{ route('auth::admin.roles.delete', $role->id) }}">
                                                    <mwc-button color="primary">
                                                        {{ __('common.delete') }}
                                                    </mwc-button>
                                                </a>
                                            @endcan
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-slot:body>
                </x-table>
                <x-paginator :pageable="$roles" />
            </x-card>
        </div>
    </section>
@endsection
