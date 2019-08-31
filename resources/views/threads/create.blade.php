@extends('layouts.app')

@section('stylesheets')
    <script src='https://www.google.com/recaptcha/api.js?hl=fa'></script>
@endsection

@section('content')

    <section class="hero is-primary is-bold">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    تحلیل جدید
                </h1>
            </div>
        </div>
    </section>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <figure class="image">
                                    <img src="{{$analysis->image_full_path}}" alt="تحلیل ارز دیجیتال">
                                </figure>
                            </div>

                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <form action="/threads/{{$analysis->id}}" method="POST">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="channel_id" class="has-text-grey-dark">ارز :</label>
                                    <select name="channel_id" id="channel_id" class="form-control">
                                        <option value="">انتخاب...</option>
                                        @foreach($channels as $channel)
                                            <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>
                                                {{$channel->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="title" class="has-text-grey-dark">توضیحات مختصر :</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{old('title')}}">
                                </div>
                                <div class="form-group">
                                    <label for="body" class="has-text-grey-dark">توضیحات کامل :</label>
                                    <wysiwyg name="body"></wysiwyg>
                                </div>

                                <div class="form-group">
                                    <div class="g-recaptcha"
                                         data-sitekey="{{config('podonak.recaptcha.key')}}"></div
                                </div>
                                <div class="form-group mt-30">
                                    <button type="submit" class="btn btn-success btn-block">ثبت</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
