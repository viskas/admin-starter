@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Edit News') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($article, ['method' => 'PUT', 'route' => ['admin.news.update',  $article->id ], 'enctype' => 'multipart/form-data']) !!}
        @include('admin.news._form', ['article' => $article])
    {!! Form::close() !!}
@endsection
