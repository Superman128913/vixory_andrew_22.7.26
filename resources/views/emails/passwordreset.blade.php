@component('mail::message')
# Reset your password

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $reset_url])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
