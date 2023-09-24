@extends('layouts.admin.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            {{ __('auth::roles.title') }}
        </h1>
        <div class="page__actions">
            @can('create roles')
                <x-button type="link" color="primary" href="/admin/auth/roles/create">
                    {{ __('auth::roles.create.title') }}
                </x-button>
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
                                            <x-button type="link" href="/admin/auth/roles/edit/{{ $role->id }}">
                                                {{ __('common.edit') }}
                                            </x-button>
                                        @endcan
                                        @if ($role->users->isEmpty())
                                            @can('delete roles')
                                                <x-button type="link" href="/admin/auth/roles/delete/{{ $role->id }}">
                                                    {{ __('common.delete') }}
                                                </x-button>
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
