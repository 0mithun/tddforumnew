
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
                                    <h3>{{ strtoupper($user->name) }}</h3>
                                </div>
                                <div class="col-md-2">
                                    <img src="{{ asset($user->avatar_path)  }}" class="img-circle" alt="Cinque Terre" style="width:100px; height: auto;" id="avatarphoto">
                                </div>
                            </div>
                            <hr>
                            <div class="row" style="margin-top: 50px;">
                                <div class="col-md-3">
                                    <a class="list-group-item active" href="{{ route('user.settnigs', auth()->user()->username)  }}">Notifications</a>
{{--                                    <a class="list-group-item" href="{{ route('user.settnigs.subscriptions', auth()->user()->username)  }}">Subscriptions</a>--}}
                                </div>
                                <div class="col-md-9">
                                    <form action="{{ route('user.settnigs.update', auth()->user()->username )  }}" method="post">
                                        @csrf

                                        <div class="row">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    @if(session()->has('successmessage'))
                                                        <div class="row">
                                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <strong>{{ session('successmessage')  }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="panel-body">
                                                        <div class="col-md-6" >
                                                            <h4>When I am mentioned in a comment</h4>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>Notify me on:</h4>
                                                            <div class="form-group">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="mention_notify_anecdotage" value="1"
                                                                            @if($settings->mention_notify_anecdotage ==1)
                                                                                checked
                                                                            @endif
                                                                        >
                                                                        Anecdotage
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox disabled">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="mention_notify_email"

                                                                               @if($settings->mention_notify_email ==1)
                                                                               checked
                                                                                @endif
                                                                        >
                                                                        Email
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox disabled">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="mention_notify_facebook"
                                                                               @if($settings->mention_notify_facebook ==1)
                                                                               checked
                                                                                @endif
                                                                        >
                                                                        Facebook
                                                                    </label>
                                                                </div>


                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="panel">
                                                <div class="panel-heading"></div>
                                                <div class="panel-body">
                                                        <div class="col-md-6" >
                                                            <h4>When new threads are posted about:</h4>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="inlineCheckbox1" value=""> 1 Hour ago
                                                                </label>
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="inlineCheckbox1" value=""> 2 Hour ago
                                                                </label>
                                                            </div>

                                                            <h4>Notify me on:</h4>
                                                            <div class="form-group">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="new_thread_posted_notify_anecdotage"
                                                                               @if($settings->new_thread_posted_notify_anecdotage ==1)
                                                                               checked
                                                                                @endif
                                                                        >
                                                                        Anecdotage
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox disabled">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="new_thread_posted_notify_email"
                                                                               @if($settings->new_thread_posted_notify_email ==1)
                                                                               checked
                                                                                @endif
                                                                        >
                                                                        Email
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox disabled">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="new_thread_posted_notify_facebook"
                                                                               @if($settings->new_thread_posted_notify_facebook ==1)
                                                                               checked
                                                                                @endif
                                                                        >
                                                                        Facebook
                                                                    </label>
                                                                </div>


                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="panel">
                                                <div class="panel-heading"></div>
                                                <div class="panel-body">
                                                        <div class="col-md-6" >
                                                            <h4>Receive Daily Random threads?</h4>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>Notify me on:</h4>
                                                            <div class="form-group">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="receive_daily_random_thread_notify_anecdotage"
                                                                               @if($settings->receive_daily_random_thread_notify_anecdotage ==1)
                                                                               checked
                                                                                @endif
                                                                        >
                                                                        Anecdotage


                                                                    </label>
                                                                </div>
                                                                <div class="checkbox disabled">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="receive_daily_random_thread_notify_email"
                                                                               @if($settings->receive_daily_random_thread_notify_email ==1)
                                                                               checked
                                                                                @endif
                                                                        >
                                                                        Email
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox disabled">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="receive_daily_random_thread_notify_facebook"
                                                                               @if($settings->receive_daily_random_thread_notify_facebook ==1)
                                                                               checked
                                                                                @endif
                                                                        >
                                                                        Facebook
                                                                    </label>
                                                                </div>


                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fow">
                                            <div class="form-group">
                                                <button class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')

@endsection