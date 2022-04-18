@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Translations') }}</h1>

    @include('admin.shared._alerts')

    <div class="row">
        <div class="col-md-8">
            <div class="card card-header-actions mb-4">
                <div class="card-header">
                    {{ __('Translation keys')  }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.translations.store') }}" method="POST" id="translationForm">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($availableTranslations as $key => $value)
                                        <li class="nav-item">
                                            <a class="nav-link {{ array_keys($availableTranslations)[0] == $key ? 'active' : '' }}" id="{{ $key }}-tab" data-toggle="tab" href="#tab-{{ $key }}" role="tab" aria-controls="tab-{{ $key }}" aria-selected="true">
                                                {{ strtoupper($key) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content top20" id="myTabContent">
                                    @foreach ($availableTranslations as $key => $value)
                                        <div class="tab-pane fade {{ array_keys($availableTranslations)[0] == $key ? 'show active' : '' }}" id="tab-{{ $key }}" role="tabpanel" aria-labelledby="{{ $key }}-tab">
                                            @foreach ($value as $fileKey => $item)
                                                <div class="mb-3">
                                                    <label class="small mb-1">{{ $fileKey }}</label>
                                                    <input class="form-control {{ $item ? '' : 'is-invalid' }}" type="text" value="{{ $item }}" name="Translation[{{ $key }}][{{ $fileKey }}]">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Actions') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @can('update translations')
                                <button class="btn btn-sm btn-outline-success" onclick="document.getElementById('translationForm').submit();">
                                    <i class="fas fa-fw fa-check" aria-hidden="true"></i>
                                    {{ __('Save') }}
                                </button>
                            @endcan

                            @can('rescan translations')
                                <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.translations.rescan') }}"
                                    onclick="return confirm('{{ __('Are you sure you want to scan? This action will overwrite the main translation file.') }}')">
                                    <i class="fas fa-fw fa-spinner" aria-hidden="true"></i>
                                    {{ __('Rescan') }}
                                </a>
                            @endcan

                            @can('export translations')
                                <a class="btn btn-sm btn-outline-info" href="{{ route('admin.translations.export') }}">
                                    <i class="fas fa-fw fa-file-excel" aria-hidden="true"></i>
                                    {{ __('Export') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            @can('create translations')
                <div class="card top20">
                <div class="card-header">{{ __('Add new translation file') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open([
                                'url'  => route('admin.translations.storeLanguage'),
                                'method' => 'POST',
                                'files' => true
                                ])
                            !!}

                                <label class="small mb-1 form-label">
                                    {{ __('Locale') }} <span class="small text-danger">*</span>
                                </label>
                                <input type="file" name="localeFile" class="form-control @if ($errors->has('localeFile')) is-invalid @endif"
                                       value="{{ old('localeFile') }}">
                                @if ($errors->has('localeFile'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('localeFile') }}
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-outline-primary btn-sm top20">
                                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i> {{ __('Create') }}
                                </button>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            @endcan

            <div class="card top20">
                <div class="card-header">{{ __('Available translation locales') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Locale') }}</th>
                                        <th>{{ __('File type') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($availableTranslations as $key => $value)
                                        <tr>
                                            <th scope="row">
                                                <i class="fas fa-fw fa-file-excel" aria-hidden="true"></i> {{ strtoupper($key) }}
                                            </th>
                                            <th>JSON</th>
                                            <td>
                                                @can('delete translations')
                                                    {!! Form::open([
                                                        'class'=>'delete',
                                                        'url'  => route('admin.translations.destroy', $key),
                                                        'method' => 'DELETE',
                                                        ])
                                                    !!}

                                                        <button class="btn btn-outline-danger btn-sm border-0" @if($defaultLocale == $key) disabled @endif>
                                                            {{ __('Delete') }}
                                                        </button>
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
