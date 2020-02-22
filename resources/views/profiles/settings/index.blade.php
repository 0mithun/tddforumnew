
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
                                    <a class="list-group-item active" href="{{ route('user.settnigs.notifications', auth()->user()->username)  }}">Notifications</a>
                                    <a class="list-group-item" href="{{ route('user.settnigs.subscriptions', auth()->user()->username)  }}">Subscriptions</a>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="panel">
                                            <div class="panel-heading"></div>
                                            <div class="panel-body">
                                                <form action="" method="post">
                                                    <div class="col-md-6" >
                                                        <h4>When I am mentioned in a comment</h4>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Notify me on:</h4>
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" value="">
                                                                    Anecdotage
                                                                </label>
                                                            </div>
                                                            <div class="checkbox disabled">
                                                                <label>
                                                                    <input type="checkbox" value="" disabled>
                                                                    Email
                                                                </label>
                                                            </div>
                                                            <div class="checkbox disabled">
                                                                <label>
                                                                    <input type="checkbox" value="" disabled>
                                                                    Facebook
                                                                </label>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="panel">
                                            <div class="panel-heading"></div>
                                            <div class="panel-body">
                                                <form action="" method="post">
                                                    <div class="col-md-6" >
                                                        <h4>When new threads are posted about:</h4>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" id="inlineCheckbox1" value="option1"> 1 Hour ago
                                                            </label>
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" id="inlineCheckbox1" value="option1"> 2 Hour ago
                                                            </label>
                                                        </div>

                                                        <h4>Notify me on:</h4>
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" value="">
                                                                    Anecdotage
                                                                </label>
                                                            </div>
                                                            <div class="checkbox disabled">
                                                                <label>
                                                                    <input type="checkbox" value="" disabled>
                                                                    Email
                                                                </label>
                                                            </div>
                                                            <div class="checkbox disabled">
                                                                <label>
                                                                    <input type="checkbox" value="" disabled>
                                                                    Facebook
                                                                </label>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="panel">
                                            <div class="panel-heading"></div>
                                            <div class="panel-body">
                                                <form action="" method="post">
                                                    <div class="col-md-6" >
                                                        <h4>Receive Daily Random threads?</h4>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Notify me on:</h4>
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" value="">
                                                                    Anecdotage
                                                                </label>
                                                            </div>
                                                            <div class="checkbox disabled">
                                                                <label>
                                                                    <input type="checkbox" value="" disabled>
                                                                    Email
                                                                </label>
                                                            </div>
                                                            <div class="checkbox disabled">
                                                                <label>
                                                                    <input type="checkbox" value="" disabled>
                                                                    Facebook
                                                                </label>
                                                            </div>


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
            </div>
        </div>
    </div>
@endsection

@section('footer_script')

@endsection