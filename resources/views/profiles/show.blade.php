@extends('layouts.app')

@section('content')
    <section class="hero is-desktop is-primary is-bold">
        <div class="hero-body">
            <div class="container">
                <div class="columns">
                    <div class="column is-4-tablet is-offset-2-desktop has-text-right has-text-centered-mobile is-bold">
                        <span class="has-text-white title">{{$profileUser->name}}</span>
                        <br>
                        <span class="subtitle">{{$profileUser->name}}@</span>
                        <div class="point">
                            <span class="has-text-light">امتیاز</span>
                            <h4 class="is-white is-1 title">
                                {{$profileUser->reputation}}
                            </h4>
                        </div>
                    </div>
                    <div class="column is-6-desktop is-8-tablet is-narrow">
                        <avatar-form :user="{{$profileUser}}"></avatar-form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="timeline is-rtl">
                    @forelse($activities as $date => $activity)
                        <header class="timeline-header">
                            <span class="tag is-medium is-primary">{{$date}}</span>
                        </header>
                        @foreach($activity as $record)
                            @if(view()->exists("profiles.activities.{$record->type}"))
                                @include("profiles.activities.{$record->type}",['activity' => $record])
                            @endif
                        @endforeach
                    @empty
                        <p>بدون فعالیت.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection