<x-mail::message>

# Invite user

You were invited by user {{ $name }} to join {{ config('app.name') }}.

Please follow the link bellow to create your account.

<x-mail::button :url="route('invite-user.create', $email)">
Sign in
</x-mail::button>

</x-mail::message>
