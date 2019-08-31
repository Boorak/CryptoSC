@extends('layouts.app')

@section('content')
    <div class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                بازیابی رمز عبور
                            </div>
                        </div>
                        <div class="card-content">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}

                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">ایمیل</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control">
                                                <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}"
                                                       type="email" value="{{ old('email') }}"
                                                       name="email" id="email">
                                            </div>
                                            @if ($errors->has('email'))
                                                <p class="help is-danger">{{ $errors->first('email') }}</p>
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
                                                    بازیابی
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
