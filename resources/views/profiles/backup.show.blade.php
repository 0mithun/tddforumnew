
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>{{ strtoupper(auth()->user()->name) }}</h3>
                            </div>
                            <div class="col-md-2">
                                <img src="{{ asset(auth()->user()->avatar_path)  }}" class="img-circle" alt="Cinque Terre" style="width:60px; height: auto;">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <ul class="nav nav-pills nav-stacked">
                                    <li role="presentation" class="active"><a href="{{ route('profile.avatar.page', auth()->user()->username)  }}">Avatar</a></li>
                                    <li role="presentation"><a href="">Settings</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
