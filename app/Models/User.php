<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Media\AutoProcessMediaTrait;
use App\Media\HasMediaPreviewsTrait;
use App\Media\InteractsWithMedia;
use App\Media\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use InteractsWithMedia;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaPreviewsTrait;
    use TwoFactorAuthenticatable;
    use HasRoles;


    protected $guard = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'resource_url',
        'avatar',
        'avatar_url',
        'media_details',
    ];


        /**
     * Get the user's avatar media object.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getMedia('avatar')
        );
    }

    /**
     * Get the user's avatar URL.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getFirstMediaUrl('avatar', 'thumb')
        );
    }

        /**
     * Get the user's resource url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function resourceUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($this->id) {
                    return route('users.show', $this->id);
                }

                return null;
            }
        );
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->acceptsMimeTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/svg+xml'])
            ->maxFileSize(2 * 1024 * 1024)
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterPreviews();

        $this->addMediaConversion('thumb')
            ->crop('crop-center', 40, 40)
            ->performOnCollections('avatar');
    }

}
