@component('mail::message')
    # Доступ в панель администрации {{ config('app.name') }}

    Ваш логин: {{ $details['email'] }}<br>
    Ваш пароль: {{ $details['password'] }}

    @component('mail::button', ['url' => route('admin.home')])
        Войти
    @endcomponent


    С уважением, <br>
    {{ config('app.name') }}
@endcomponent
