@extends('layouts.app')

@section('content')
    <div class="hero is-large">
        <div class="hero-body">
            <div class="container">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                فرم ثبت نام
                            </div>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">نام کاربری</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control">
                                                <input class="input {{ $errors->has('name') ? ' is-danger' : '' }}"
                                                       type="text" value="{{ old('name') }}"
                                                       name="name"
                                                       id="name">
                                            </div>
                                            @if ($errors->has('name'))
                                                <p class="help is-danger">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">ایمیل</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control">
                                                <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}"
                                                       type="email" value="{{ old('email') }}"
                                                       name="email"
                                                       id="email">
                                            </div>
                                            @if ($errors->has('email'))
                                                <p class="help is-danger">{{ $errors->first('email') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">رمز عبور</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control">
                                                <input class="input {{ $errors->has('password') ? ' is-danger' : '' }}"
                                                       type="password"
                                                       name="password"
                                                       id="password">
                                            </div>
                                            @if ($errors->has('password'))
                                                <p class="help is-danger">{{ $errors->first('password') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">تکرار رمز عبور</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control">
                                                <input class="input"
                                                       type="password"
                                                       name="password_confirmation"
                                                       id="password-confirm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field is-horizontal">
                                    <div class="field-label">
                                        <!-- Left empty for spacing -->
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control is-pulled-right">
                                                <button type="submit" class="button is-primary">
                                                    ثبت نام
                                                </button>
                                            </div>
                                            <div class="is-clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
