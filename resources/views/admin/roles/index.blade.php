@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Roles and Permissions') }}</h1>

    @include('admin.shared._alerts')

    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'post']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="roleModalLabel">{{ __('Role') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', __('Role Name')) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>

                    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @can('create roles')
                <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#roleModal">
                    <i class="fe fe-plus"></i>
                    {{ __('Add New Role') }}
                </a>
            @endcan
        </div>
    </div>


    @forelse ($roles as $key => $role)
        {!! Form::model($role, ['method' => 'PUT', 'route' => ['admin.role.update',  $role->id ], 'class' => 'm-b']) !!}

        @if($role->name === 'Admin')
            @include('admin.shared._permissions', [
                          'title' => __('Permissions for :role', ['role' => $role->name]),
                          'options' => ['disabled'] ])
        @else
            @include('admin.shared._permissions', [
                          'title' => __('Permissions for :role', ['role' => $role->name]),
                          'model' => $role])
            @can('update roles')
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
            @endcan
        @endif

        {!! Form::close() !!}

    @empty
        <p>{{ __('Roles not found.') }}</p>
    @endforelse
@endsection
