@extends('layouts.app')

@section('content')
    @php
        $user = auth()->user();
    @endphp
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
                                        <a class="list-group-item "  href="{{ route('profile', auth()->user()->username)  }}">Profile</a>

                                        {{--                                    For Admin--}}
                                        <a class="list-group-item active"  href="{{ route('admin.tag') }}">Tags</a>
                                        {{--                                    --}}



                                        <a class="list-group-item " href="{{ route('profile.avatar.page', auth()->user()->username)  }}">Avatar</a>
                                        <a class="list-group-item" href="{{ route('profile.subscriptions', auth()->user()->username)  }}">My Subscriptions </a>
                                        <a class="list-group-item" href="{{ route('profile.favorites', auth()->user()->username)  }}">My Favorites</a>
                                        <a class="list-group-item" href="{{ route('profile.threads', auth()->user()->username)  }}">My Threads</a>
                                        <a class="list-group-item" href="{{ route('profile.likes', auth()->user()->username)  }}">My Likes</a>
                                        <a class="list-group-item" href="{{ route('user.edit.password')  }}">Change Password</a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="panel">
                                        <div class="panel-heading" style="padding: 0px 10px">

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
                                                        <h4>Tag List</h4>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button class="btn btn-primary" style="margin-right: 5px; float:right">Add New Tag</button>
                                                    </div>
                                                </div>


                                        </div>
                                        <new-tag></new-tag>
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
