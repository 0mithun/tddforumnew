
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
                                <div class="list-group">
                                    <a class="list-group-item active"  href="{{ route('profile', auth()->user()->username)  }}">Profile</a>
                                    <a class="list-group-item " href="{{ route('profile.avatar.page', auth()->user()->username)  }}">Avatar</a>
                                    <a class="list-group-item" href="">My Favorites</a>
                                    <a class="list-group-item" href="">My Likes</a>
                                    <a class="list-group-item" href="">My Threads</a>
                                    <a class="list-group-item" href="{{ route('user.edit.password')  }}">Change Password</a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="panel">
                                    <div class="panel-heading">

                                        @if(session()->has('message'))
                                            <div class="row">
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <strong>{{ session('message')  }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-9">
                                                <h4>Joined 1 week ago From: City, Country</h4>
                                            </div>
                                            <div class="col-md-3">
                                                <a class="btn btn-primary" href="{{ route('profile.user.edit', auth()->user()->username) }}" >Edit My Information</a>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="panel-body">
                                        <h4>About Me</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit, ullam. </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
