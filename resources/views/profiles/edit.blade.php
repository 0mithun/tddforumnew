
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
                                        @if($user->isAdmin)
                                            {{--                                    For Admin--}}
                                            <a class="list-group-item"  href="{{ route('admin.setesettings') }}">Site Settings</a>
                                            <a class="list-group-item"  href="{{ route('admin.tag') }}">Tags</a>
                                            <a class="list-group-item"  href="{{ route('admin.privacypolicy') }}">Privacy Policy</a>
                                            <a class="list-group-item"  href="{{ route('admin.tos') }}">Terms Of Service</a>
                                            <a class="list-group-item"  href="{{ route('admin.faq') }}">Faq</a>
                                            {{--                                    --}}
                                        @endif



                                        <a class="list-group-item " href="{{ route('profile.avatar.page', auth()->user()->username)  }}">Avatar</a>
                                        <a class="list-group-item" href="">My Favorites</a>
                                        <a class="list-group-item" href="">My Likes</a>
                                        <a class="list-group-item" href="">My Threads</a>
                                        <a class="list-group-item" href="">Password</a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Edit User Information
                                        </div>
                                        <div class="panel-body">
                                            <form action="{{ route('profile.user.update', $user->username) }}" class="form-horizontal" method="post">
                                                @csrf
                                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                    <label for="first_name" class="col-md-3 control-label">First Name:</label>
                                                    <div class="col-md-9">
                                                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}"  autofocus>
                                                        @if ($errors->has('first_name'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('first_name') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                    <label for="last_name" class="col-md-3 control-label">Last Name:</label>
                                                    <div class="col-md-9">
                                                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}"  >
                                                        @if ($errors->has('last_name'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('last_name') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <label for="email" class="col-md-3 control-label">Email:</label>
                                                    <div class="col-md-9">
                                                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}"  >
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                 <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                                    <label for="date_of_birth" class="col-md-3 control-label">Date of birth:</label>
                                                    <div class="col-md-9">
                                                        <input id="date_of_birth"  type="text" class="form-control" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                                        @if ($errors->has('date_of_birth'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('date_of_birth') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                                    <label for="city" class="col-md-3 control-label">City:</label>
                                                    <div class="col-md-9">
                                                        <input id="city" type="text" class="form-control" name="city" value="{{ old('city', $user->city) }}"  >
                                                        @if ($errors->has('city'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('city') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                 <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                                    <label for="country" class="col-md-3 control-label">Country:</label>
                                                    <div class="col-md-9">

                                                        <input id="country" type="text" class="form-control" name="country" value="{{ old('country', $user->country) }}"  >
                                                        @if ($errors->has('country'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('country') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                                    <label for="country" class="col-md-3 control-label">About:</label>
                                                    <div class="col-md-9">

                                                        <textarea name="about" id="about" cols="30" rows="5" class="form-control">{{ old('body', $user->about) }}</textarea>
                                                        @if ($errors->has('about'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('about') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                                    <div class="col-md-9 col-md-offset-3">
                                                        <input type="submit" class="btn btn-success" value="Edit Profile">
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
