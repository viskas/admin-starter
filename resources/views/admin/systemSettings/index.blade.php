@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('System Settings') }}</h1>

    @include('admin.shared._alerts')

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">
                    <span class="fas fa-exclamation-triangle"></span> {{ __('Attention!') }}
                </h4>
                <p>{{ __('The ${APP_NAME} variable is available. If the field must be left empty, specify null.') }}</p>
                <hr>
                <p class="mb-0">{{ __('Be careful, changes can lead to incorrect system operation.') }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 order-lg-1">
            @include('admin.systemSettings._systemSettings')
        </div>

        <div class="col-md-4 order-lg-1">
            @include('admin.systemSettings._mailSettings')
        </div>
    </div>
@endsection
