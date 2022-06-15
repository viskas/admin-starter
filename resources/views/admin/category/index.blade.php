@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Category List') }}</h1>

    @include('admin.shared._alerts')

    <div class="row">
        <div class="col-md-7">
            <div class="card card-header-actions mb-4">
                <div class="card-header">
                    {{ __('Categories')  }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tree">
                                <ul>
                                    @php
                                        $traverse = function ($categories) use (&$traverse) {
                                            foreach ($categories as $category) {
                                                echo '<li>';
                                                echo '<a href="#" class="category-item" data-category-id="'.$category->id.'">'.
                                                    $category->name.
                                                    '</a>';

                                                if (count($category->children) > 0) {
                                                    echo '<ul>';
                                                    $traverse($category->children);
                                                    echo '</ul>';
                                                }
                                                echo '</li>';
                                            }
                                        };

                                        $traverse($nodes);
                                    @endphp
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-header-actions mb-4">
                <div class="card-header">
                    {{ __('Category')  }}

                    @can('create categories')
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary float-right">
                            <i class="fas fa-fw fa-plus" aria-hidden="true"></i>
                            {{ __('Create') }}
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row" id="updateCategoryForm">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<style>
    .tree,
    .tree ul,
    .tree li{display:block;margin:0;padding:0;border:0;outline:0;text-decoration:none;text-align:left;text-align-last:left;color:#525252}

    .tree ul:before,
    .tree li:before,
    .tree li:after{position:absolute;right:auto;content:'';-webkit-user-select:none}

    .tree,
    .tree ul:before,
    .tree li:before{bottom:auto;font:0/0 sans-serif}

    .tree ul,
    .tree li{position:relative;font:16px/19px sans-serif;padding:0 0 16px}

    .tree ul:before,
    .tree li:after{background:#a6a6a6;}

    .tree ul:before{width:8px;height:1px;top:0;left:6px}

    .tree li{padding:0 0 0 28px;margin:0 0 0 9px;text-rendering:optimizeLegibility}

    .tree li:before{
        content:url('data:image/svg+xml;utf8,<svg width="5" height="5" viewBox="0 0 2 2" xmlns="http://www.w3.org/2000/svg"><circle cx="1" cy="1" r="1" fill="#a6a6a6"/><circle cy="1" cx="1" r="0.5" fill="#eaeaea"/></svg>');
        background:transparent 0 2px repeat-x url('data:image/gif;base64,R0lGODlhAQABAPAAAKampgAAACwAAAAAAQABAAACAkQBADs=');
        width:24px;top:7px;left:0;
        text-align-last: right;
        text-align: right;
        height:5px;
    }

    .tree li:after{height:auto;width:1px;top:0;left:0;bottom:0}
    .tree li:last-child:after{height:9px}
</style>

@section('additional-js')
    <script>
        $(document).ready(function () {
            $('.category-item').on('click', function (e) {
                var categoryId = $(this).attr('data-category-id');

                getCategoryUpdateForm(categoryId);
            })

            function getCategoryUpdateForm(categoryId) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var url = '{{route("admin.categories.edit", ":id")}}';
                url = url.replace(':id', categoryId);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function (response) {
                        $('#updateCategoryForm').html(response.form);
                    }
                })
            }
        });
    </script>
@endsection
