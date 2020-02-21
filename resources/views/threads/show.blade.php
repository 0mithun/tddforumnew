@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include ('threads._question')
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                            </p>
                            <p>
                                <button class="btn btn-default"></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection

