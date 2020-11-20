<?php

namespace App\Models;

use App\Utils\MoveElement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $referrer
 * @property int $modifier
 */
class Subscriber extends Model
{
    use HasFactory;

    protected $table = 'subscribers';

    public function getPosition(): int
    {
        // todo
        $subscribers = Subscriber::all()->sortBy('created_at');

        foreach ($subscribers as $subscriber) {
            $subscriber->modifier = $subscribers
                ->where('referrer_id', $subscriber->id)
                ->count();
        }

        $subscribers = $subscribers->toArray();

        foreach ($subscribers as $key => $subscriber) {
            MoveElement::moveElement($subscribers, $key, $key - $subscriber['modifier']);
        }

        return array_key_first(
                collect($subscribers)
                    ->where('id', $this->id)
                    ->toArray()
            ) + 1;
    }

    public function waitlist()
    {
        return $this->belongsTo(Waitlist::class);
    }

    /**
     * Get the list of subscribers this subscriber has referred
     */
    public function referred()
    {
        return $this->hasMany(Subscriber::class, 'referrer_id');
    }
}
