<section class="hero is-small is-info is-bold">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-vcentered">
                <div class="column">
                    <p class="title">
                        {{ config('app.name') }}
                    </p>
                    <p class="subtitle">
                        تحلیل های خودتان را به اشتراگ بگزارید
                    </p>
                </div>
                <div class="column is-narrow">
                    <div id="carboncontainer">
                        <div id="carbon" class="box">
                            <div class="carbon-item">
                                <div class="media">
                                    <div class="media-content is-clipped">
                                        <i class="fas fa-chart-line icon-lg"></i>
                                    </div>
                                    <div class="media-right">
                                        <div class="content carbon-text">
                                            <p class="is-text-4">تحلیل های ارسالی</p>
                                            @if(count(\App\Thread::all()))
                                                <p class="has-text-grey">
                                                    {{count(\App\Thread::all())}}
                                                </p>
                                            @else
                                                <p class="has-text-grey">
                                                    0
                                                </p>
                                            @endif
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
</section>