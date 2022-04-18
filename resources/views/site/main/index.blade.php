@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-top: 5%">
                <h1 class="text-center" style="font-size: 70px">Admin Starter</h1>
            </div>
            <div class="col-md-12 text-center">
                <a href="{{ route('login') }}" target="_blank" class="btn btn-outline-primary btn-lg" style="margin-top: 5%">
                    Login
                </a>
            </div>
        </div>
    </div>
@endsection
