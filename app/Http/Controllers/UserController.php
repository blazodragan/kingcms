<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\BulkDestroyUserRequest;
use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\ImpersonalLoginUserRequest;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Queries\Filters\FuzzyFilter;
use App\Queries\Sorts\SortNullsLast;
use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index(IndexUserRequest $request): Response | JsonResponse
    {
        $UsersQuery = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id',
                    'name',
                    'email',
                    'email_verified_at'
                )),
                AllowedFilter::callback('role', fn (Builder $query, $value) => $query->role($value)),
                AllowedFilter::callback('status', function (Builder $query, $value) {
                    if ($value === "pending") {
                        return $query->whereNull("email_verified_at");
                    } else {
                        return $query->whereActive($value)->whereNotNull("email_verified_at");
                    }
                }),
            ])
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'email', 'email_verified_at']);

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($UsersQuery->select(['id'])->pluck('id'));
        }

        $Users = $UsersQuery
            ->with('roles')
            ->select(['id', 'name', 'email', 'email_verified_at', 'active'])
            ->paginate(request()->get('per_page'))
            ->withQueryString();

        return Inertia::render('User/Index', [
            'users' => $Users,
            'filterOptions' => [
                'roles' => Role::all()->map->only(['name'])->pluck('name'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(): Response
    {
        $this->authorize('sanctum.user.create');
        $roles = Role::all();

        return Inertia::render('User/Create', [
            'locales' => app(GeneralSettings::class)->available_locales,
            'defaultLocale' => app(GeneralSettings::class)->default_locale,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $User = User::create($validated);

        $User->roles()->sync([$request->input('role_id')]);

        return redirect()->route('user.index')->with('toast', [
            'type' => 'success',
            'message' => __('User has been added'),
            'durration' => 2000,]);
        }

    /**
     * Display the specified resource.
     *
     * @param  User  $User
     */
    public function show(User $User)
    {
        $this->authorize('sanctum.user.show', $User);

        return Inertia::render('User/Show', [
            'User' => $User,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $User
     */
    public function edit(User $User)
    {
        $this->authorize('sanctum.user.edit', $User);

        $User->load('roles');

        $roles = Role::all();

        return Inertia::render('User/Edit', [
            'User' => $User,
            'avatar' => $User->getMedia('avatar'),
            'locales' => app(GeneralSettings::class)->available_locales,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $User
     */
    public function update(UpdateUserRequest $request, User $User)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        dd($validated);
        $User->update($validated);

        if ($request->input('role_id')) {
            $User->roles()->sync([$request->input('role_id')]);
        }

        if ($request->wantsJson()) {
            return response()->json('success');
        }

        return redirect()->route('user.index')->with('toast', [
            'type' => 'success',
            'message' => __('User has been updated'),
            'durration' => 2000,]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUserRequest $request
     * @param User $User
     */
    public function destroy(DestroyUserRequest $request, User $User)
    {
        $User->delete();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('User has been deleted'),
            'durration' => 2000,]);

    }

    /**
     * Resend verification notification for user.
     *
     * @param User $User
     */
    public function resendEmailVerificationNotification(User $User)
    {
        if (! $User->hasVerifiedEmail()) {
            if ($User->wasInvited()) {
                // FIXME: refactor mailable class
                UserInvitationController::sendInvitation(
                    email: $User->email,
                    userFullName: Auth::user()->first_name . " " . Auth::user()->last_name,
                );
            } else {
                $User->sendEmailVerificationNotification();
            }
        }

        
        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Operation successful'),
            'durration' => 2000,]);

    }

    /**
     * Bulk destroy users.
     *
     * @param BulkDestroyUserRequest $request
     */
    public function bulkDestroy(BulkDestroyUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    User::whereIn('id', $bulkChunk)->delete();
                });
        });

                
        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Operation successful'),
            'durration' => 2000,]);
    }

    /**
     * Bulk deactivate users.
     * @param BulkDestroyUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkDeactivate(BulkDestroyUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    User::whereIn('id', $bulkChunk)->update(['active' => false]);
                });
        });

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Operation successful'),
            'durration' => 2000,]);

    }

    /**
     * Bulk activate users.
     * @param BulkDestroyUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkActivate(BulkDestroyUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    User::whereIn('id', $bulkChunk)->update(['active' => true]);
                });
        });

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Operation successful'),
            'durration' => 2000,]);

    }

    public function impersonalLogin(ImpersonalLoginUserRequest $request, User $User)
    {
        Auth::login($User);

        return redirect()->route('dashboard');
    }

}
