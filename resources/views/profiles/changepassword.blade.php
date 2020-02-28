
@extends('layouts.app')

@section('content')
    @php
        $user = auth()->user();
        if($user->date_of_birth !=''){
            //$birth_date = date("d/m/yy", strtotime($user->date_of_birth));
        }else{
            $birth_date = '';
        }


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
                                    <img src="{{ asset($user->avatar_path)  }}" class="img-circle" alt="Cinque Terre" style="width:60px; height: auto;">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="list-group">
                                        <a class="list-group-item"  href="{{ route('profile', $user->username)  }}">Profile</a>

                                        @if($user->isAdmin)
                                            {{--                                    For Admin--}}
                                            <a class="list-group-item"  href="{{ route('admin.setesettings') }}">Site Settings</a>
                                            <a class="list-group-item"  href="{{ route('admin.tag') }}">Tags</a>
                                            <a class="list-group-item"  href="{{ route('admin.privacypolicy') }}">Privacy Policy</a>
                                            <a class="list-group-item"  href="{{ route('admin.tos') }}">Terms Of Service</a>
                                            <a class="list-group-item"  href="{{ route('admin.faq') }}">Faq</a>
                                            {{--                                    --}}
                                        @endif

                                        <a class="list-group-item " href="{{ route('profile.avatar.page', $user->username)  }}">Avatar</a>
                                        <a class="list-group-item" href="{{ route('profile.subscriptions', $user->username)  }}">My Subscriptions </a>
                                        <a class="list-group-item" href="{{ route('profile.favorites', $user->username)  }}">My Favorites</a>
                                        <a class="list-group-item" href="{{ route('profile.threads', $user->username)  }}">My Threads</a>
                                        <a class="list-group-item " href="{{ route('profile.likes', $user->username)  }}">My Likes</a>
                                        <a class="list-group-item active" href="{{ route('user.edit.password')  }}">Change Password</a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                           User Change Password
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-9 col-md-offset-3">
                                                    @if(session()->has('errormessage'))
                                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <strong>{{ session('errormessage')  }}</strong>
                                                            </div>
                                                    @endif
                                                    @if(session()->has('successmessage'))
                                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <strong>{{ session('successmessage')  }}</strong>
                                                            </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <form action="{{ route('user.update.password', $user->username) }}" class="form-horizontal" method="post">
                                                @csrf
                                                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                                    <label for="old_password" class="col-md-3 control-label">Old Password:</label>
                                                    <div class="col-md-9">
                                                        <input id="old_password" type="text" class="form-control" name="old_password" value="{{ old('old_password', $user->old_password) }}"  autofocus>
                                                        @if ($errors->has('old_password'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('old_password') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                    <label for="password" class="col-md-3 control-label">New Password:</label>
                                                    <div class="col-md-9">
                                                        <input id="password" type="password" class="form-control" name="password" >
                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                    <label for="password_confirmation" class="col-md-3 control-label">Confirm Password:</label>
                                                    <div class="col-md-9">
                                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  >
                                                        @if ($errors->has('password_confirmation'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                                    <div class="col-md-9 col-md-offset-3">
                                                        <input type="submit" class="btn btn-success" value="Change Password">
                                                        <a  class="btn btn-danger"  href="{{  route('profile', $user->username) }}"> Cancel</a>
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
@endsection


@section('head')
    <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" >
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.0.1/css/countrySelect.min.css" >

@endsection


@section('footer_script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"> </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/country-select-js/2.0.1/js/countrySelect.min.js"> </script>

    <script>
        $(document).ready(function () {
            $.fn.datepicker.defaults.format = "yyyy-mm-dd";

            $('#date_of_birth').datepicker({
//                format: 'yy-mm-dd',

            });

            $("#country").countrySelect({
                defaultCountry:'us',
                responsiveDropdown: true
            });

        });
    </script>
@endsection
