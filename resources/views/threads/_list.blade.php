@forelse ($threads as $thread)
    <div class="panel panel-default">

        <div class="panel-heading">
            <div class="panel-heading">

                <h4>
                    <a href="{{ $thread->path() }}">
                        @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                            <strong>
                                {{ $thread->title }}
                            </strong>
                        @else
                            {{ $thread->title }}
                        @endif
                    </a>
                </h4>

            </div>
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img src="{{ asset($thread->creator->avatar_path) }}"
                             alt="{{ $thread->creator->name }}"
                             width="25"
                             height="25"
                             class="mr-1 avatar-photo">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                         <small> Posted: {{ $thread->created_at->diffForHumans()  }}</small>
                    </h4>

                </div>
            </div>
        </div>


{{--        <div class="panel-heading">--}}
{{--            <div class="level">--}}
{{--                <div class="flex">--}}
{{--                    <h4>--}}
{{--                        <a href="{{ $thread->path() }}">--}}
{{--                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))--}}
{{--                                <strong>--}}
{{--                                    {{ $thread->title }}--}}
{{--                                </strong>--}}
{{--                            @else--}}
{{--                                {{ $thread->title }}--}}
{{--                            @endif--}}
{{--                        </a>--}}
{{--                    </h4>--}}

{{--                    <h5>--}}
{{--                        Posted By: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>--}}
{{--                    </h5>--}}
{{--                </div>--}}

{{--                <a href="{{ $thread->path() }}">--}}
{{--                    {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="panel-body">
            <div class="body">{!! $thread->body !!}</div>
        </div>

        <div class="panel-footer">
            {{ $thread->visits }} Visits
        </div>
    </div>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse