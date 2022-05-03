@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Sessions') }}</h1>

    @include('admin.shared._alerts')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>{{ __('IP Address') }}</th>
                                    <th>{{ __('User Agent') }}</th>
                                    <th>{{ __('Last Activity') }}</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                            @if ($sessions->total() > 0)
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td>{{ $session->ip_address }}</td>
{{--                                        <td>{{ $session->user_agent }}</td>--}}
                                        <td>
                                            <b>{{ __('Type:') }}</b> {{ ucfirst($session->agentObject->deviceType()) }}
                                            <br>
                                            <b>{{ __('Browser:') }}</b> {{ $session->agentObject->browser() }} {{ $session->agentObject->version($session->agentObject->browser()) }}
                                            <br>
                                            <b>{{ __('OS:') }}</b> {{ $session->agentObject->platform() }} {{ $session->agentObject->version($session->agentObject->platform()) }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($session->last_activity)->format('d.m.Y H:i:s') }}</td>
                                        <td>
                                            <ul class="list-inline">
                                                @can('delete sessions')
                                                    <li class="list-inline-item">
                                                        {!! Form::open([
                                                            'class'=>'delete',
                                                            'url'  => route('admin.sessions.destroy', $session->id),
                                                            'method' => 'DELETE',
                                                            ])
                                                        !!}

                                                        <button class="btn btn-outline-danger btn-sm" title="{{ __('Logout') }}"><i class="fas fa-sign-out-alt"></i></button>

                                                        {!! Form::close() !!}
                                                    </li>
                                                @endcan
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">
                                        {{ __('Sessions Not Found.') }}
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row top20">
        <div class="col-md-12">
            <div class="pull-right">
                {{ $sessions->appends(Request::except('page'))->links() }}
            </div>
        </div>
    </div>

@endsection
