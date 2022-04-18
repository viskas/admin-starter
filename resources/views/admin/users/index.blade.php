@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Users List') }}</h1>

    @include('admin.shared._alerts')

    @can('create users')
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    {{ __('Add User') }}
                </a>
            </div>
        </div>
    @endcan

    @include('admin.users._filters')

    <div class="row top20">
        @if(count($users) > 0)
            @foreach($users as $user)
                <div class="col-md-3">
                    <div class="card" style="margin-bottom: 20px">
                        @if($user->avatar)
                            <img class="img-profile rounded-circle avatar font-weight-bold mx-auto d-bloc cover-img user-management-img" src="{{ asset('storage/avatars/'.$user->id.'/'.$user->avatar)}}">
                        @else
                            <img class="img-profile rounded-circle avatar font-weight-bold mx-auto d-bloc user-management-img" src="https://ui-avatars.com/api/?background=466cd9&color=fff&size=1000&font-size=0.4&bold=true&name={{ mb_strtoupper(Auth::user()->name).'+'.mb_strtoupper(Auth::user()->last_name) }}" alt="">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                ID: {{ $user->id }}<br>
                                {{ $user->name }} {{ $user->last_name }}
                            </h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <b>{{ __('Email:') }}</b> {{ $user->email }}
                            </li>
                            <li class="list-group-item">
                                <b>{{ __('Roles:') }}</b> {{ $user->roles->implode('name', ', ') }}
                            </li>
                            <li class="list-group-item">
                                <b>{{ __('Created At:') }}</b> {{ \Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i') }}
                            </li>
                            <li class="list-group-item">
                                <b>{{ __('Updated At:') }}</b> {{ \Carbon\Carbon::parse($user->updated_at)->format('d.m.Y H:i') }}
                            </li>
                        </ul>
                        <div class="card-body text-center">
                            <ul class="list-inline">
                                @can('update users')
                                    <li class="list-inline-item">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary" title="{{ __('Edit') }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </li>
                                @endcan

                                @can('impersonate users')
                                    <li class="list-inline-item">
                                        <a href="{{ route('admin.impersonate.login', ['id' => $user->id]) }}" class="btn btn-outline-success" title="{{ __('Login as user') }}" onclick="return confirm('{{ __('Are you sure you want to log in with this user account?') }}')">
                                            <i class="fa fa-sign-in-alt"></i>
                                        </a>
                                    </li>
                                @endcan

                                @can('reset 2fa users')
                                    <li class="list-inline-item">
                                        <a href="{{ route('admin.users.2faReset', $user->id) }}" class="btn btn-outline-secondary" title="{{ __('Disable two-factor authentication') }}" onclick="return confirm('{{ __('Are you sure you want to disable two-factor authentication for the selected user?') }}')">
                                            <i class="fas fa-qrcode"></i>
                                        </a>
                                    </li>
                                @endcan

                                @can('delete users')
                                    <li class="list-inline-item">
                                        {!! Form::open([
                                            'class'=>'delete',
                                            'url'  => route('admin.users.destroy', $user->id),
                                            'method' => 'DELETE',
                                            ])
                                        !!}

                                            <button class="btn btn-outline-danger btn" title="{{ __('Delete') }}" onclick="return confirm('{{ __('Are you sure you want to delete the entry?') }}')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                        {!! Form::close() !!}
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <h3 class="text-center">
                    {{ __('Users not found.') }}
                </h3>
            </div>
        @endif
    </div>

    <div class="row top20">
        <div class="col-md-12">
            <div class="pull-right">
                {{ $users->appends(Request::except('page'))->links() }}
            </div>
        </div>
    </div>
@endsection
