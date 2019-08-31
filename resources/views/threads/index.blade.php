@extends('layouts.app')

@section('content')

    @include('threads._threads_index_header')

    <div class="section">
        <section class="is-small">
            <div class="container">
                <div class="columns">
                    <div class="column is-8">
                        @include('threads._list')
                        <div class="pagination">
                            {{$threads->render()}}
                        </div>
                    </div>
                    <div class="column">
                        @if(count($trending))
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header-title">
                                        پربازدیدها
                                    </div>
                                    <div class="card-header-icon">
                                        <i class="fas fa-fire has-text-danger"></i>
                                    </div>
                                </div>
                                <div class="card-content">
                                    @foreach($trending as $thread)
                                        <div class="media">
                                            <div class="media-content is-clipped">
                                                <a href="{{url($thread->path)}}" class="is-pulled-right">
                                                    {{str_limit($thread->title,30)}}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection
