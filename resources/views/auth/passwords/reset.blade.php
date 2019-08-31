@extends('layouts.app')

@section('content')
    <div class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                تغییر رمز عبور
                            </div>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{ route('password.request') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">

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
                                        <label class="label">رمز عبور</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control">
                                                <input class="input {{ $errors->has('password_confirmation') ? ' is-danger' : '' }}"
                                                       type="password"
                                                       name="password_confirmation"
                                                       id="password-confirm">
                                            </div>
                                            @if ($errors->has('password_confirmation'))
                                                <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                            @endif
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
                                                    اعمال تغییرات
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
