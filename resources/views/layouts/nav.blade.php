<nav class="navbar navbar-default is-transparent mb-0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#app-navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="https://bulma.io/images/bulma-logo.png" alt="" width="112" height="28">
        </a>
    </div>
    <div id="app-navbar-collapse" class="navbar-menu navbar-collapse">
        <div class="navbar-start">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/threads/create">تحلیل جدید</a>
                </li>
                <li>
                    <a href="{{route('analysis.index')}}">نمودار</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">ارزها <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($channels as $channel)
                            <li><a href="/threads/{{$channel->slug}}">{{$channel->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">تحلیل ها <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/threads">همه تحلیل ها</a>
                        </li>
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <li><a href="/threads?by={{auth()->user()->name}}">تحلیل های من</a></li>
                        @endif
                        <li><a href="/threads?popular=1">تحلیل های محبوب</a></li>
                        <li><a href="/threads?unanswered=1">تحلیل های بدون نظر</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="navbar-end">
            @if (Auth::guest())
                <div class="navbar-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a class="button is-info" href="{{route('register')}}">
                                <span>ثبت نام</span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-primary" href="{{route('login')}}">
                                <span>ورود</span>
                            </a>
                        </p>
                    </div>
                </div>
            @else
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">
                            {{ Auth::user()->name }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('profile',\Illuminate\Support\Facades\Auth::user())}}">پروفایل</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    خروج
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    <user-notifications></user-notifications>
                </ul>
            @endif
        </div>
    </div>
</nav>