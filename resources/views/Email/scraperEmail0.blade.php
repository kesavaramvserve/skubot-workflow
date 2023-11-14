@component('mail::message')
# {{ $mailData['title'] }}
The Client Details are:<br>
<strong>Website: </strong> {{ $mailData['website'] }}<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
