@component('mail::message')
# Thank you for using Vixory!

We appreciate all of the athletes and coaches who use our platform! In order to continually improve our platform we ask all of our users to complete our user satisfaction survey.

@component('mail::button', ['url' => $url])
    User Satisfaction Survey
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
