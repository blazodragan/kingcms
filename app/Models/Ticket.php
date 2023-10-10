<?php

namespace App\Models;
use App\Traits\HasPhoto;
use Spatie\Tags\HasTags;
use App\Enums\Priority;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
class Ticket extends Model
{
    use HasFactory;
    use HasPhoto;
    use HasTags;
    use HasUlids;

    protected $guarded = [];

    // this will set up the no_photo url from HasPhoto getPhotoUrlAttribute
    protected $appends = [
        'photo_url',
    ];
    // IMPORTANT : if you want to edit by uuid you need to change the RouteKeyName for Modal Bining
    public function getRouteKeyName(): string
    {
        return 'uuid'; // This should return the column name that you wish to use for routing
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Messages RelationShip
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

     /**
     * Get Assigned To User RelationShip
     */
    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function scopeStatus(Builder $builder, $status): Builder
    {
        if (!is_null($status)) {
            $builder->where('status', $status);
        }

        return $builder;
    }
    public function scopePriority(Builder $builder, $priority): Builder
    {
        if (!is_null($priority)) {
            $builder->where('priority', $priority);
        }

        return $builder;
    }

    public function scopeSearch(Builder $builder, $term): Builder
    {
        if (!is_null($term)) {
            $builder->where('title', 'LIKE', "%$term%");
        }

        return $builder;
    }
    public function scopeTag(Builder $builder, $tags): Builder
    {
        if (!is_null($tags)) {
            $builder->withAnyTags([$tags], 'ticket');
        }

        return $builder;
    }
    public function scopeOrder(Builder $builder, $orderby): Builder
    {
        if (!is_null($orderby)) {
            $builder->orderBy($orderby,'desc');
        } else {
            $builder->orderBy('created_at','desc');
        }

        return $builder;
    }
    public function scopeResults(Builder $builder, $results=12): Builder
    {
        if (!is_null($results)) {
            $builder->paginate(12);
        }

        return $builder;
    }


    /**
     * Get closed tickets
     */
    // public function scopeClosed(Builder $builder): Builder
    // {
    //     return $builder->where('status', Status::CLOSED->value);
    // }

    // /**
    //  * Get opened tickets
    //  */
    // public function scopeOpened(Builder $builder): Builder
    // {
    //     return $builder->where('status', Status::OPEN->value);
    // }

    /**
     * Get resolved tickets
     */
    public function scopeResolved(Builder $builder): Builder
    {
        return $builder->where('is_resolved', true);
    }

    /**
     * Get unresolved tickets
     */
    public function scopeUnresolved(Builder $builder): Builder
    {
        return $builder->where('is_resolved', false);
    }

    /**
     * Get locked tickets
     */
    public function scopeLocked(Builder $builder): Builder
    {
        return $builder->where('is_locked', true);
    }

    /**
     * Get unlocked tickets
     */
    public function scopeUnlocked(Builder $builder): Builder
    {
        return $builder->where('is_locked', false);
    }

    /**
     * Get custom priority tickets
     */
    public function scopeWithPriority(Builder $builder, string $priority): Builder
    {
        return $builder->where('priority', $priority);
    }

    /**
     * Get low priority tickets
     */
    public function scopeWithLowPriority(Builder $builder): Builder
    {
        return $builder->where('priority', Priority::LOW->value);
    }

    /**
     * Get normal priority tickets
     */
    public function scopeWithNormalPriority(Builder $builder): Builder
    {
        return $builder->where('priority', Priority::NORMAL->value);
    }

    /**
     * Get high priority tickets
     */
    public function scopeWithHighPriority(Builder $builder): Builder
    {
        return $builder->where('priority', Priority::HIGH->value);
    }

    /**
     * Get archived tickets
     */
    public function scopeArchived(Builder $builder): Builder
    {
        return $builder->where('status', Status::ARCHIVED->value);
    }

    /**
     * Get unarchived tickets
     */
    public function scopeUnArchived(Builder $builder): Builder
    {
        return $builder->whereNot('status', Status::ARCHIVED->value);
    }

}
