@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Create User') }}</h1>

    <form class="row" method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @include('admin.users._form', ['options' => ['class' => 'custom-control-input',]])
    </form>
@endsection
