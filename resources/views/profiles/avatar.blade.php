
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
                                    <a class="list-group-item "  href="{{ route('profile', $user->username)  }}">Profile</a>

                                    @if($user->isAdmin)
                                        <a class="list-group-item"  href="{{ route('admin.setesettings') }}">Site Settings</a>

                                        {{--                                    For Admin--}}
                                        <a class="list-group-item"  href="{{ route('admin.tag') }}">Tags</a>
                                        <a class="list-group-item"  href="{{ route('admin.privacypolicy') }}">Privacy Policy</a>
                                        <a class="list-group-item"  href="{{ route('admin.tos') }}">Terms Of Service</a>
                                        <a class="list-group-item"  href="{{ route('admin.faq') }}">Faq</a>
                                        {{--                                    --}}
                                    @endif

                                    <a class="list-group-item active " href="{{ route('profile.avatar.page', $user->username)  }}">Avatar</a>
                                    <a class="list-group-item" href="{{ route('profile.subscriptions', $user->username)  }}">My Subscriptions </a>
                                    <a class="list-group-item" href="{{ route('profile.favorites', $user->username)  }}">My Favorites</a>
                                    <a class="list-group-item" href="{{ route('profile.threads', $user->username)  }}">My Threads</a>
                                    <a class="list-group-item " href="{{ route('profile.likes', $user->username)  }}">My Likes</a>
                                    <a class="list-group-item" href="{{ route('user.edit.password')  }}">Change Password</a>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <form action="{{ route('profile.avatar.change', $user->username)  }}" method="post" enctype="multipart/form-data" id="profilePhotoChange">
                                            @csrf
                                            <div class="col-md-4" >
                                                <img src="{{ asset($user->avatar_path)  }}" id="avatarImg" style="width: 80px; height: auto;">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="control-label" for="avatar">Select Your Profile Photo</label>
                                                    <input class="form-control" type="file" id="avatar" name="avatar" onchange="loadFile(event,'avatarImg')"/>
                                                </div>
                                                <br><br>
                                                <div class="form-group">
                                                    <button class="btn btn-success">Change Photo</button>
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
@endsection

@section('footer_script')
    <script>
        loadFile = function(event, id) {
            var output = document.getElementById(id);
            output.src = URL.createObjectURL(event.target.files[0]);
        };

        $(document).ready(function () {

            $('#profilePhotoChange').submit(function (event) {
                event.preventDefault();
                var form = $('#profilePhotoChange')[0];
                var data = new FormData(form);
                $.ajax({
                    url: "{{ route('profile.avatar.change', $user->username)  }}",
                    type: 'POST',
                    data: data,
                    beforeSend: function (xhr) {
                        $('#app_logo_form').find('.help-block').detach();
                        $('#app_logo_form').find('.form-group').removeClass('has-error');
                    },
                    processData: false, // Important!
                    contentType: false,
                    cache: false,
                    dataType: 'json',
                    success: function (resource) {
                        console.log();
                        $('#avatarphoto').attr('src', resource.avatar_path);
                        flash(resource.message, 'success');
                    },
                    error: function (error) {
                        console.log(error);

                    }
                });
            });
        });
    </script>
    @endsection