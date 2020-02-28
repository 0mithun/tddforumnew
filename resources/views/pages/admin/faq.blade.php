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
                                    <img src="{{ asset($user->avatar_path)  }}" class="img-circle" alt="Cinque Terre" style="width:60px; height: auto;">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="list-group">
                                        <a class="list-group-item "  href="{{ route('profile', $user->username)  }}">Profile</a>

                                        {{--                                    For Admin--}}
{{--                                        <a class="list-group-item active"  href="{{ route('admin.tag') }}">Tags</a>--}}
                                        {{--                                    --}}
                                        @if($user->isAdmin)
                                            {{--                                    For Admin--}}
                                            <a class="list-group-item"  href="{{ route('admin.tag') }}">Tags</a>
                                            <a class="list-group-item"  href="{{ route('admin.privacypolicy') }}">Privacy Policy</a>
                                            <a class="list-group-item"  href="{{ route('admin.tos') }}">Terms Of Service</a>
                                            <a class="list-group-item active"  href="{{ route('admin.faq') }}">Faq</a>
                                            {{--                                    --}}
                                        @endif


                                        <a class="list-group-item " href="{{ route('profile.avatar.page', $user->username)  }}">Avatar</a>
                                        <a class="list-group-item" href="{{ route('profile.subscriptions', $user->username)  }}">My Subscriptions </a>
                                        <a class="list-group-item" href="{{ route('profile.favorites', $user->username)  }}">My Favorites</a>
                                        <a class="list-group-item" href="{{ route('profile.threads', $user->username)  }}">My Threads</a>
                                        <a class="list-group-item" href="{{ route('profile.likes', $user->username)  }}">My Likes</a>
                                        <a class="list-group-item" href="{{ route('user.edit.password')  }}">Change Password</a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="panel">
                                        <div class="panel-heading" style="padding: 0px 10px">

                                            @if(session()->has('successmessage'))
                                                <div class="row">
                                                    <div class="alert alert-success alert-dismissible" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <strong>{{ session('successmessage')  }}</strong>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
{{--                                        <new-tag></new-tag>--}}
                                        <div class="panel-body" style="padding-top: 0px">
                                            <form action="{{  route('admin.faq.update') }}" method="post" class="form-horizontal">
                                                @csrf
                                                <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                                    <label for="body" class="col-md-2 control-label">Faq Body </label>

                                                    <div class="col-md-10">
                                                        <textarea name="body" id="body" cols="30" rows="10" class="form-control">{{ $adminInfo->faq }}</textarea>
                                                        @if ($errors->has('body'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('body') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <input type="submit" value="Update" class="btn btn-primary">
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

@section('footer_script')
    <script>
        tinymce.init({
            selector: '#body',
            plugins: 'a11ychecker advcode casechange formatpainter linkchecker lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>
    @endsection