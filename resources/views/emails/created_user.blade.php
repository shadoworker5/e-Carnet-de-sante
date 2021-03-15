@component('mail::message')
# {{ $msg }}

- {{ "Login: $login" }}
- {{ "Password: $password" }}

# {{ "Pour tout autre informations, veuillez contacter les administrateurs." }}
@endcomponent