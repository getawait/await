<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    protected $table = 'waitlist';

    /**
     * Get the post that owns the comment.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
