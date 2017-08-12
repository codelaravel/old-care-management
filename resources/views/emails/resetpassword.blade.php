@component('mail::message')

@component('mail::panel')
To Reset Your Account Password Please Click The Button Below!
@endcomponent


@component('mail::button', ['url' => "http://lightofhopebd.dev/password/reset/$email/$code"])
Reset Password
@endcomponent

Thanks,<br>
Light Of Hope
@endcomponent