@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('News list') }}</h1>

    @include('admin.shared._alerts')

    @can('create news')
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                    <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                    {{ __('Add News') }}
                </a>
            </div>
        </div>
    @endcan

    @include('admin.news._filters')

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>@sortablelink('id', 'ID')</th>
                            <th>{{ __('Photo') }}</th>
                            <th>@sortablelink('title', __('Title'))</th>
                            <th>@sortablelink('slug', __('Slug'))</th>
                            <th>@sortablelink('status', __('Status'))</th>
                            <th>@sortablelink('published_at', __('Published At'))</th>
                            <th>@sortablelink('created_at', __('Created At'))</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>@sortablelink('id', 'ID')</th>
                            <th>{{ __('Photo') }}</th>
                            <th>@sortablelink('title', __('Title'))</th>
                            <th>@sortablelink('slug', __('Slug'))</th>
                            <th>@sortablelink('status', __('Status'))</th>
                            <th>@sortablelink('published_at', __('Published At'))</th>
                            <th>@sortablelink('created_at', __('Created At'))</th>
                            <th></th>
                        </tr>
                    </tfoot>

                    <tbody>
                    @if ($articles->total() > 0)
                        @foreach ($articles as $article)
                            <tr>
                                <td>{{ $article->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/news/'.$article->id.'/'.$article->image)}}" alt="" style="max-height: 150px; max-width: 150px">
                                </td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->slug }}</td>
                                <td>
                                    <?= $article->status == 'active' ?
                                        "<span class='badge badge-success'>".__('Active')."</span>" :
                                        "<span class='badge badge-danger'>".__('Inactive')."</span>" ?>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($article->published_at)->format('d.m.Y')}}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($article->created_at)->format('d.m.Y H:i')}}
                                </td>
                                <td>
                                    <ul class="list-inline">
                                        @can('update news')
                                            <li class="list-inline-item">
                                                <a href="{{ route('admin.news.edit', $article->id) }}" title="{{ __('Edit') }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('delete news')
                                            <li class="list-inline-item">
                                                {!! Form::open([
                                                    'class'=>'delete',
                                                    'url'  => route('admin.news.destroy', $article->id),
                                                    'method' => 'DELETE',
                                                    ])
                                                !!}

                                                <button class="btn btn-danger btn-sm" title="{{ __('Delete') }}"><i class="fas fa-trash-alt"></i></button>

                                                {!! Form::close() !!}
                                            </li>
                                        @endcan
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">
                                {{ __('News Not Found.') }}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <span>{{ __('Total news:') }} {{ $articles->total() }}</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                {{ $articles->appends(Request::except('page'))->links() }}
            </div>
        </div>
    </div>
@endsection
