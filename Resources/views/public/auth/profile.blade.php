@extends('layouts.public.master')

@section('content')
    <x-card>
        <h1>Profile</h1>
        <form method="post" action="/auth/profile">
            @csrf
        </form>
    </x-card>
@endsection
