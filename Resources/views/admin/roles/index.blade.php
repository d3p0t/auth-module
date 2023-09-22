@extends('layouts.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            Roles
        </h1>
        <div class="page__actions">
            @can('create roles')
                <x-button type="link" color="primary" href="/admin/auth/roles/create">
                    Create Role
                </x-button>
            @endcan
        </div>
        <div class="page__content">
            <x-card>
                <x-table :columns="[ ['label' => '#', 'sort' => true, 'sort_by' => 'id' ], [ 'label' => 'Name', 'sort' => true, 'sort_by' => 'name' ], [ 'label' => 'Permissions', 'sort' => false ], ['label' => 'Actions', 'sort' => false] ]">
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
                                </td>
                                <td>
                                    @can('update roles')
                                        <x-button type="link" href="/admin/auth/roles/edit/{{ $role->id }}">
                                            Edit
                                        </x-button>
                                    @endcan
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
