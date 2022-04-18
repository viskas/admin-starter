@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Profile') }}</h1>

    @include('admin.shared._alerts')

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 order-lg-2">
            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/'.$user->id.'/'.$user->avatar)}}">
                    @else
                        <img class="rounded-circle font-weight-bold" src="https://ui-avatars.com/api/?background=466cd9&color=fff&size=1000&font-size=0.4&bold=true&name={{ mb_strtoupper(Auth::user()->name).'+'.mb_strtoupper(Auth::user()->last_name) }}" alt="">
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form method="POST" action="{{ route('admin.profile.upload') }}" class="text-center" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h5 class="font-weight-bold">{{  $user->fullName }}</h5>
                                <div class="custom-file-upload">
                                    <label for="file-upload" class="custom-file-upload1">
                                        <i class="fa fa-cloud-upload"></i> {{ __('New Photo') }}
                                    </label>
                                    <input id="file-upload" type="file" name="avatar" />
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
                                <a href="{{ route('admin.profile.deleteAvatar') }}" class="btn btn-danger">{{ __('Delete') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ __('My account') }}
                    </h6>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="name">
                                        {{ __('Name') }}
                                        <span class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Name') }}" value="{{ old('name', $user->name) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="last_name">
                                        {{ __('Last Name') }}
                                        <span class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="last_name" class="form-control" name="last_name" placeholder="{{ __('Last Name') }}" value="{{ old('last_name', $user->last_name) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">
                                        {{ __('Email') }}
                                        <span class="small text-danger">*</span>
                                    </label>
                                    <input type="email" id="email" class="form-control" name="email" placeholder="demo@example.com" value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="current_password">{{ __('Current Password') }}</label>
                                    <input type="password" id="current_password" class="form-control" name="current_password" placeholder="{{ __('Current Password') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">{{ __('New Password') }}</label>
                                    <input type="password" id="new_password" class="form-control" name="new_password" placeholder="{{ __('New Password') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="confirm_password">{{ __('Password Confirmation') }}</label>
                                    <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="{{ __('Password Confirmation') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Google Two Factor Authentication') }}</h6>
                </div>

                <div class="card-body text-center">
                    @if($user->google2fa_secret)
                        <p>
                            {{ __('Set up two-factor authentication by scanning the barcode below. Alternatively you can use the code') }} <b>{{ $user->google2fa_secret }}</b>
                        </p>
                        <div>
                            {!! $qr !!}
                        </div>
                        <p class="top15">
                            {{ __('Before proceeding, you need to set up the Google Authenticator app. Otherwise, you will not be able to login.') }}
                        </p>

                        <a href="{{ route('admin.profile.googleTwoStep') }}" class="btn btn-warning" onclick="return confirm('Вы точно хотите отключить двухфакторную аутентификацию?')">
                            {{ __('Disable') }}
                        </a>
                        <a href="{{ route('admin.profile.googleTwoStepRegenerate') }}" class="btn btn-danger" onclick="return confirm('Вы точно хотите сгенерировать новый ключ? Вам необходимо будет повторно отсканировать новый QR код.')">
                            {{ __('Generate New Key') }}
                        </a>
                    @else
                        <a href="{{ route('admin.profile.googleTwoStep') }}" class="btn btn-primary">
                            {{ __('Turn on') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .custom-file-upload input[type="file"] {
        display: none;
    }
    .custom-file-upload .custom-file-upload1 {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }
</style>
