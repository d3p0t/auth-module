@extends('layouts.admin.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            {{ __('auth::users.title') }}
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="/admin/auth/users/create">
                {{ __('auth::users.create.title') }}
            </x-button>
        </div>
        <div class="page__content">
            @if (session('status')) 
                <x-alert type="success">
                    {{ session('status') }}
                </x-alert>
            @endif
            <x-card>

                <x-table :columns="[ ['label' => '#', 'sort' => true, 'sort_by' => 'id' ], [ 'label' => 'auth::users.table.name', 'sort' => true, 'sort_by' => 'name' ], [ 'label' => 'auth::users.table.username', 'sort' => true, 'sort_by' => 'username' ], [ 'label' => 'auth::users.table.email', 'sort' => true, 'sort_by' => 'email' ], [ 'label' => 'auth::users.table.role', 'sort' => true, 'sort_by' => 'role' ], [ 'label' => 'common.actions', 'sort' => false ] ]">
                    <x-slot:body>
                        @foreach ($users->items() as $user)
                            <tr>
                                <td>
                                    {{ $user->id }}
                                </td>
                                <td>
                                    <x-avatar name="{{ $user->name }}"></x-avatar>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->username }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->getRoleNames()[0] }}
                                </td>
                                <td>
                                    @can('update users')
                                        <x-button type="link" href="/admin/auth/users/edit/{{ $user->id }}">
                                            {{ __('common.edit') }}
                                        </x-button>
                                    @endcan
                                    @if (Auth::id() !== $user->id)
                                        @can('delete users')
                                            <x-button type="link" href="/admin/auth/users/delete/{{ $user->id }}">
                                                {{ __('common.delete') }}
                                            </x-button>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-slot:body>
                </x-table>
                <x-paginator :pageable="$users" />
            </x-card>
        </div>
    </section>
@endsection
