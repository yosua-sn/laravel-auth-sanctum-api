@component('mail::message')
# Hello {{ $name }}

Thank you for signing up.

Please click the button below to verify your email address:

@component('mail::button', ['url' => $url])
Verify Email
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
