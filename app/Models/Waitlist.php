<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    use UsesUuid;

    protected $table = 'waitlist';

    protected $fillable = ['name', 'team_id'];

    /**
     * Get the post that owns the comment.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
