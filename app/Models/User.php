<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function currentLists()
    {
        return $this->currentTeam->lists();
    }

    public function activeLists()
    {
        return $this->currentTeam->lists()->where('is_active', true);
    }

    /**
     * The list of all the subscribers across all of the users' lists
     */
    public function activeListsSubscribers(): Collection
    {
        $subscribers = collect();

        $lists = $this->currentTeam->lists()->get();

        foreach ($lists as $list) {
            $subscribers = $subscribers->merge($list->subscribers()->get());
        }

        return $subscribers;
    }

    /**
     * The percentage of users whom have been referred by another user
     */
    public function subscribersReferralRate()
    {
        $referredCount = 0;
        $subscribers = $this->activeListsSubscribers();

        $subscribers->each(function (Subscriber $subscriber) use (&$referredCount) {
            if ($subscriber->referrer_id) {
                $referredCount++;
            }
        });

        return ($referredCount / $subscribers->count()) * 100;
    }
}
