@extends('layouts.app')

@section('content')

    <section class="hero is-bold is-info">
        <div class="hero-body">
            <div class="container">
                <div class="columns">
                    <div class="column is-vertically-centered">
                        <div class="is-text-column">
                            <h1 class="title">
                                پودونک
                            </h1>
                            <h2 class="subtitle">
                                مجمع تحلیل و مبادله ارزهای دیجیتال
                            </h2>
                        </div>
                    </div>
                    <div class="column">
                        <figure class="image is-3by2">
                            <img src="{{asset('images/graph.svg')}}" alt="">
                        </figure>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="section is-medium">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <p class="title has-text-centered">همین حالا شروع کنید</p>
                    <div class="hero-buttons">
                        <a href="{{route('analysis.index')}}" class="button is-primary is-large">
                            ارسال تحلیل
                        </a>
                        <a href="{{route('threads')}}" class="button is-link is-large mr-1">
                            مشاهده تحلیل ها
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section section-tile-landing">
        <div class="container">
            @include('_tile')
        </div>
    </div>


    <section class="hero is-info is-fullheight trading-section">
        <div class="hero-body">
            <div class="container">
                <div class="columns">
                    <div class="column">
                        <h1 class="title">
                            پلتفرم آموزشی مبادله ارز دیجیتال
                        </h1>
                        <h2 class="subtitle">
                            به راحتی و بدون هیچ هزینه ای شروع به یادگیری مبادله ارز دیجیتال کنید
                        </h2>
                    </div>
                    <div class="column has-text-centered">
                        <div class="content">
                            <p class="has-text-justified">
                                اگر شما تازه قصد ورود به بازار ارز دیجیتال دارید این جا بهترین جا برای شروع است. به دلیل
                                نوسان زیاد قیمت در بازار ارز دیجیتال در صورت تازه کار بودن ممکن است متحمل ضرر زیادی شوید
                                (دیدم که میگم!!! :) ) پس بهتر است قبل از ورود به بازار اصلی با استفاده از سامانه مبادله
                                ارز
                                دیجیتال پودونک که کاملا با پلتفرم های موجود یکسان است شروع به معامله کردن کنید و پس از
                                یادگیری و آشنا شدن وارد بازار اصلی شوید.
                            </p>
                            <a href="https://demo.podonak.com/" class="button is-large trading-btn">ورود به بازار</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{--<div class="section is-medium chart-section">--}}
    {{--<div class="container">--}}
    {{--<div class="columns">--}}
    {{--<div class="column has-text-centered box">--}}
    {{--<p class="title has-text-grey-dark">نمودار لحظه ای قیمت</p>--}}
    {{--</div>--}}
    {{--<div class="column has-text-centered">--}}
    {{--<a href="{{route('analysis.index')}}" class="button is-info is-large is-rounded">--}}
    {{--<i class="fas fa-chart-bar"></i>--}}
    {{--<span class="mr-1">--}}
    {{--مشاهده نمودار--}}
    {{--</span>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="section is-medium is-mobile has-text-centered">
        <div class="container">
            <div class="content">
                <p class="title has-text-grey-dark">
                    نرخ ارز پودونک از کجا تامین می شود؟
                </p>
                <p class="subtitle has-text-grey-dark">
                    در پودونک نرخ ها از اکسچنج های معتبر زیر تامین می شود.
                </p>
            </div>
            <div class="columns">
                <div class="column">
                    <figure class="image is-16by9">
                        <img src="{{asset('images/bifinex.svg')}}" alt="bitfinex">
                    </figure>
                </div>
                <div class="column is-hidden-mobile"></div>
                <div class="column">
                    <figure class="image is-16by9">
                        <img src="{{asset('images/binance.svg')}}" alt="binance">
                    </figure>
                </div>
            </div>
        </div>
    </div>

@endsection
