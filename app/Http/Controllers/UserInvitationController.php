<?php

namespace \Http\Controllers;

use App\Controllers\Controller;
use App\Http\Requests\Auth\InviteUserRequest;
use App\Http\Requests\Auth\InviteUserStoreRequest;
use App\Mail\InvitationUserMail;
use App\Models\User;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserInvitationController extends Controller
{
    public function inviteUser(InviteUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt(Str::random(12)),
            'locale' => app(GeneralSettings::class)->default_locale,
            'active' => false,
            'invitation_sent_at' => now(),
        ])->assignRole($data['role_id']);

        static::sendInvitation(
            email: $data['email'],
            userFullName: Auth::user()->name,
        );

        return redirect()->back()->with(['message' => ___("craftable-pro", "User was succesfully invited.")]);
    }

    public function createInviteAcceptationUser($email)
    {
        $user = User::whereEmail($email)->firstOrFail();

        if (! $user->wasInvited()) {
            return redirect()->route("login");
        }

        return Inertia::render('Auth/InviteUser', [
            'email' => $email,
        ]);
    }

    public function storeInviteAcceptationUser(InviteUserStoreRequest $request)
    {
        $data = $request->validated();
        $user = User::whereEmail($data['email'])->first();
        $data['password'] = bcrypt($data['password']);
        $user->update($data + ['active' => true, 'invitation_accepted_at' => now()]);
        $user->markEmailAsVerified();

        return redirect()->route('login');
    }

    public static function sendInvitation(string $email, string $name)
    {
        Mail::to($email)->send(new InvitationUserMail([
            'email' => $email,
            'name' => $name,
        ]));
    }
}
