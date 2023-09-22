@extends('layouts.admin')

@section('content')
    <section class="page">
        <h1 class="page__title">
            Users
        </h1>
        <div class="page__actions">
            <x-button type="link" color="primary" href="/admin/auth/users/create">
                Create user
            </x-button>
        </div>
        <div class="page__content">
            <x-card>
                <table>
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Username
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $user->id }}
                                </td>
                                <td>
                                    {{ $user->username }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @can('update users')
                                        <x-button type="link" href="/admin/auth/users/edit/{{ $user->id }}">
                                            Edit
                                        </x-button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-card>
        </div>
    </section>
@endsection
