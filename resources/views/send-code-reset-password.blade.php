@component('mail::message')
    <h1>We have received your request to reset your account password</h1>
    <p>You can use the following code to recover your account:</p>

    @component('mail::panel')
        <center><h1>{{ $code }}</h1></center>
    @endcomponent

    <p>The allowed duration of the code is 40 min from the time the message was sent</p>
@endcomponent
