@component('mail::message')
# Welcome to Our Application

Hello {{ $user->username }},

Welcome to our application! We are excited to have you on board.

Thank you,<br>
{{ config('app.name') }}
@endcomponent
