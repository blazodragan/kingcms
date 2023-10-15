<x-mail::message>

# {{ ___('kingcms', 'Invite user') }}

You were invited by user {{ $userFullName }} to join {{ config('app.name') }}.

Please follow the link bellow to create your account.

<x-mail::button :url="route('invite-user.create', $email)">
{{ ___('kingcms', 'Sign in') }}
</x-mail::button>

</x-mail::message>
