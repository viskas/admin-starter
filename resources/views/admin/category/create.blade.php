@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('New Category') }}</h1>

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

    @php
        $traverse = function ($categories, $prefix = '-') use (&$traverse) {
            foreach ($categories as $category) {
                echo '<option value="'.$category->id.'">';
                echo $prefix.' '.$category->name;
                echo '</option>';

                if (count($category->children) > 0) {
                    $traverse($category->children, '&nbsp'.$prefix.'-');
                }
            }
        };
    @endphp

    {!! Form::open(['route' => ['admin.categories.store'], 'enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Main Data') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group focused @if ($errors->has('parent_id')) has-error @endif">
                                {!! Form::label('parent_id', __('Parent Category'), ['class' => 'form-control-label']) !!}
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value=""></option>
                                    {{ $traverse($nodes) }}
                                </select>
                                @if ($errors->has('parent_id')) <p class="help-block">{{ $errors->first('parent_id') }}</p> @endif
                            </div>
                        </div>

                        <div class="pl-lg-12" style="padding-left: 0!important">
                            <div class="col-md-12">
                                <div class="form-group focused @if ($errors->has('name')) has-error @endif">
                                    {!! Form::label('name', __('Category Name'), ['class' => 'form-control-label']) !!} <span class="small text-danger">*</span>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Category Name')]) !!}
                                    @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group focused @if ($errors->has('description')) has-error @endif">
                                    {!! Form::label('description', __('Description'), ['class' => 'form-control-label']) !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Category Description'), 'rows' => 3]) !!}
                                    @if ($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Metadata') }}</h6>
                    </div>

                    <div class="pl-lg-12" style="padding-left: 0!important; margin-top: 20px">
                        <div class="col-md-12">
                            <div class="form-group focused @if ($errors->has('meta_title')) has-error @endif">
                                {!! Form::label('meta_title', __('Meta Title'), ['class' => 'form-control-label']) !!}
                                {!! Form::text('meta_title', null, ['class' => 'form-control', 'placeholder' => __('Meta Title')]) !!}
                                @if ($errors->has('meta_title')) <p class="help-block">{{ $errors->first('meta_title') }}</p> @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group focused @if ($errors->has('meta_description')) has-error @endif">
                                {!! Form::label('meta_description', __('Meta Description'), ['class' => 'form-control-label']) !!}
                                {!! Form::text('meta_description', null, ['class' => 'form-control', 'placeholder' => __('Meta Description')]) !!}
                                @if ($errors->has('meta_description')) <p class="help-block">{{ $errors->first('meta_description') }}</p> @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group focused @if ($errors->has('meta_keywords')) has-error @endif">
                                {!! Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'form-control-label']) !!}
                                {!! Form::text('meta_keywords', null, ['class' => 'form-control', 'placeholder' => __('Meta Keywords')]) !!}
                                @if ($errors->has('meta_keywords')) <p class="help-block">{{ $errors->first('meta_keywords') }}</p> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Photo') }}</h6>
                    </div>

                    <div class="pl-lg-12" style="padding-left: 0!important; margin-top: 20px">
                        <div class="col-md-12">
                            <div class="form-group focused @if ($errors->has('image')) has-error @endif">
                                {!! Form::file('image', null, ['class' => 'form-control']) !!}
                                @if ($errors->has('image')) <p class="help-block">{{ $errors->first('image') }}</p> @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Action') }}</h6>
                    </div>

                    <div class="pl-lg-12" style="padding-left: 0!important; margin-top: 20px">
                        <div class="col-md-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 20px">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
