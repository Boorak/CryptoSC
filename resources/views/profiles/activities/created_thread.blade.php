@component('profiles.activities.activity')

    @slot('header')

        <div class="is-inline-flex">
            <a href="{{route('profile',$profileUser)}}">
                {{$profileUser->name}}
            </a>
            <span class="text-muted mr-1by2">
                ثبت تحلیل
            </span>
            <a href="{{$activity->subject->path()}}" class="mr-1by2">
                {{$activity->subject->title}}
            </a>
            <span class="text-muted mr-1by2">
                {{$activity->created_at->diffForHumans()}}
            </span>
        </div>
    @endslot

    @slot('body')
        {!! $activity->subject->body !!}
    @endslot

@endcomponent