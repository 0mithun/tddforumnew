
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
                                        <a class="list-group-item " href="{{ route('profile.avatar.page', auth()->user()->username)  }}">Avatar</a>
                                        <a class="list-group-item " href="{{ route('profile.subscriptions', auth()->user()->username)  }}">My Subscriptions </a>
                                        <a class="list-group-item" href="{{ route('profile.favorites', auth()->user()->username)  }}">My Favorites</a>
                                        <a class="list-group-item" href="{{ route('profile.threads', auth()->user()->username)  }}">My Threads</a>
                                        <a class="list-group-item active" href="{{ route('profile.likes', auth()->user()->username)  }}">My Likes</a>
                                        <a class="list-group-item " href="{{ route('user.edit.password')  }}">Change Password</a>
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
                                            <h4>My Likes Thread</h4>
                                        </div>
                                        <div class="panel-body">
                                            <table class="table table-responsive table-hover table-bordered table-condensed ">
                                                <thead>
                                                <tr>
                                                    <th class="td" width="80%">Thread Title</th>
                                                    <th class="td" width="5%" style="text-align: center">Type</th>
                                                    <th class="td" >
                                                        Action
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @forelse($likes as $like)
                                                    @php
                                                        $thread = \App\Thread::where('id', $like->likeable_id)->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $thread->title }}</td>
                                                        <td style="text-align: center">
                                                            @if($like->up ==1)
                                                                <span class="glyphicon glyphicon-thumbs-up blue-icon"></span>
                                                                @endif
                                                            @if($like->down ==1)
                                                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                                             @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-default btn-sm">
                                                                <a href="{{ url($thread->path()) }}">Show Thread</a>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                @empty
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="alert alert-warning">
                                                                You are not like any Thread
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </table>

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
