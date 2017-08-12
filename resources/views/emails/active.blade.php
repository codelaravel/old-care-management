@component('mail::message')

@component('mail::panel')
To Active Your Account Please Click The Link Below!
@endcomponent


@component('mail::button', ['url' => "http://lightofhopebd.dev/activate/$email/$code"])
Active account
@endcomponent

Thanks,<br>
Light Of Hope
@endcomponent
