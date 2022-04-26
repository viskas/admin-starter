@component('vendor.mail.html.message')
<h1 style="text-align: center">
    {{ __('Access to the administration panel') }} {{ config('app.name') }}
</h1>

<p style="text-align: center">
<b>{{ __('Your login:') }}</b> {{ $details['email'] }} <br>
<b>{{ __('Your password:') }}</b> {{ $details['password'] }}
</p>

@component('vendor.mail.html.button', ['url' => route('admin.home')])
    {{ __('Login') }}
@endcomponent

@endcomponent
