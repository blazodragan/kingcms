<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

trait HasPhoto
{
    /**
     * Update the photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updatePhoto(UploadedFile $photo)
    {
        tap($this->photo_path, function ($previous) use ($photo) {$this->forceFill(['photo_path' => $photo->storePublicly('photos', ['disk' => $this->photoDisk()]),])->save();
            if ($previous) {Storage::disk($this->photoDisk())->delete($previous);}
        });
    }

    /**
     * Delete the photo.
     *
     * @return void
     */
    public function deletePhoto()
    {
        if (is_null($this->photo_path)) {
            return;
        }

        Storage::disk($this->photoDisk())->delete($this->photo_path);

        $this->forceFill([
            'photo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path ? Storage::disk($this->photoDisk())->url($this->photo_path) : Storage::disk($this->photoDisk())->url('no_photo.png');
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function photoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }
}
