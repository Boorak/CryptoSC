@component('mail::message')
# Introduction

شما با موفقیت ثبت نام شدید. جهت فعال سازی حساب خود بر روی دکمه فعال سازی کلیک کنید.

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
فعال سازی
@endcomponent

با سپاس،<br>
{{ config('app.name') }}
@endcomponent
