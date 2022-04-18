@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Edit User :user', ['user' => $user->fullName]) }}</h1>

    <form class="row" method="POST" action="{{ route('admin.users.update',  $user->id) }}" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        @include('admin.users._form', ['user' => $user, 'options' => ['class' => 'custom-control-input',]])
    </form>
@endsection
