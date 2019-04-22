@component('mail::message')
## You have been invited by: **{{$invite->team->owner->name}}**
## To join the team: **"{{$invite->team->name}}"**.

Ignore this message if you wish to decline the invitation.

Click this link to Accept the invitation: {{$url}}

@component('mail::button', ['url' => $url])
Accept Invitation
@endcomponent

Have a nice day!<br>
{{ config('app.name') }}
@endcomponent
