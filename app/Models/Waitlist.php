<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    use UsesUuid, HasFactory;

    protected $table = 'waitlists';

    protected $fillable = ['name', 'team_id'];

    /**
     * Get the post that owns the comment.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the post that owns the comment.
     */
    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}
